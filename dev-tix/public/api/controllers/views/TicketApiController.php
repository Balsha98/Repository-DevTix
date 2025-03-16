<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';
require_once __DIR__ . '/../data/TicketInputRules.php';

class TicketApiController extends AbsApiController
{
    public function get()
    {
        $return = [];
        $ticketID = $this->getId();

        $ticketData = $this->getRequestData($ticketID);

        if (empty($ticketData)) {
            return ApiMessage::dataFetchAttempt($ticketData);
        }

        $return['request'] = $ticketData;
        $responses = $this->getResponsesData($ticketID);
        if (!empty($responses)) {
            foreach ($responses as $response) {
                $return['responses'][] = $response;
            }
        }

        return ApiMessage::dataFetchAttempt($return);
    }

    public function post()
    {
        $data = $this->getData();

        if (!empty(Validate::validateInputs($data, TicketInputRules::RULES))) {
            return Validate::getValidationResult();
        }

        $action = $data['action'];

        // Request posted by patron.
        if ($action === 'post/request') {
            if (isset($this->insertNewRequest($data)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            return ApiMessage::alertDataAlterAttempt(true, "/ticket/{$this->getLastInsertId()}");
        } else if ($action === 'post/images') {
            if (!empty($_FILES)) {
                $ticketID = $this->getLastInsertId();

                foreach ($_FILES as $image) {
                    $imageData = file_get_contents($image['tmp_name']);
                    $this->uploadRequestImage($ticketID, $imageData);
                }

                return ApiMessage::alertDataAlterAttempt(true);
            }
        }

        // Responses posted by either user.
        if ($action === 'post/response') {
        }
    }

    private function getRequestData(int $ticketID)
    {
        $query = 'SELECT * FROM ticket_requests WHERE request_id = :request_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':request_id' => $ticketID]
        )->getQueryResult();
    }

    private function getResponsesData(int $ticketID)
    {
        $query = 'SELECT * FROM ticket_responses WHERE request_id = :request_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':request_id' => $ticketID]
        )->getQueryResult();
    }

    private function insertNewRequest(array $data)
    {
        $query = '
            INSERT INTO ticket_requests (
                patron_id, type, subject, question
            ) VALUES (
                :patron_id, :type, :subject, :question 
            );
        ';

        return Session::getDbInstance()->executeQuery($query, [
            ':patron_id' => $data['patron_id'], ':type' => $data['type'] ?? $data['custom_type'],
            ':subject' => $data['subject'], ':question' => $data['question']
        ])->getQueryResult();
    }

    private function uploadRequestImage(int $ticketID, string $image)
    {
        $query = 'INSERT INTO request_images (request_id, request_image) VALUES (:request_id, :request_image);';
        return Session::getDbInstance()->executeQuery(
            $query, [':request_id' => $ticketID, ':request_image' => $image]
        )->getQueryResult();
    }

    private function getLastInsertId()
    {
        return Session::getDbInstance()->executeQuery(
            'SELECT MAX(request_id) as id FROM ticket_requests;'
        )->getQueryResult()['id'];
    }
}
