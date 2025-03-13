<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class DashboardApiController extends AbsApiController
{
    public function get()
    {
        $return = [];

        // In case an admin user is logged in.
        if (Session::get('role_id') === 1) {
            $return['overviews'] = $this->extractAdminOverviewData();
        }

        $data = $this->getAllRows('ticket_requests');

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

    private function extractAdminOverviewData()
    {
        return [
            'tickets' => $this->getRowCount('ticket_requests', 'request_id'),
            'resolved' => $this->getAllTicketsPerStatus('resolved'),
            'cancelled' => $this->getAllTicketsPerStatus('cancelled'),
            'users' => $this->getRowCount('users', 'user_id')
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

    private function getAllRows(string $tableName)
    {
        return Session::getDbInstance()->executeQuery(
            "SELECT * FROM {$tableName};"
        )->getQueryResult();
    }

    private function getRowCount(string $tableName, string $column)
    {
        return Session::getDbInstance()->executeQuery(
            "SELECT COUNT({$column}) as total FROM {$tableName};"
        )->getQueryResult()['total'];
    }

    private function getAllTicketsPerStatus(string $status)
    {
        $query = 'SELECT COUNT(request_id) as total FROM ticket_requests WHERE status = :status;';
        return Session::getDbInstance()->executeQuery(
            $query, [':status' => $status]
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
