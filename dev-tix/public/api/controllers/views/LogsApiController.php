<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class LogsApiController extends AbsApiController
{
    public function get()
    {
        $logs = $this->getAllLogs();

        $return['logs'] = [];
        if (!isset($logs['log_id'])) {
            foreach ($logs as $log) {
                $return['logs'][] = $this->extractLogData($log);
            }

            return ApiMessage::dataFetchAttempt($return);
        }

        $return['logs'] = $this->extractLogData($logs);

        return ApiMessage::dataFetchAttempt($return);
    }

    private function extractLogData(array $data)
    {
        return [
            'log_id' => $data['log_id'],
            'user_id' => $data['user_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'role_id' => $data['role_id'],
            'user_image' => $data['user_image'],
            'user_image_type' => $data['user_image_type'],
            'title' => $data['title'],
            'message' => $data['message'],
            'type' => $data['type'],
            'timestamp' => $data['timestamp'],
        ];
    }

    // ***** HELPER DATABASE FUNCTIONS ***** //

    private function getAllLogs()
    {
        $query = '
            SELECT * FROM logs 
            JOIN users ON logs.user_id = users.user_id 
            JOIN user_details ON users.user_id = user_details.user_id 
            ORDER BY logs.timestamp DESC;
        ';

        return Session::getDbInstance()->executeQuery($query)->getQueryResult();
    }
}
