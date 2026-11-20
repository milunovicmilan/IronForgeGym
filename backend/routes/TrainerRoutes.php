<?php
// Presentation only: read the request, call a service, return JSON.
Flight::route('GET /trainers', function () { Flight::json(Flight::trainerService()->getAll()); });
Flight::route('GET /trainers/@id:[0-9]+', function ($id) { Flight::json(Flight::trainerService()->getById($id)); });
Flight::route('POST /trainers', function () { Flight::json(Flight::trainerService()->create(RequestBody::json()), 201); });
Flight::route('PUT|PATCH /trainers/@id:[0-9]+', function ($id) { Flight::json(Flight::trainerService()->update($id, RequestBody::json())); });
Flight::route('DELETE /trainers/@id:[0-9]+', function ($id) {
    Flight::trainerService()->delete($id);
    Flight::json(['message' => 'Trainer deleted.']);
});

Flight::route('GET /trainers/@id:[0-9]+/classes', function ($id) { Flight::json(Flight::trainerService()->getClasses($id)); });
