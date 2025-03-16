<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

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
        print_r($_FILES);
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
}
