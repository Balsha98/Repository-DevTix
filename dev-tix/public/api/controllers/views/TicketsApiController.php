<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class TicketsApiController extends AbsApiController
{
    public function get()
    {
        $return = [];
        $viewAsUserID = Session::get('view_as_user_id');
        $viewAsRoleID = $this->getViewAsRoleId($viewAsUserID);

        if ($viewAsRoleID === 1) {
            return ApiMessage::dataFetchAttempt($return);
        }

        $data = $this->getAllTicketsPerUser($viewAsUserID, $viewAsRoleID);
        $return['overviews'] = $this->extractTicketsOverviewData($viewAsUserID, $viewAsRoleID);

        // Get all present tickets.
        if (count($data) > 1) {
            foreach ($data as $item) {
                $return['tickets'][] = $this->extractTicketData($item);
            }

            return ApiMessage::dataFetchAttempt($return);
        }

        if (!empty($data)) {
            $return['tickets'] = $this->extractTicketData($data);
        }

        return ApiMessage::dataFetchAttempt($return);
    }

    private function extractTicketsOverviewData(int $userID, int $roleID)
    {
        return [
            'tickets' => count($this->getAllTicketsPerUser($userID, $roleID)),
            'resolved' => $this->getAllTicketsForUserPerStatus($userID, $roleID, 'resolved'),
            'pending' => $this->getAllTicketsForUserPerStatus($userID, $roleID, 'pending'),
            'cancelled' => $this->getAllTicketsForUserPerStatus($userID, $roleID, 'cancelled'),
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

    private function getAllTicketsPerUser(int $userID, int $roleID)
    {
        $roleType = $roleID === 2 ? 'assistant' : 'patron';
        $query = "SELECT * FROM ticket_requests WHERE {$roleType}_id = :user_id;";
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
        )->getQueryResult();
    }

    private function getViewAsRoleId(int $userID)
    {
        $query = 'SELECT role_id FROM users WHERE user_id = :user_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
        )->getQueryResult()['role_id'];
    }

    private function getAllTicketsForUserPerStatus(int $userID, int $roleID, string $status)
    {
        $roleType = $roleID === 2 ? 'assistant' : 'patron';
        $query = "SELECT COUNT(request_id) as total FROM ticket_requests WHERE {$roleType}_id = :user_id AND status = :status;";
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID, ':status' => $status]
        )->getQueryResult()['total'];
    }

    private function getUserData(array $data, string $userType)
    {
        $query = 'SELECT * FROM users WHERE user_id = :user_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $data["{$userType}_id"]]
        )->getQueryResult();
    }
}
