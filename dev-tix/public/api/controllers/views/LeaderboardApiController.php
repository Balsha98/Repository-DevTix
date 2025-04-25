<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class LeaderboardApiController extends AbsApiController
{
    public function get()
    {
        $return = [];
        $leagues = [1 => 'legendary', 2 => 'senior', 3 => 'junior', 4 => 'rookie'];
        foreach ($leagues as $id => $league) {
            $data = $this->getLeaderboardData($id);

            if (!isset($data['league_id'])) {
                foreach ($data as $row) {
                    $return[$league][] = $this->extractLeaderboardData($row);
                }

                continue;
            }

            $return[$league][] = $this->extractLeaderboardData($data);
        }

        return ApiMessage::dataFetchAttempt($return);
    }

    private function extractLeaderboardData(array $data)
    {
        return [
            'user_id' => $data['user_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'role_name' => $data['role_name'],
            'email' => $data['email'],
            'user_image' => $data['user_image'],
            'user_image_type' => $data['user_image_type'],
            'resolved_tickets' => $data['resolved_tickets'],
            'last_active' => $data['last_active']
        ];
    }

    // ***** HELPER DATABASE FUNCTIONS ***** //

    private function getLeaderboardData(int $leagueID)
    {
        $query = '
            SELECT * FROM leaderboards 
            JOIN leagues ON leaderboards.league_id = leagues.league_id 
            JOIN users ON leaderboards.assistant_id = users.user_id 
            JOIN roles ON users.role_id = roles.role_id 
            JOIN user_details ON users.user_id = user_details.user_id 
            WHERE leaderboards.league_id = :league_id 
            ORDER BY leaderboards.resolved_tickets DESC;
        ';

        return Session::getDbInstance()->executeQuery(
            $query, [':league_id' => $leagueID]
        )->getQueryResult();
    }
}
