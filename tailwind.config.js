const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
        fontFamily: {
            sans: ['Inter', ...defaultTheme.fontFamily.sans],
        },
        fontSize: {
            'xxs': '.65rem'
        },
        colors: {
            white: '#FFFFFF',
            green: {
                light: '#EAF8E3',
                dark: '#06B90D'
            },
            blue: {
                light: '#E8EEFF',
                dark: '#024FFF',
                darker: '#5D639F'
            },
            gray: {
                lightest: '#fcfdfe',
                light: '#F1F2F4',
                DEFAULT: '#82889B',
                //dark: '#5B5E6E',
                dark: '#70749a',
                darker: '#333949',
                darkest: '#111727'
                //darker: '#1B1B1A'
            },
            red: {
                light: '#FF9A84',
                DEFAULT: '#FF5934',
                dark: '#F13E16'
            },
            orange: {
                lightest: '#FEF8F3',
                light: '#FFAD71',
                DEFAULT: '#FF750E',
                dark: '#E86300',
                darker: '#F26C08',
                darkest: '#E16306'
            }
        }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
