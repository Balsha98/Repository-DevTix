<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class TicketsApiController extends AbsApiController
{
    public function get()
    {
        $viewAsUserID = $this->getId();
        $viewAsRoleID = $this->getViewAsRoleId($viewAsUserID);
        $return = [];

        $data = $this->getAllTicketsPerUser($viewAsUserID, $viewAsRoleID);
        $return['overviews'] = $this->extractTicketsOverviewData($viewAsUserID, $viewAsRoleID);

        // Get all related tickets, if more than 1.
        if (!isset($data['request_id'])) {
            if (count($data) > 1) {
                foreach ($data as $item) {
                    $return['tickets'][] = $this->extractTicketData($item);
                }

                return ApiMessage::dataFetchAttempt($return);
            }
        }

        if (!empty($data)) {
            $return['tickets'] = $this->extractTicketData($data);
        }

        return ApiMessage::dataFetchAttempt($return);
    }

    private function extractTicketsOverviewData(int $userID, int $roleID)
    {
        return [
            'tickets' => $this->getAllTicketsCountForUser($userID, $roleID),
            'resolved' => $this->getAllTicketsCountForUserPerStatus($userID, $roleID, 'resolved'),
            'pending' => $this->getAllTicketsCountForUserPerStatus($userID, $roleID, 'pending'),
            'cancelled' => $this->getAllTicketsCountForUserPerStatus($userID, $roleID, 'cancelled'),
        ];
    }

    private function extractTicketData(array $data)
    {
        return [
            'ticket' => $data,
            'patron' => $this->getUserData($data, 'patron'),
            'assistant' => $this->getUserData($data, 'assistant')
        ];
    }

    // ***** HELPER DATABASE FUNCTIONS ***** //

    private function getViewAsRoleId(int $userID)
    {
        $query = 'SELECT role_id FROM users WHERE user_id = :user_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
        )->getQueryResult()['role_id'];
    }

    private function getAllTicketsPerUser(int $userID, int $roleID)
    {
        $roleType = $roleID === 2 ? 'assistant' : 'patron';
        $query = "SELECT * FROM ticket_requests WHERE {$roleType}_id = :user_id;";
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
        )->getQueryResult();
    }

    private function getAllTicketsCountForUser(int $userID, int $roleID)
    {
        $roleType = $roleID === 2 ? 'assistant' : 'patron';
        $query = "SELECT COUNT(request_id) as total FROM ticket_requests WHERE {$roleType}_id = :user_id;";
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
        )->getQueryResult()['total'];
    }

    private function getAllTicketsCountForUserPerStatus(int $userID, int $roleID, string $status)
    {
        $roleType = $roleID === 2 ? 'assistant' : 'patron';
        $query = "SELECT COUNT(request_id) as total FROM ticket_requests WHERE {$roleType}_id = :user_id AND status = :status;";
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID, ':status' => $status]
        )->getQueryResult()['total'];
    }

    private function getUserData(array $data, string $userType)
    {
        $query = 'SELECT * FROM users JOIN user_details ON users.user_id = user_details.user_id WHERE users.user_id = :user_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $data["{$userType}_id"]]
        )->getQueryResult();
    }
}
