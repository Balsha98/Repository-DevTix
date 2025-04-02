class LeaderboardView {
    #assistantsLists = $(".assistants-list");
    #leaderboardSelectType = $(".leaderboard-select-type");
    #spansLeaderboardType = $(".span-leaderboard-type");

    setTargetLeaderboardAsMain(leagueType) {
        this.#assistantsLists.each((_, list) => {
            const listLeagueType = $(list).data("league-type");
            if (listLeagueType !== leagueType) $(list).addClass("hide-element");
            else $(list).removeClass("hide-element");
        });

        this.#leaderboardSelectType.val(leagueType);
        this.setSpansLeaderboardType(leagueType);
    }

    setSpansLeaderboardType(leagueType) {
        this.#spansLeaderboardType.each((_, span) => {
            $(span).text(leagueType[0].toUpperCase() + leagueType.slice(1));
        });
    }

    addEventChangeLeaderboardType(handlerFunction) {
        this.#leaderboardSelectType.change(handlerFunction);
    }

    addEventViewUserProfile(handlerFunction) {
        const assistantsListItems = $(".assistants-list-item");

        // Guard clause: none exist.
        if (assistantsListItems.length === 0) return;

        assistantsListItems.each((_, item) => {
            $(item).click(handlerFunction);
        });
    }
}

export default new LeaderboardView();
