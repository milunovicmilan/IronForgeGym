<?php
// Presentation only: read the request, call a service, return JSON.
Flight::route('GET /users', function () { Flight::json(Flight::userService()->getAll()); });
Flight::route('GET /users/@id:[0-9]+', function ($id) { Flight::json(Flight::userService()->getById($id)); });
Flight::route('POST /users', function () { Flight::json(Flight::userService()->create(RequestBody::json()), 201); });
Flight::route('PUT|PATCH /users/@id:[0-9]+', function ($id) { Flight::json(Flight::userService()->update($id, RequestBody::json())); });
Flight::route('DELETE /users/@id:[0-9]+', function ($id) {
    Flight::userService()->delete($id);
    Flight::json(['message' => 'User deleted.']);
});

Flight::route('GET /users/@id:[0-9]+/bookings', function ($id) { Flight::json(Flight::bookingService()->getByUser($id)); });
Flight::route('GET /users/@id:[0-9]+/memberships', function ($id) { Flight::json(Flight::userMembershipService()->getByUser($id)); });
Flight::route('GET /users/@id:[0-9]+/active-membership', function ($id) { Flight::json(Flight::userMembershipService()->getActive($id)); });
