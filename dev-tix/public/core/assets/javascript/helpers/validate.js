export const isInputEmpty = function (isCustom = false, customClName = null) {
    let isEmpty = false;
    $(`${isCustom ? customClName : "*"}[required]`).each((_, input) => {
        const parent = $(input.closest(".div-input-container"));
        if ($(input).val() === "") {
            parent.addClass("invalid-input-container");
            isEmpty = true;
        } else parent.removeClass("invalid-input-container");
    });

    return isEmpty;
};
