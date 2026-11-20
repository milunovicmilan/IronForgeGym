<?php
// Same error categories as the lab; routes translate them centrally to JSON.
class HttpException extends RuntimeException {
    public function __construct(string $message, private int $status = 500) {
        parent::__construct($message);
    }
    public function getStatus(): int { return $this->status; }
}
class ValidationException extends HttpException {
    public function __construct(string $message) { parent::__construct($message, 400); }
}
class NotFoundException extends HttpException {
    public function __construct(string $message) { parent::__construct($message, 404); }
}
class UnauthorizedException extends HttpException {
    public function __construct(string $message) { parent::__construct($message, 401); }
}
class ForbiddenException extends HttpException {
    public function __construct(string $message) { parent::__construct($message, 403); }
}
class ExternalServiceException extends HttpException {
    public function __construct() { parent::__construct('Weather is temporarily unavailable. Please try again later.', 503); }
}
