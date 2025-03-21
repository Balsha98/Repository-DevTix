export const renderTicketUserImage = function (user) {
    if (user["image"]) {
        return `
            <div class="div-image-container div-tickets-user-image-container">
                <img src="${user["image"]}" alt="User Image">
            </div>
        `;
    }

    return `
        <div class="div-initials-container flex-center">
            <span>${user["first_name"][0]}${user["last_name"][0]}</span>
        </div>
    `;
};
