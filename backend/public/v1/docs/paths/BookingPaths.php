<?php
use OpenApi\Attributes as OA;
class BookingPaths {
    #[OA\Get(
        path: '/bookings', tags: ['bookings'], summary: 'List bookings',
        responses: [
            new OA\Response(response: 200, description: 'List bookings', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Booking'))),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint0() {}

    #[OA\Get(
        path: '/bookings/{id}', tags: ['bookings'], summary: 'Get one bookings',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'Get one bookings', content: new OA\JsonContent(ref: '#/components/schemas/Booking')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint1() {}

    #[OA\Post(
        path: '/bookings', tags: ['bookings'], summary: 'Create bookings',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/BookingInput')),
        responses: [
            new OA\Response(response: 201, description: 'Create bookings', content: new OA\JsonContent(ref: '#/components/schemas/Booking')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint2() {}

    #[OA\Put(
        path: '/bookings/{id}', tags: ['bookings'], summary: 'Update supplied fields of bookings',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/BookingUpdate')),
        responses: [
            new OA\Response(response: 200, description: 'Update supplied fields of bookings', content: new OA\JsonContent(ref: '#/components/schemas/Booking')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint3() {}

    #[OA\Patch(
        path: '/bookings/{id}', tags: ['bookings'], summary: 'Partially update bookings',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/BookingUpdate')),
        responses: [
            new OA\Response(response: 200, description: 'Partially update bookings', content: new OA\JsonContent(ref: '#/components/schemas/Booking')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint4() {}

    #[OA\Delete(
        path: '/bookings/{id}', tags: ['bookings'], summary: 'Delete bookings',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'Delete bookings', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint5() {}

    #[OA\Post(
        path: '/bookings/{id}/cancel', tags: ['bookings'], summary: 'Cancel a booking and release its seat',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)],
        responses: [
            new OA\Response(response: 200, description: 'Cancel a booking and release its seat', content: new OA\JsonContent(ref: '#/components/schemas/Booking')),
            new OA\Response(response: 400, description: 'Invalid request or business rule', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Record not found', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 404, 'error' => 'Record not found.'])),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function endpoint6() {}

}
