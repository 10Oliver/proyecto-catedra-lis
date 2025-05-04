/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./resources/views/**/*.blade.php', './resources/js/**/*.js'],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        primary: '#4f46e5',
        'primary-dark': '#312e81',
        surface: '#ffffff',
        'on-surface': '#1f2937',
      },
    },
  },
  plugins: [],
};
