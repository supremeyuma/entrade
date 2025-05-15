// tailwind.config.js
module.exports = {
    darkMode: 'class', // Enables `dark:` variant
    content: [
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
    ],
    theme: {
      extend: {
        colors: {
          primary: {
            DEFAULT: '#3b82f6',
            dark: '#2563eb',
          },
          secondary: '#64748b',
          accent: '#fbbf24',
        },
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
  