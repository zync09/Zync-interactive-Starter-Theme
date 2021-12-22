let mix = require('laravel-mix');
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");

mix
.sass('src/app.scss', './')
.js('src/app.js', './').vue({ version: 3 })
.postCss("src/tailwind.css", "./", [
    require("tailwindcss"),
])
.version()
.webpackConfig({
    plugins: [
        new BrowserSyncPlugin({
            files: ["**/*.php", "**/*.twig"],
            proxy: "http://local.wpplayground/",
            open: true
        })
    ]
})
.setPublicPath('dist');
