<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';
require_once __DIR__ . '/../data/TicketInputRules.php';

class TicketApiController extends AbsApiController
{
    public function get()
    {
        $ticketID = $this->getId();
        $ticketData = $this->getRequestData($ticketID);

        if (empty($ticketData)) {
            return ApiMessage::dataFetchAttempt($ticketData);
        }

        $return['request'] = $ticketData;
        $return['responses'] = ['total_responses' => $this->getRowCount('response_id', 'ticket_responses', $ticketID)];
        $return['images'] = ['total_images' => $this->getRowCount('request_image_id', 'request_images', $ticketID)];

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

            $ticketID = $this->getLastInsertId();

            return ApiMessage::alertDataAlterAttempt(true, "/ticket/{$ticketID}");
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
            if (isset($this->insertNewResponse($data)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            $ticketID = $data['request_id'];
            $ticketData = $this->getRequestData($ticketID);

            $turnID = $data['user_id'];
            if ((int) $data['user_id'] === (int) $ticketData['turn_id']) {
                if ((int) $data['user_id'] === (int) $ticketData['patron_id']) {
                    $turnID = $ticketData['assistant_id'];
                } else {
                    $turnID = $ticketData['patron_id'];
                }
            }

            if (isset($this->updateRequestColumn('turn_id', $turnID, $ticketID)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            return ApiMessage::alertDataAlterAttempt(true);
        }
    }

    public function put()
    {
        $data = $this->getData();
        $action = $data['action'];
        $tickedID = $this->getId();
        $userID = $data['user_id'];
        $status = $data['status'];

        $columns = [
            'cancelled/request' => ['status' => $status],
            'pending/request' => ['assistant_id' => $userID, 'turn_id' => $userID, 'status' => $status],
            'resolved/request' => ['status' => $status]
        ];

        foreach ($columns[$action] as $column => $value) {
            if (isset($this->updateRequestColumn($column, $value, $tickedID)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }
        }

        if ($action === 'cancelled/request') {
            return ApiMessage::alertDataAlterAttempt(true, '/tickets');
        }

        return ApiMessage::alertDataAlterAttempt(true);
    }

    private function getRequestData(int $ticketID)
    {
        $query = 'SELECT * FROM ticket_requests WHERE request_id = :request_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':request_id' => $ticketID]
        )->getQueryResult();
    }

    private function getRowCount(string $column, string $table, int $ticketID)
    {
        $query = "SELECT COUNT({$column}) as total FROM {$table} WHERE request_id = :request_id;";
        return Session::getDbInstance()->executeQuery(
            $query, [':request_id' => $ticketID]
        )->getQueryResult()['total'];
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
            ':patron_id' => $data['user_id'], ':type' => $data['type'] ?? $data['custom_type'],
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

    private function insertNewResponse(array $data)
    {
        $query = '
            INSERT INTO ticket_responses (
                request_id, user_id, response
            ) VALUES (
                :request_id, :user_id, :response 
            );
        ';

        return Session::getDbInstance()->executeQuery($query, [
            ':request_id' => $data['request_id'], ':user_id' => $data['user_id'], 'response' => $data['response']
        ])->getQueryResult();
    }

    private function updateRequestColumn(string $column, mixed $value, int $requestID)
    {
        $query = "UPDATE ticket_requests SET {$column} = :{$column} WHERE request_id = :request_id;";
        return Session::getDbInstance()->executeQuery(
            $query, [":{$column}" => $value, ':request_id' => $requestID]
        )->getQueryResult();
    }

    private function getLastInsertId()
    {
        return Session::getDbInstance()->executeQuery(
            'SELECT MAX(request_id) as id FROM ticket_requests;'
        )->getQueryResult()['id'];
    }
}
