let mix = require('laravel-mix');

mix
.sass('src/app.scss', 'dist')
.js('src/app.js', 'dist').vue({ version: 3 })
.postCss("src/tailwind.css", "dist", [
    require("tailwindcss"),
])