<?php
// Presentation only: read the request, call a service, return JSON.
Flight::route('GET /bookings', function () { Flight::json(Flight::bookingService()->getAll()); });
Flight::route('GET /bookings/@id:[0-9]+', function ($id) { Flight::json(Flight::bookingService()->getById($id)); });
Flight::route('POST /bookings', function () { Flight::json(Flight::bookingService()->create(RequestBody::json()), 201); });
Flight::route('PUT|PATCH /bookings/@id:[0-9]+', function ($id) { Flight::json(Flight::bookingService()->update($id, RequestBody::json())); });
Flight::route('DELETE /bookings/@id:[0-9]+', function ($id) {
    Flight::bookingService()->delete($id);
    Flight::json(['message' => 'Booking deleted.']);
});

Flight::route('POST /bookings/@id:[0-9]+/cancel', function ($id) { Flight::json(Flight::bookingService()->cancel($id)); });
