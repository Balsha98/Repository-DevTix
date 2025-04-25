<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class DashboardApiController extends AbsApiController
{
    public function get()
    {
        $return = [];

        // In case an admin user is logged in.
        if ((int) Session::get('role_id') === 1) {
            $return['overviews'] = $this->extractAdminOverviewData();
        }

        $data = $this->getAllTicketsInOrder();

        // Get all present tickets.
        if (!isset($data['request_id'])) {
            foreach ($data as $item) {
                $return['tickets'][] = $this->extractTicketData($item);
            }

            return ApiMessage::dataFetchAttempt($return);
        }

        // Check if any exist.
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

    // ***** HELPER DATABASE FUNCTIONS ***** //

    private function getAllTicketsInOrder()
    {
        return Session::getDbInstance()->executeQuery(
            'SELECT * FROM ticket_requests ORDER BY posted_at DESC;'
        )->getQueryResult();
    }

    private function getRowCount(string $tableName, string $column)
    {
        return Session::getDbInstance()->executeQuery(
            "SELECT COUNT({$column}) AS total FROM {$tableName};"
        )->getQueryResult()['total'];
    }

    private function getAllTicketsPerStatus(string $status)
    {
        $query = 'SELECT COUNT(request_id) AS total FROM ticket_requests WHERE status = :status;';
        return Session::getDbInstance()->executeQuery(
            $query, [':status' => $status]
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
