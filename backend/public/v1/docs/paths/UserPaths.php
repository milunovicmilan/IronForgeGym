<?php
use OpenApi\Attributes as OA;
class UserPaths {
    #[OA\Get(
        path: '/users', tags: ['users'], summary: 'List users',
        responses: [
            new OA\Response(response: 200, description: 'List users', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/User'))),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint0() {}

    #[OA\Get(
        path: '/users/{id}', tags: ['users'], summary: 'Get one users',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'Get one users', content: new OA\JsonContent(ref: '#/components/schemas/User')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint1() {}

    #[OA\Post(
        path: '/users', tags: ['users'], summary: 'Create users',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UserInput')),
        responses: [
            new OA\Response(response: 201, description: 'Create users', content: new OA\JsonContent(ref: '#/components/schemas/User')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint2() {}

    #[OA\Put(
        path: '/users/{id}', tags: ['users'], summary: 'Update supplied fields of users',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UserUpdate')),
        responses: [
            new OA\Response(response: 200, description: 'Update supplied fields of users', content: new OA\JsonContent(ref: '#/components/schemas/User')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint3() {}

    #[OA\Patch(
        path: '/users/{id}', tags: ['users'], summary: 'Partially update users',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UserUpdate')),
        responses: [
            new OA\Response(response: 200, description: 'Partially update users', content: new OA\JsonContent(ref: '#/components/schemas/User')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint4() {}

    #[OA\Delete(
        path: '/users/{id}', tags: ['users'], summary: 'Delete users',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'Delete users', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint5() {}

    #[OA\Get(
        path: '/users/{id}/bookings', tags: ['users'], summary: 'List user bookings',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'List user bookings', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/UserBooking'))),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint6() {}

    #[OA\Get(
        path: '/users/{id}/memberships', tags: ['users'], summary: 'List user memberships',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'List user memberships', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/UserPlan'))),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint7() {}

    #[OA\Get(
        path: '/users/{id}/active-membership', tags: ['users'], summary: 'Get active membership',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'Get active membership', content: new OA\JsonContent(ref: '#/components/schemas/ActivePlan')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint8() {}

}
