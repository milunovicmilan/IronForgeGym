<?php
// Presentation only: read the request, call a service, return JSON.
Flight::route('GET /user-memberships', function () { Flight::json(Flight::userMembershipService()->getAll()); });
Flight::route('GET /user-memberships/@id:[0-9]+', function ($id) { Flight::json(Flight::userMembershipService()->getById($id)); });
Flight::route('POST /user-memberships', function () { Flight::json(Flight::userMembershipService()->create(RequestBody::json()), 201); });
Flight::route('PUT|PATCH /user-memberships/@id:[0-9]+', function ($id) { Flight::json(Flight::userMembershipService()->update($id, RequestBody::json())); });
Flight::route('DELETE /user-memberships/@id:[0-9]+', function ($id) {
    Flight::userMembershipService()->delete($id);
    Flight::json(['message' => 'User membership deleted.']);
});
