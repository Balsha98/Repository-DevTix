class LeagueModalView {
    #leagueModalContainer = $(".div-league-modal-container");
    #btnsCloseModal = $(".btn-close-league-modal");
    #leagueModalStatusCircle = $(".div-league-modal-status-circle");
    #spanLeagueProgress = $(".span-league-progress");
    #textLeagueRank = $(".text-league-rank");
    #spanLeagueRank = $(".span-league-rank");

    toggleLeagueModal() {
        this.#leagueModalContainer.toggleClass("hide-league-modal");
    }

    setLeagueModalStatusCircleProgress() {
        if (this.#leagueModalStatusCircle.length === 0) return;

        // Calculate league progress.
        const leagueProgress = parseInt(this.#spanLeagueProgress.text());
        const circleDegrees = 360 * (leagueProgress / 100);

        // prettier-ignore
        this.#leagueModalStatusCircle.css(`background-image`, `conic-gradient(
            var(--primary) ${circleDegrees}deg, var(--white) ${circleDegrees}deg)`);
    }

    setSpanLeagueRank() {
        if (this.#textLeagueRank.length === 0) return;

        let leagueRank = "";
        const rank = +this.#spanLeagueRank.text();
        if (rank === 1) leagueRank = "gold";
        else if (rank === 2) leagueRank = "sliver";
        else if (rank === 3) leagueRank = "bronze";
        else leagueRank = "regular";

        // Updated league rank visuals.
        [this.#textLeagueRank, this.#spanLeagueRank].forEach((element) => [
            $(element).addClass(`${leagueRank}-league-rank`),
        ]);
    }

    addEventToggleLeagueModal(handlerFunction) {
        this.#btnsCloseModal.each((_, btn) => {
            $(btn)?.click(handlerFunction);
        });
    }
}

export default new LeagueModalView();
