class ProfileView {
    #spanProfileUser = $(".span-profile-user");
    #btnsAlterProfile = $(".btn-alter-profile");
    #btnUploadImage = $(".btn-upload-image");
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

    setSpanProfileView(viewType) {
        this.#spanProfileView.text(viewType[0].toUpperCase() + viewType.slice(1));
    }

    addEventAlterProfileData(handlerFunction) {
        this.#btnsAlterProfile.each((_, btn) => {
            $(btn)?.click(handlerFunction);
        });
    }

    addEventToggleInputImage(handlerFunction) {
        this.#btnUploadImage?.click(handlerFunction);
    }
}

export default new ProfileView();
