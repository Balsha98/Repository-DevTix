export const handleRequest = function (url, method, data) {
    $.ajax({
        url: url,
        method: method,
        data: JSON.stringify(data),
        success: (response) => {
            console.log(response);
        },
    });
};
