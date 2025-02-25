export const isInputEmpty = function () {
    let isEmpty = false;
    $("input[required]").each((_, input) => {
        const parent = $(input.closest(".div-input-container"));
        if ($(input).val() === "") {
            parent.addClass("empty-input-container");
            isEmpty = true;
        } else parent.removeClass("empty-input-container");
    });

    return isEmpty;
};
