<?php
//session start
session_start();
//turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);


//require autoload file
require_once('vendor/autoload.php');
require_once('model/validation-functions.php');

//create instance of the base class
$f3 = Base::instance();

//Set debug level
$f3->set('DEBUG', 3);

$f3->set('colors', array('pink', 'green', 'blue'));

//define a default route
$f3->route('GET /', function(){
    $view = new Template();
//    echo $view->render('views/home.html');
    echo "<h1>MY PETS</h1>";
    echo "<a href = 'order'>Order a Pet</a>";
});

$f3->route('GET|POST /order', function($f3){
    session_unset();

    if (isset($_POST['animal'])){
        $animal = $_POST['animal'];

        if (validString($animal)) {
            $_SESSION['animal'] = $animal;
            $f3->reroute('/order2');
        } else {
            $f3->set("errors['animal']", "Please enter an animal.");
        }
    }

    $view = new Template();
    echo $view->render('views/form1.html');
});

$f3->route('GET|POST /order2', function(){
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