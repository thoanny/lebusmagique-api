/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.{js,vue}",
    "./src/Form/**/*.php",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
}

