/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                opensans: ["Open Sans", "sans-serif"],
                poppins: ["Poppins", "sans-serif"],
                Instrument: ["Instrument Sans", "sans-serif"],
            },
            colors: {
                transparent: "transparent",
                current: "currentColor",
                colorPeach: "#FFCE8B",
                blueColor: "#2337c6",
                colorSealBrown: "#1A1B1CFF",
                colorZinnwal: "#230902",
                royalBule: "#4169e1",
            },
        },
    },
    plugins: [],
};
