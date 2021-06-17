<?php

//trebali znati hoće li skenirati vašu aplikaciju ili će učiniti hoće li tražiti deklarirane objekte. Dakle, ako nađete korisnika koji se prijavljuje, uhvatit će ga i predati kao parametar, zbog toga stavljamo class u funckiju
function classAutoLoad($class){

    //Ono što želimo raditi većinu vremena je da želimo sve napraviti malim slovima
    $class = strtolower($class);

    //ovo je path za slanje putanje određenog fajla namjenjenog za korisnika
    $the_path = "includes/{$class}.php";

    if(is_file($the_path) && !class_exists($class)){

        include $the_path;

    }

    


}

function redirect($location){

    header("Location: {$location}");

}

spl_autoload_register("classAutoLoad");








?>