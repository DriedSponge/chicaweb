import { defineConfig, normalizePath } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
export default defineConfig({
	resolve: {
		alias: {
			"ziggy-js": "vendor/tightenco/ziggy/dist/vue.es.js"
		}
	},
	plugins: [
		laravel({
			input: ["resources/css/app.css", "resources/js/app.js"],
			refresh: true
		}),
		vue()
	]
});
