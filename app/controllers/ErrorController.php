<?php

namespace App\Controllers; //Deklaracja przestrzeni nazw 'App\Controllers', która pozwala na organizowanie kodu w logiczne grupy i unikanie konfliktów nazw

class ErrorController { // Definicja klasy 'ErrorController', która obsługuje błędy
    public function _404() { // Definicja metody '_404', która obsługuje błąd 404
        echo '404 - Strona nieznaleziona';
    }
}