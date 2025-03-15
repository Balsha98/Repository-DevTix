import { initController } from "./../controllers/alertController.js";

export const handleRequest = function (url, method, data, type = "json") {
    $.ajax({
        url: url,
        method: method,
        data: type === "json" ? JSON.stringify(data) : data,
        success: (response) => {
            console.log(response);
            initController(response);
        },
        error: function (response) {
            console.log(response.responseText);
        },
    });
};
