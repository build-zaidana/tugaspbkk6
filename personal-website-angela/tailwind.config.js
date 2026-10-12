/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                script: ['"Great Vibes"', 'cursive'],
                sans: ['"Poppins"', 'sans-serif'],
                tech: ['"Space Mono"', 'monospace'],
            },
            colors: {
                'brand-pink': '#ec4899',
                'brand-pink-dark': '#be185d',
                'brand-frame': '#7a3b47',
                'brand-cream': '#fdf2f7',
            },
        },
    },
    plugins: [],
}
