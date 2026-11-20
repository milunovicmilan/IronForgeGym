<?php
// Presentation only: read the request, call a service, return JSON.
Flight::route('GET /categories', function () { Flight::json(Flight::categoryService()->getAll()); });
Flight::route('GET /categories/@id:[0-9]+', function ($id) { Flight::json(Flight::categoryService()->getById($id)); });
Flight::route('POST /categories', function () { Flight::json(Flight::categoryService()->create(RequestBody::json()), 201); });
Flight::route('PUT|PATCH /categories/@id:[0-9]+', function ($id) { Flight::json(Flight::categoryService()->update($id, RequestBody::json())); });
Flight::route('DELETE /categories/@id:[0-9]+', function ($id) {
    Flight::categoryService()->delete($id);
    Flight::json(['message' => 'Category deleted.']);
});

Flight::route('GET /categories/@id:[0-9]+/classes', function ($id) { Flight::json(Flight::categoryService()->getClasses($id)); });
