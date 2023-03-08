<?php 
    require("./../src/config.php");

    use Steampixel\Route;

    Route::add('/', function() {
        echo "dziala";
    });

    Route::run("/cms/pub");
?>