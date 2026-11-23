<?php
// Presentation only: read the request, call a service, return JSON.
Flight::route('GET /memberships', function () { Flight::json(Flight::membershipService()->getAll()); });
Flight::route('GET /memberships/@id:[0-9]+', function ($id) { Flight::json(Flight::membershipService()->getById($id)); });
Flight::route('POST /memberships', function () { Flight::json(Flight::membershipService()->create(RequestBody::json()), 201); });
Flight::route('PUT|PATCH /memberships/@id:[0-9]+', function ($id) { Flight::json(Flight::membershipService()->update($id, RequestBody::json())); });
Flight::route('DELETE /memberships/@id:[0-9]+', function ($id) {
    Flight::membershipService()->delete($id);
    Flight::json(['message' => 'Membership deleted.']);
});
