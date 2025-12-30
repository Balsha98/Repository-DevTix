export const renderListItemUserImage = function (user) {
    if (user["user_image"]) {
        const userID = user["user_id"];
        const imageType = user["user_image_type"];

        return `
            <div class="div-image-container div-list-item-user-image-container">
                <img src="/core/assets/media/images/users/${userID}/user-${userID}.${imageType}" alt="User Image">
            </div>
        `;
    }

    return `
        <div class="div-initials-container flex-center">
            <span>${user["first_name"][0]}${user["last_name"][0]}</span>
        </div>
    `;
};
