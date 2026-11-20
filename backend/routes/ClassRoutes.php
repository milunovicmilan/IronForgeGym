<?php
// Presentation only: read the request, call a service, return JSON.
Flight::route('GET /classes', function () { Flight::json(Flight::classService()->getAll()); });
Flight::route('GET /classes/@id:[0-9]+', function ($id) { Flight::json(Flight::classService()->getById($id)); });
Flight::route('POST /classes', function () { Flight::json(Flight::classService()->create(RequestBody::json()), 201); });
Flight::route('PUT|PATCH /classes/@id:[0-9]+', function ($id) { Flight::json(Flight::classService()->update($id, RequestBody::json())); });
Flight::route('DELETE /classes/@id:[0-9]+', function ($id) {
    Flight::classService()->delete($id);
    Flight::json(['message' => 'Class deleted.']);
});

Flight::route('GET /classes/upcoming', function () { Flight::json(Flight::classService()->getUpcoming()); });
Flight::route('GET /classes/available', function () { Flight::json(Flight::classService()->getAvailable()); });
Flight::route('GET /classes/@id:[0-9]+/details', function ($id) { Flight::json(Flight::classService()->getDetails($id)); });
Flight::route('GET /classes/@id:[0-9]+/bookings', function ($id) { Flight::json(Flight::bookingService()->getByClass($id)); });
