<?php
use OpenApi\Attributes as OA;
class HealthPaths {
    #[OA\Get(
        path: '/', tags: ['health'], summary: 'API status',
        responses: [
            new OA\Response(response: 200, description: 'API status', content: new OA\JsonContent(ref: '#/components/schemas/Health')),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.']))
        ]
    )]
    public function getHealth() {}
}
