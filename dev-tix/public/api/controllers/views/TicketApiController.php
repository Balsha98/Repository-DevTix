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
            $userID = $data['user_id'];

            // Guard clause: notification process error.
            if (isset(Notification::sendRequestNotification($ticketID, $userID)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            // Save request-related log.
            Log::saveTicketRequestLog($userID, $ticketID);

            // Request post was successful.
            return ApiMessage::alertDataAlterAttempt(true, "/ticket/{$ticketID}");
        }

        // Request images posted by patron.
        if ($action === 'post/images') {
            if (!empty($_FILES)) {
                $ticketID = $this->getLastInsertId();

                foreach ($_FILES as $image) {
                    $imageData = [
                        'image' => file_get_contents($image['tmp_name']),
                        'type' => explode('/', $image['type'])[1]
                    ];

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
            $userID = $data['user_id'];

            // Send response notification to ticket users.
            $ticketUsersIDs = [$ticketData['patron_id'], $ticketData['assistant_id']];
            foreach ($ticketUsersIDs as $id) {
                if (isset(Notification::sendResponseNotification($ticketID, $userID, $id)['error'])) {
                    return ApiMessage::alertDataAlterAttempt(false);
                }
            }

            $turnID = $data['user_id'];
            if ((int) $data['user_id'] === (int) $ticketData['turn_id']) {
                if ((int) $data['user_id'] === (int) $ticketData['patron_id']) {
                    $turnID = $ticketData['assistant_id'];
                } else {
                    $turnID = $ticketData['patron_id'];
                }
            }

            // Guard clause: turn process error.
            if (isset($this->updateRequestColumn('turn_id', $turnID, $ticketID)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            // Save response-related log.
            Log::saveTicketResponseLog($userID, $ticketID);

            // Response post was successful.
            return ApiMessage::alertDataAlterAttempt(true);
        }
    }

    public function put()
    {
        $data = $this->getData();
        $action = $data['action'];
        $ticketID = $this->getId();
        $userID = (int) $data['user_id'];
        $status = $data['status'];

        $columns = [
            'cancelled/request' => ['status' => $status],
            'pending/request' => ['assistant_id' => $userID, 'turn_id' => $userID, 'status' => $status],
            'resolved/request' => ['status' => $status]
        ];

        foreach ($columns[$action] as $column => $value) {
            if (isset($this->updateRequestColumn($column, $value, $ticketID)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }
        }

        // Update leaderboard.
        if ($action === 'resolved/request') {
            $totalTickets = (int) $this->getTotalResolvedTickets($userID);
            $currUserStanding = (int) $this->getUserStanding($userID);

            $leagueID = 0;
            if ($totalTickets >= 500) {
                $leagueID = 1;
            } else if ($totalTickets >= 250) {
                $leagueID = 2;
            } else if ($totalTickets >= 100) {
                $leagueID = 3;
            } else if ($totalTickets >= 1) {
                $leagueID = 4;
            }

            // Send league notification.
            if ($currUserStanding !== $leagueID) {
                // Guard clause: notification process error.
                if (isset(Notification::sendPrivateNotification($userID, 'league')['error'])) {
                    return ApiMessage::alertDataAlterAttempt(false);
                };
            }

            // Guard clause: league standing process error.
            if (isset($this->updateUserStanding($leagueID, $userID, $totalTickets)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }
        }

        // Guard clause: notification process error.
        if (isset(Notification::sendRequestNotification($ticketID, $userID, $status)['error'])) {
            return ApiMessage::alertDataAlterAttempt(false);
        }

        // Save request-related log.
        Log::saveTicketRequestLog($userID, $ticketID, $status);

        // Guard clause: redirect to tickets view if request was cancelled.
        if ($action === 'cancelled/request') {
            return ApiMessage::alertDataAlterAttempt(true, '/tickets');
        }

        return ApiMessage::alertDataAlterAttempt(true);
    }

    // ***** HELPER DATABASE FUNCTIONS ***** //

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

    private function uploadRequestImage(int $ticketID, array $imageData)
    {
        $query = '
            INSERT INTO request_images (
                request_id, request_image, request_image_type
            ) VALUES (
                :request_id, :request_image, :request_image_type
            );
        ';

        return Session::getDbInstance()->executeQuery($query, [
            ':request_id' => $ticketID, ':request_image' => $imageData['image'], ':request_image_type' => $imageData['type']
        ])->getQueryResult();
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

    private function getTotalResolvedTickets(int $userID)
    {
        $query = 'SELECT COUNT(request_id) AS total FROM ticket_requests WHERE assistant_id = :assistant_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':assistant_id' => $userID]
        )->getQueryResult()['total'];
    }

    private function getUserStanding(int $userID)
    {
        $query = 'SELECT league_id FROM leaderboards WHERE assistant_id = :assistant_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':assistant_id' => $userID]
        )->getQueryResult()['league_id'] ?? 0;
    }

    private function updateUserStanding(int $leagueID, int $userID, int $totalTickets)
    {
        $query = '
            INSERT INTO leaderboards SET 
                league_id = :league_id, 
                assistant_id = :assistant_id, 
                resolved_tickets = :resolved_tickets 
            ON DUPLICATE KEY UPDATE 
                league_id = VALUES(league_id), 
                resolved_tickets = VALUES(resolved_tickets);
        ';

        return Session::getDbInstance()->executeQuery($query, [
            ':league_id' => $leagueID, ':assistant_id' => $userID, ':resolved_tickets' => $totalTickets
        ])->getQueryResult();
    }

    private function getLastInsertId()
    {
        return Session::getDbInstance()->executeQuery(
            'SELECT MAX(request_id) AS id FROM ticket_requests;'
        )->getQueryResult()['id'];
    }
}
