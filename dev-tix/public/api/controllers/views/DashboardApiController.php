<?php

require_once __DIR__ . '/../../classes/AbsApiController.php';

class DashboardApiController extends AbsApiController
{
    public function get()
    {
        $data = $this->getAllTicketRequests();

        if (empty($data)) {
            return ApiMessage::dataFetchAttempt($data);
        }

        $return = [];
        if (count($data) > 1) {
            foreach ($data as $item) {
                $return[] = $this->extractData($item);
            }

            return ApiMessage::dataFetchAttempt($return);
        }

        $return[] = $this->extractData($data);

        return ApiMessage::dataFetchAttempt($return);
    }

    private function extractData(array $data)
    {
        return [
            'ticket' => $data,
            'patron' => $this->getUserData($data, 'patron'),
            'assistant' => $this->getUserData($data, 'assistant')
        ];
    }

    private function getAllTicketRequests()
    {
        return Session::getDbInstance()->executeQuery(
            'SELECT * FROM ticket_requests;'
        )->getQueryResult();
    }

    private function getUserData(array $data, string $userType)
    {
        $query = 'SELECT * FROM users WHERE user_id = :user_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $data["{$userType}_id"]]
        )->getQueryResult();
    }
}
