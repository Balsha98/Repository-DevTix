export const getTimeAgo = function (datetime) {
    const today = new Date().getTime();
    const past = new Date(datetime).getTime();

    // Get difference.
    const difference = today - past;

    return setTimeAgo(difference);
};

const setTimeAgo = function (difference) {
    const SEC = 1000;
    const MIN = 60 * SEC;
    const HRS = 60 * MIN;

    const periods = {};
    periods["hours"] = { value: Math.floor(difference / HRS), name: "Hour" };
    periods["minutes"] = { value: Math.floor((difference % HRS) / MIN), name: "Minute" };
    periods["seconds"] = { value: Math.floor((difference % MIN) / SEC), name: "Second" };

    let timeAgo;
    for (const [key, { value, name }] of Object.entries(periods)) {
        if (key === "hours" && value >= 24) {
            const daysAgo = Math.floor(value / 24);
            timeAgo = `${daysAgo} Day${daysAgo === 1 ? "" : "s"}`;
        } else if (value !== 0) timeAgo = `${value} ${name}${value === 1 ? "" : "s"}`;

        // Guard clause: end loop.
        if (timeAgo) break;
    }

    return !timeAgo ? "Just Now" : `${timeAgo} Ago`;
};
