<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/MembershipDao.php';
class MembershipService extends BaseService {
    protected array $fields = ['name', 'description', 'price', 'duration_months'];
    public function __construct() { parent::__construct(new MembershipDao(), 'Membership'); }
    protected function validate(array $data, ?int $id = null): void {
        Validator::required($data, ['name', 'price', 'duration_months']);
        Validator::text($data['name'], 'name', 2, 100);
        if (isset($data['description'])) { Validator::text($data['description'], 'description', 0, 2000); }
        if (is_bool($data['price']) || !is_scalar($data['price']) ||
            !preg_match('/^\d{1,8}(\.\d{1,2})?$/D', (string)$data['price']) || (float)$data['price'] <= 0) {
            throw new ValidationException('Price must be positive with at most two decimal places.');
        }
        Validator::integer($data['duration_months'], 'duration_months', 1, 120);
    }
}
