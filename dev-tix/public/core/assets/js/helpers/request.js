import * as alertController from "./../controllers/alertController.js";

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

            // Show alerts ONLY when data is altered,
            // disregard image uploads because they
            // will occur simultaneously with regular
            // request submissions; image uploads
            // will therefore require FormData().
            if (isJSON) alertController.initController(response);
        },
        error: function (response) {
            console.log(response.responseText);
        },
    });
};
