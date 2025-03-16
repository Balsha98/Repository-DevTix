import { initController } from "./../controllers/alertController.js";

export const handleRequest = function (url, method, data, type = "json") {
    const isJSON = type === "json";

    $.ajax({
        url: url,
        method: method,
        data: isJSON ? JSON.stringify(data) : data,
        contentType: isJSON ? "application/json" : isJSON,
        processData: isJSON,
        success: (response) => {
            console.log(response);
            initController(response);
        },
        error: function (response) {
            console.log(response.responseText);
        },
    });
};
