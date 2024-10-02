/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./SRC/View/**/*.view.phtml'],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
};
