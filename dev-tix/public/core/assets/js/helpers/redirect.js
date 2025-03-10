export const redirectTo = function (route, target = "self") {
    window.open(`/${route}`, `_${target}`);
};
