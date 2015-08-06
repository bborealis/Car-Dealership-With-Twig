<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Car.php";

    session_start();

    if (empty($_SESSION['cars_list'])) {
        $_SESSION['cars_list'] = array();
    }


    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('cars.html.twig', array('cars' => Car::getAll()));
    });



    $app->post("/cars", function() use ($app) {
        $car = new Car($_POST['make_model']);
        $car->save();
        return $app['twig']->render('post_car.html.twig', array('newcar' => $car));
    });

    $app->post("delete_cars", function() use ($app) {
        Car::deleteAll();
        return $app['twig']->render('delete_cars.html.twig');
    });


    return $app;
?>
