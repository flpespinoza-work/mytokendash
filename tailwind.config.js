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
                DEFAULT: '#05de43',
                dark: '#06B90D',
                darker: '#04990a'
            },
            blue: {
                lighter: '#edf2ff',
                light: '#E8EEFF',
                DEFAULT: '#024FFF',
                dark: '#0749df',
                darker: '#0618ca',
                darkest: '#04129c'
            },
            gray: {
                lightest: '#fcfdfe',
                lighter: '#F9FAFB',
                light: '#F1F2F4',
                DEFAULT: '#82889B',
                dark: '#3d3f49',
                darker: '#222530',
                darkest: '#0f121b'
            },
            red: {
                light: '#FF9A84',
                DEFAULT: '#FF5934',
                dark: '#ea3911',
                darker: '#d42e08',
                darkest: '#b52b0b'
            },
            orange: {
                lightest: '#FEF8F3',
                light: '#FFAD71',
                DEFAULT: '#FF750E',
                dark: '#E86300',
                darker: '#df6103',
                darkest: '#d15d08'
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
