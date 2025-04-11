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
}
