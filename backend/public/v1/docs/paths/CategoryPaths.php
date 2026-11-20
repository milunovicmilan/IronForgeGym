<?php
use OpenApi\Attributes as OA;
class CategoryPaths {
    #[OA\Get(
        path: '/categories', tags: ['categories'], summary: 'List categories',
        responses: [
            new OA\Response(response: 200, description: 'List categories', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Category'))),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint0() {}

    #[OA\Get(
        path: '/categories/{id}', tags: ['categories'], summary: 'Get one categories',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'Get one categories', content: new OA\JsonContent(ref: '#/components/schemas/Category')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint1() {}

    #[OA\Post(
        path: '/categories', tags: ['categories'], summary: 'Create categories',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/CategoryInput')),
        responses: [
            new OA\Response(response: 201, description: 'Create categories', content: new OA\JsonContent(ref: '#/components/schemas/Category')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint2() {}

    #[OA\Put(
        path: '/categories/{id}', tags: ['categories'], summary: 'Update supplied fields of categories',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/CategoryUpdate')),
        responses: [
            new OA\Response(response: 200, description: 'Update supplied fields of categories', content: new OA\JsonContent(ref: '#/components/schemas/Category')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint3() {}

    #[OA\Patch(
        path: '/categories/{id}', tags: ['categories'], summary: 'Partially update categories',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/CategoryUpdate')),
        responses: [
            new OA\Response(response: 200, description: 'Partially update categories', content: new OA\JsonContent(ref: '#/components/schemas/Category')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint4() {}

    #[OA\Delete(
        path: '/categories/{id}', tags: ['categories'], summary: 'Delete categories',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'Delete categories', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint5() {}

    #[OA\Get(
        path: '/categories/{id}/classes', tags: ['categories'], summary: 'List category classes',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'List category classes', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Class'))),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint6() {}

}
