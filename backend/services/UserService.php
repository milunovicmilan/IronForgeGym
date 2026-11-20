<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php';
class UserService extends BaseService {
    protected array $fields = ['full_name', 'email', 'password', 'role', 'join_date'];
    public function __construct() { parent::__construct(new UserDao(), 'User'); }
    public function create(array $data): array {
        $data += ['role' => 'user', 'join_date' => date('Y-m-d')];
        Validator::required($data, ['password']);
        return parent::create($data);
    }
    protected function input(array $data): array {
        $data = parent::input($data);
        if (isset($data['email']) && is_string($data['email'])) { $data['email'] = strtolower($data['email']); }
        return $data;
    }
    protected function validate(array $data, ?int $id = null): void {
        Validator::required($data, ['full_name', 'email', 'role']);
        Validator::text($data['full_name'], 'full_name', 2, 100);
        Validator::email($data['email']);
        Validator::choice($data['role'], 'role', ['user', 'admin']);
        if (array_key_exists('password', $data)) { Validator::password($data['password']); }
        if (isset($data['join_date'])) { Validator::date($data['join_date'], 'join_date'); }
        $existing = $this->dao->getByEmail($data['email']);
        if ($existing && (int)$existing['user_id'] !== $id) {
            throw new ValidationException('An account with this email already exists.');
        }
    }
    protected function storage(array $data): array {
        if (isset($data['password'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
            unset($data['password']);
        }
        return $data;
    }
    protected function output(array $row): array { unset($row['password_hash']); return $row; }
}
