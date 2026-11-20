<?php
use OpenApi\Attributes as OA;
class MembershipPaths {
    #[OA\Get(
        path: '/memberships', tags: ['memberships'], summary: 'List memberships',
        responses: [
            new OA\Response(response: 200, description: 'List memberships', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Membership'))),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint0() {}

    #[OA\Get(
        path: '/memberships/{id}', tags: ['memberships'], summary: 'Get one memberships',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'Get one memberships', content: new OA\JsonContent(ref: '#/components/schemas/Membership')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint1() {}

    #[OA\Post(
        path: '/memberships', tags: ['memberships'], summary: 'Create memberships',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/MembershipInput')),
        responses: [
            new OA\Response(response: 201, description: 'Create memberships', content: new OA\JsonContent(ref: '#/components/schemas/Membership')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint2() {}

    #[OA\Put(
        path: '/memberships/{id}', tags: ['memberships'], summary: 'Update supplied fields of memberships',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/MembershipUpdate')),
        responses: [
            new OA\Response(response: 200, description: 'Update supplied fields of memberships', content: new OA\JsonContent(ref: '#/components/schemas/Membership')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint3() {}

    #[OA\Patch(
        path: '/memberships/{id}', tags: ['memberships'], summary: 'Partially update memberships',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/MembershipUpdate')),
        responses: [
            new OA\Response(response: 200, description: 'Partially update memberships', content: new OA\JsonContent(ref: '#/components/schemas/Membership')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint4() {}

    #[OA\Delete(
        path: '/memberships/{id}', tags: ['memberships'], summary: 'Delete memberships',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'Delete memberships', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint5() {}

}
