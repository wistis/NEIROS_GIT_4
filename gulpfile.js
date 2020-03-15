var elixir = require('laravel-elixir');


elixir(function(mix) {
    // some mixes here..
    mix.scripts([
        "bootstrap.js",
        "app.js"
    ]);
});