<?php
Flight::route('GET /weather/sarajevo', function () { Flight::json(Flight::weatherService()->getSarajevo()); });
