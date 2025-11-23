import { fontFamily } from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './app/Filament/**/*.php',
    './vendor/filament/**/*.blade.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', ...fontFamily.sans],
      },
      colors: {
        'brand-primary': {
          DEFAULT: '#1E40AF', // A strong, professional blue
          '50': '#EBF5FF',
          '100': '#D6EBFF',
          '200': '#ADDAFF',
          '300': '#85CAFF',
          '400': '#52B3FF',
          '500': '#299CFF',
          '600': '#0084FF',
          '700': '#0066CC',
          '800': '#004C99',
          '900': '#003366',
          '950': '#002244',
        },
        'brand-secondary': {
          DEFAULT: '#F59E0B', // A warm, inviting amber/gold
          '50': '#FFFBEB',
          '100': '#FEF3C7',
          '200': '#FDE68A',
          '300': '#FCD34D',
          '400': '#FBBF24',
          '500': '#F59E0B',
          '600': '#D97706',
          '700': '#B45309',
          '800': '#92400E',
          '900': '#78350F',
          '950': '#451A03',
        },
        gray: {
            50: '#f8fafc',
            100: '#f1f5f9',
            200: '#e2e8f0',
            300: '#cbd5e1',
            400: '#94a3b8',
            500: '#64748b',
            600: '#475569',
            700: '#334155',
            800: '#1e293b',
            900: '#0f172a',
            950: '#020617'
        }
      },
    },
  },
  plugins: [],
};
