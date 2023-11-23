/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        fontFamily: {
            sans: ["Graphik", "sans-serif"],
            serif: ["Merriweather", "serif"],
        },
        extend: {
            colors: {
                primary: "#4255ff", // lightened blue
                secondary: "#1b2266", // darkened blue
                tertiary: "#fa740e", // foxconnect orange
                dark: "#36485f", // textbackground
                light: "#fff", // ligther text for darker backgrounds
                mute: "rgb(156, 163, 175)", // ligther text for darker backgrounds
                mutehover: "rgb(107 114 128)",
            },
            spacing: {
                128: "32rem",
                144: "36rem",
            },
        },
    },
    plugins: [],
};
