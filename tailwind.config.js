/** @type {import('tailwindcss').Config} */
export default {
	daisyui: {
		themes: [
			{
				discord: {
					primary: "#e35da0",
					"primary-content": "#ffffff",
					// secondary: "#4f545c",
					secondary: "#4f545c",
					"secondary-content": "#ffffff",
					accent: "#b9bbbe",
					neutral: "#4f545c",
					// "base-100": "#1d232a",
					// "base-200": "#191e24",
					// "base-300": "#15191e",
					"base-100": "#313338",
					"base-200": "#2b2d31",
					"base-300": "#1e1f22",
					info: "#5865F2",
					success: "#57F287",
					warning: "#FEE75C",
					error: "#ED4245",
					"error-content": "#ffffff"
				}
			}
		]
	},
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
	plugins: [require("@tailwindcss/typography"), require("daisyui")]
};
