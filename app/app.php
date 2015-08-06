<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/cars.php";

    session_start();
    if (empty($_SESSION['cars_matching_search'])) {
        $_SESSION['cars_matching_search'] = array();


    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('cars.html.twig', array('cars' =>Car::getAll()));
    });

    $app->post("/cars", function() use ($app) {
        $car = new Car($_POST['make_model']);
        $car->save();
        return $app['twig']->render('post_car.html.twig', array('newcar' => $car))
    });

//delete this and replace with ?
    /*$app->get("/search_result", function() {
    $batmobile = new Car("Mercedes", 200000, "images/batmobile.jpeg");
    $pinto = new Car("Ford", 500, "images/pinto.jpeg", 600);
    $flugtag = new Car("Redbull", 50, "images/flugtag.jpeg", 6);
    $daewoo = new Car("Lanos", 123456, "images/daewoo lanos.jpeg");
    $cars = array($batmobile, $pinto, $flugtag, $daewoo);
    $cars_matching_search = array();
    foreach ($cars as $car) {
        $carPrice = $car->getPrice();
        $carMiles = $car->getMiles();
        if ($carMiles < $_GET["miles"] && $carPrice < $_GET["price"]) {
            array_push($cars_matching_search, $car);
        }
    }
    */

    $output = "";
    foreach ($cars_matching_search as $car) {
        $carModel = $car->getModel();
        $carPrice = $car->getPrice();
        $carMiles = $car->getMiles();
        $carImage = $car->getImage();
        $output =  $output . "<li>" . $carModel . "</li>
            <ul>
             <li> $" . $carPrice . "</li>
             <li>" . $carMiles . "</li>
             <li> <img src=" . $carImage . "></li>
             </ul>
             ";
           }
          if (empty($cars_matching_search)) {
            return "<li> Ain't nothin' here, yo. Try again!</li>";
          }
          return $app['twig']->render('cars.html.twig', array('cars' =>Car::getAll()));
     });
    return $app;
?>
