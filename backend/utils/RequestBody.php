<?php
require_once __DIR__ . '/exceptions.php';
class RequestBody {
    public static function json(): array {
        $type = strtolower(trim(explode(';', $_SERVER['CONTENT_TYPE'] ?? '')[0]));
        if ($type !== 'application/json') { throw new ValidationException('Send the request body as application/json.'); }
        $raw = file_get_contents('php://input');
        try { $object = json_decode($raw, false, 512, JSON_THROW_ON_ERROR); }
        catch (JsonException $e) { throw new ValidationException('The request body is not valid JSON.'); }
        if (!$object instanceof stdClass) { throw new ValidationException('The request body must be a JSON object.'); }
        // Preserve objects/arrays as nested values so the service can reject them.
        return get_object_vars($object);
    }
}
