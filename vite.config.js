import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/ip_car_webapp/app.js", // Nodig voor de livestream blade files
                "resources/css/styles.css", // Nodig voor de livestream blade files
            ],
            refresh: true,
        }),
    ],
});
