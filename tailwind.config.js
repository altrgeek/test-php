const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/ts/components/Meeting/**/*.tsx',
        'node_modules/flowbite-react/**/*.{js,jsx,ts,tsx}'
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans]
            },
            fontSize: {
                xxxs: '.5rem',
                xxs: '.625rem'
            }
        }
    },
    plugins: [require('@tailwindcss/line-clamp'), require('flowbite/plugin')]
};
