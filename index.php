<?php
//session start
session_start();
//this is our controller
//turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
//require autoload file
require_once('vendor/autoload.php');

//create instance of the base class
$f3 = Base::instance();

//define a default route
$f3->route('GET /', function(){
    $view = new Template();
//    echo $view->render('views/home.html');
    echo "<h1>MY PETS</h1>";
    echo "<a href = 'order'>Order a Pet</a>";
});

$f3->route('GET /order', function(){
    $view = new Template();

    echo $view->render('views/form1.html');
});

$f3->route('POST /order2', function(){
    $view = new Template();

    $_SESSION ['animal'] = $_POST['animal'];

    echo $view->render('views/form2.html');
});

$f3->route('POST /results', function (){
    $view = new Template();

    $_SESSION ['color'] = $_POST['color'];

    echo $view->render('views/results.html');
});

$f3->route('POST /@animal', function($f3, $params) {
    $input  = $params['animal'];

    switch($input) {
        case 'dog':
            echo "<p>Woof</p>";
            break;
        case 'cow':
            echo "<p>Moo</p>";
            break;
        case 'cat':
            echo "<p>Meow</p>";
            break;
        case 'chicken':
            echo "<p>Bawk</p>";
            break;
        case 'lizard':
            echo "<p>Hiss</p>";
            break;
        default:
            $f3->error(404);
    }
});

//run fat free
$f3->run();