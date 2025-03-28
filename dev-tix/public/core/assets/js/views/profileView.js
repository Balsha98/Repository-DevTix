class ProfileView {
    #spanProfileUser = $(".span-profile-user");
    #spanProfileView = $(".span-profile-view");

    setSpanTicketId(username) {
        this.#spanProfileUser.text(`#${username}`);
    }

    setSpanTicketView(viewType) {
        this.#spanProfileView.text(viewType[0].toUpperCase() + viewType.slice(1));
    }
}

export default new ProfileView();
