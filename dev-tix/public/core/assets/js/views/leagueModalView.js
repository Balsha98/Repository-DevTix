class LeagueModalView {
    #leagueModalContainer = $(".div-league-modal-container");
    #btnsCloseModal = $(".btn-close-league-modal");

    toggleLeagueModal() {
        this.#leagueModalContainer.toggleClass("hide-league-modal");
    }

    addEventToggleLeagueModal(handlerFunction) {
        this.#btnsCloseModal.each((_, btn) => {
            $(btn)?.click(handlerFunction);
        });
    }
}

export default new LeagueModalView();
