class LeaguesView {
    setLeagueLeaders(leaders) {
        for (const [league, leader] of Object.entries(leaders)) {
            if (leader["username"]) $(`.text-${league}-leader`).text(leader["username"]);
        }
    }
}

export default new LeaguesView();
