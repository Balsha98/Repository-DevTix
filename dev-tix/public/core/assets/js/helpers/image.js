export const renderTicketPatronImage = function (user) {
    if (user["image"]) {
        return `
            <div class="div-image-container div-tickets-patron-image-container">
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
