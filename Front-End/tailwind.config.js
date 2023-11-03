/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ['./src/**/*.{js,ts,jsx,tsx,mdx}'],
    theme: {
        extend: {
            maxWidth: {
                default: '1200px',
            },
        },
    },
    plugins: [],
};
