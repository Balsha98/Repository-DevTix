<?php

class Leaderboard
{
    private int $id;
    private int $leagueID;
    private string $leagueName;
    private int $assistantID;
    private int $resolvedTickets;
    private Database $database;

    public function __construct(int $assistantID, Database $database)
    {
        $this->assistantID = $assistantID;
        $this->database = $database;

        $this->getLeaderboardData();
    }

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

    public function getId()
    {
        return $this->id;
    }

    public function getLeagueId()
    {
        return $this->leagueID;
    }

    public function getLeagueName()
    {
        return $this->leagueName;
    }

    public function getAssistantId()
    {
        return $this->assistantID;
    }

    public function getResolvedTickets()
    {
        return $this->resolvedTickets;
    }
}
