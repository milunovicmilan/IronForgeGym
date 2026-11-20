<?php
use OpenApi\Attributes as OA;
class ClassPaths {
    #[OA\Get(
        path: '/classes', tags: ['classes'], summary: 'List classes',
        responses: [
            new OA\Response(response: 200, description: 'List classes', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Class'))),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint0() {}

    #[OA\Get(
        path: '/classes/{id}', tags: ['classes'], summary: 'Get one classes',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'Get one classes', content: new OA\JsonContent(ref: '#/components/schemas/Class')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint1() {}

    #[OA\Post(
        path: '/classes', tags: ['classes'], summary: 'Create classes',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ClassInput')),
        responses: [
            new OA\Response(response: 201, description: 'Create classes', content: new OA\JsonContent(ref: '#/components/schemas/Class')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint2() {}

    #[OA\Put(
        path: '/classes/{id}', tags: ['classes'], summary: 'Update supplied fields of classes',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ClassUpdate')),
        responses: [
            new OA\Response(response: 200, description: 'Update supplied fields of classes', content: new OA\JsonContent(ref: '#/components/schemas/Class')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint3() {}

    #[OA\Patch(
        path: '/classes/{id}', tags: ['classes'], summary: 'Partially update classes',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ClassUpdate')),
        responses: [
            new OA\Response(response: 200, description: 'Partially update classes', content: new OA\JsonContent(ref: '#/components/schemas/Class')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint4() {}

    #[OA\Delete(
        path: '/classes/{id}', tags: ['classes'], summary: 'Delete classes',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'Delete classes', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint5() {}

    #[OA\Get(
        path: '/classes/upcoming', tags: ['classes'], summary: 'List future classes',
        responses: [
            new OA\Response(response: 200, description: 'List future classes', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Class'))),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint6() {}

    #[OA\Get(
        path: '/classes/available', tags: ['classes'], summary: 'List future classes with free seats',
        responses: [
            new OA\Response(response: 200, description: 'List future classes with free seats', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/AvailableClass'))),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint7() {}

    #[OA\Get(
        path: '/classes/{id}/details', tags: ['classes'], summary: 'Get class with trainer and category',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'Get class with trainer and category', content: new OA\JsonContent(ref: '#/components/schemas/ClassDetails')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint8() {}

    #[OA\Get(
        path: '/classes/{id}/bookings', tags: ['classes'], summary: 'List active bookings of a class',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'List active bookings of a class', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/ClassBooking'))),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint9() {}

}
