class ProfileView {
    #spanProfileUser = $(".span-profile-user");
    #btnsAlterProfile = $(".btn-alter-profile");
    #btnDeleteProfile = $(".btn-delete-profile");
    #btnUploadImage = $(".btn-upload-image");
    #profileBio = $("textarea#bio");
    #textCharactersLimit = $(".text-characters-limit");
    #spanCharactersWritten = $(".span-characters-written");
    #spanProfileView = $(".span-profile-view");

    setProfileUser(username) {
        this.#spanProfileUser.text(`${username}'s`);
    }

    populateUserInputs(data) {
        this.setProfileUser(data["username"]);

        for (const [key, value] of Object.entries(data)) {
            if (value) $(`#${key}`).val(value);
        }
    }

    generateImageInput() {
        return `
            <div class="div-input-image-outer-container">
                <label class="absolute-y-center input-image-label flex-center" for="image_name">
                    <ion-icon src="/core/assets/media/icons/image.svg"></ion-icon>
                </label>
                <div class="div-input-image-inner-container">
                    <input 
                        id="image_name" class="input-image-name" type="text" 
                        name="image_name" placeholder="Image Name" readonly
                    >
                    <label class="btn btn-primary btn-upload-image" for="image" role="button">Upload</label>
                    <input id="image" class="input-image" type="file" name="image" accept=".png, .jpg, .jpeg">
                </div>
            </div>
        `;
    }

    checkCharacterLimit(charactersLimit) {
        setInterval(() => {
            const bio = this.#profileBio.val();
            const writtenCharacters = bio.split("").length;
            this.#textCharactersLimit.css("color", "var(--gray-shade)");

            // Guard clause: character limit reached.
            if (writtenCharacters > charactersLimit) return this.#textCharactersLimit.css("color", "var(--error)");

            this.#spanCharactersWritten.text(writtenCharacters);
        }, 100);
    }

    setSpanProfileView(viewType) {
        this.#spanProfileView.text(viewType[0].toUpperCase() + viewType.slice(1));
    }

    addEventAlterProfileData(handlerFunction) {
        this.#btnsAlterProfile.each((_, btn) => {
            $(btn)?.click(handlerFunction);
        });
    }

    addEventDeleteProfileData(handlerFunction) {
        this.#btnDeleteProfile?.click(handlerFunction);
    }

    addEventToggleInputImage(handlerFunction) {
        this.#btnUploadImage?.click(handlerFunction);
    }
}

export default new ProfileView();
