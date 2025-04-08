<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class LeaguesApiController extends AbsApiController
{
    public function get()
    {
        $return = [];
        $leagueNames = [1 => 'legendary', 2 => 'senior', 3 => 'junior', 4 => 'rookie'];
        foreach ($leagueNames as $id => $leagueName) {
            $totalTickets = $this->getLeagueLeaderTickets($id) ?? 0;
            $return[$leagueName] = $this->getLeagueLeaderUsername($totalTickets, $id);
        }

        return ApiMessage::dataFetchAttempt($return);
    }

    private function getLeagueLeaderTickets(int $leagueID)
    {
        $query = 'SELECT MAX(resolved_tickets) AS total FROM leaderboards WHERE league_id = :league_id';
        return Session::getDbInstance()->executeQuery(
            $query, [':league_id' => $leagueID]
        )->getQueryResult()['total'];
    }

    private function getLeagueLeaderUsername(int $totalTickets, int $leagueID)
    {
        $query = '
            SELECT username FROM users JOIN leaderboards 
            ON users.user_id = leaderboards.assistant_id 
            WHERE leaderboards.resolved_tickets = :resolved_tickets 
            AND leaderboards.league_id = :league_id LIMIT 1;
        ';

        return Session::getDbInstance()->executeQuery($query, [
            ':resolved_tickets' => $totalTickets, ':league_id' => $leagueID
        ])->getQueryResult();
    }
}
