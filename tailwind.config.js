/** @type {import('tailwindcss').Config} */
export default {
	content: ["./resources/**/*.blade.php", "./resources/**/*.js", "./resources/**/*.vue"],
	theme: {
		extend: {
			colors: {
				blurple: "#5865F2",
				chica: "#EB459E"
			}
		}
	},
	extend: {},
	plugins: []
};
