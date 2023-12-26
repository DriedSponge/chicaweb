/** @type {import('tailwindcss').Config} */
export default {
	content: ["./resources/**/*.blade.php", "./resources/**/*.js", "./resources/**/*.vue"],
	theme: {
		extend: {
			colors: {
				blurple: "#5865F2",
				chica: "#EB459E"
			}
		},
		discord: {
			primary: "#5865F2",
			secondary: "#4f545c",
			accent: "#b9bbbe",
			neutral: "#ffffff",
			"base-100": "#23272A",
			info: "#5865F2",
			success: "#57F287",
			warning: "#FEE75C",
			error: "#ED4245"
		}
	},
	extend: {},
	plugins: [require("@tailwindcss/typography"), require("daisyui")]
};
