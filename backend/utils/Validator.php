<?php
require_once __DIR__ . '/exceptions.php';
class Validator {
    public static function fields(array $data, array $allowed): void {
        if (!$data) { throw new ValidationException('Provide at least one field.'); }
        foreach (array_keys($data) as $field) {
            if (!in_array($field, $allowed, true)) {
                throw new ValidationException("Unknown or read-only field '$field'.");
            }
            if (is_array($data[$field]) || is_object($data[$field])) {
                throw new ValidationException("Field '$field' must be a scalar value.");
            }
        }
    }
    public static function required(array $data, array $fields): void {
        foreach ($fields as $field) {
            if (!array_key_exists($field, $data) || $data[$field] === null || $data[$field] === '') {
                throw new ValidationException("Field '$field' is required.");
            }
        }
    }
    public static function text(mixed $value, string $field, int $min, int $max): void {
        if (!is_string($value)) { throw new ValidationException("Field '$field' must be text."); }
        $length = preg_match_all('/./us', $value);
        if ($length === false || $length < $min || $length > $max) {
            throw new ValidationException("Field '$field' must have $min to $max characters.");
        }
        if (strpbrk($value, '<>') !== false) {
            throw new ValidationException("Field '$field' must not contain HTML.");
        }
    }
    public static function integer(mixed $value, string $field, int $min = 1, int $max = 2147483647): void {
        if (is_bool($value) || (!is_int($value) && !is_string($value)) ||
            !preg_match('/^-?\d+$/D', (string)$value) || (float)$value < $min || (float)$value > $max) {
            throw new ValidationException("Field '$field' must be a whole number between $min and $max.");
        }
    }
    public static function choice(mixed $value, string $field, array $choices): void {
        if (!in_array($value, $choices, true)) {
            throw new ValidationException("Field '$field' must be one of: " . implode(', ', $choices) . '.');
        }
    }
    public static function email(mixed $value): void {
        if (!is_string($value) || strlen($value) > 100 || !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException('Provide a valid email address (maximum 100 characters).');
        }
    }
    public static function date(mixed $value, string $field, bool $withTime = false): DateTimeImmutable {
        $format = $withTime ? 'Y-m-d H:i:s' : 'Y-m-d';
        $date = is_string($value) ? DateTimeImmutable::createFromFormat('!' . $format, $value) : false;
        if (!$date || $date->format($format) !== $value) {
            throw new ValidationException("Field '$field' must be a valid $format date.");
        }
        return $date;
    }
    public static function password(mixed $value): void {
        if (!is_string($value) || strlen($value) < 8 || strlen($value) > 72 ||
            !preg_match('/[a-zA-Z]/', $value) || !preg_match('/[0-9]/', $value) || str_contains($value, "\0")) {
            throw new ValidationException('Password must have 8 to 72 bytes, including a letter and a number.');
        }
    }
}
