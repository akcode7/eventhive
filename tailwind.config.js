/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{php,html,js}",
    "./*.{html,php}",
    "./src/css/**/*.css",],
  theme: {
    extend: {backgroundImage: {
      'university': "url('src/locationimg/university.png')",
      'bbditm': "url('src/locationimg/bbditm.png')",
    }
  },
  },
  plugins: [],
}

