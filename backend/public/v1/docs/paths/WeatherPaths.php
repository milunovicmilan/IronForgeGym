<?php
use OpenApi\Attributes as OA;
class WeatherPaths {
    #[OA\Get(
        path: '/weather/sarajevo', tags: ['weather'], summary: 'Get Sarajevo weather and workout advice',
        responses: [
            new OA\Response(response: 200, description: 'Get Sarajevo weather and workout advice', content: new OA\JsonContent(ref: '#/components/schemas/Weather')),
            new OA\Response(response: 500, description: 'Unexpected server error', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 500, 'error' => 'Something went wrong on the server. Please try again later.'])),
            new OA\Response(response: 503, description: 'Weather provider unavailable', content: new OA\JsonContent(ref: '#/components/schemas/Error', example: ['status' => 503, 'error' => 'Weather is temporarily unavailable. Please try again later.']))
        ]
    )]
    public function getWeather() {}
}
