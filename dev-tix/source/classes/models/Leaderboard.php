<?php

class Leaderboard
{
    // Attributes.
    private int $id;
    private int $leagueID;
    private string $leagueName;
    private int $assistantID;
    private int $resolvedTickets;
    private Database $database;

    /**
     * Class constructor.
     * @param int $assistantID - assistant id.
     * @param Database $database - database object.
     */
    public function __construct(int $assistantID, Database $database)
    {
        $this->assistantID = $assistantID;
        $this->database = $database;

        $this->getLeaderboardData();
    }

    private function getAllLeagues()
    {
        $query = 'SELECT * FROM leagues;';
        return $this->database->executeQuery(
            $query
        )->getQueryResult();
    }

    private function getLeagueOffset()
    {
        return $this->leagueID !== 1 ? 2 : 1;
    }

    private function getLeagueRankings()
    {
        $query = 'SELECT * FROM leaderboards WHERE league_id = :league_id ORDER BY resolved_tickets DESC;';
        return $this->database->executeQuery(
            $query, [':league_id' => $this->leagueID]
        )->getQueryResult();
    }

    /**
     * Get leaderboard data per assistant.
     * @return array data - leaderboard data.
     */
    private function getLeaderboardData()
    {
        $query = '
            SELECT * FROM leaderboards JOIN leagues 
            ON leaderboards.league_id = leagues.league_id 
            WHERE assistant_id = :assistant_id;
        ';

        $result = $this->database->executeQuery(
            $query, [':assistant_id' => $this->assistantID]
        )->getQueryResult();

        if (!empty($result)) {
            $this->id = (int) $result['leaderboard_id'];
            $this->leagueID = (int) $result['league_id'];
            $this->leagueName = $result['league_name'];
            $this->resolvedTickets = $result['resolved_tickets'];
        }

        return $result;
    }

    /**
     * Check if there is a record of the assistant.
     * @return bool true/false - true if valid, false otherwise.
     */
    public function isRecordEmpty()
    {
        return empty($this->getLeaderboardData());
    }

    /**
     * Get leaderboard id.
     * @return int $id - leaderboard id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get league id.
     * @return int $leagueID - league id.
     */
    public function getLeagueId()
    {
        return $this->leagueID;
    }

    /**
     * Get league name.
     * @return string $leagueName - league name.
     */
    public function getLeagueName()
    {
        return $this->leagueName;
    }

    /**
     * Get assistant id.
     * @return int $assistantID - assistant id.
     */
    public function getAssistantId()
    {
        return $this->assistantID;
    }

    /**
     * Get # of resolved tickets.
     * @return int $resolvedTickets - # of resolved tickets.
     */
    public function getResolvedTickets()
    {
        return $this->resolvedTickets;
    }

    /**
     * Get next league's name.
     * @return string $leagueName - next league's name.
     */
    public function getNextLeagueName()
    {
        $leagues = $this->getAllLeagues();

        return (string) $leagues[
            $this->leagueID - $this->getLeagueOffset()
        ]['league_name'];
    }

    /**
     * Get current league progress.
     * @return float $percentage - league progress.
     */
    public function getLeagueProgress()
    {
        $leagues = $this->getAllLeagues();

        $threshold = (int) $leagues[
            $this->leagueID - $this->getLeagueOffset()
        ]['threshold'];

        // Progress in percentages.
        return ($this->resolvedTickets / $threshold) * 100;
    }

    public function getLeagueRank()
    {
        $leaguesRankings = $this->getLeagueRankings();

        $rank = 0;
        if (!isset($leaguesRankings['leaderboard_id'])) {
            foreach ($leaguesRankings as $i => $ranking) {
                if ((int) $ranking['assistant_id'] === $this->getAssistantId()) {
                    $rank = $i + 1;
                }
            }
        } else {
            $rank = 1;
        }

        // Assistant's ranking.
        return (int) $rank;
    }
}
