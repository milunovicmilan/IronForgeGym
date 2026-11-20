<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/TrainerDao.php';
require_once __DIR__ . '/../dao/ClassDao.php';
class TrainerService extends BaseService {
    protected array $fields = ['full_name', 'specialization', 'phone', 'email', 'experience_years'];
    public function __construct() { parent::__construct(new TrainerDao(), 'Trainer'); }
    protected function input(array $data): array {
        $data = parent::input($data);
        if (isset($data['email']) && is_string($data['email'])) {
            $data['email'] = $data['email'] === '' ? null : strtolower($data['email']);
        }
        return $data;
    }
    protected function validate(array $data, ?int $id = null): void {
        Validator::required($data, ['full_name']);
        Validator::text($data['full_name'], 'full_name', 2, 100);
        foreach (['specialization' => 100, 'phone' => 20] as $field => $max) {
            if (isset($data[$field])) { Validator::text($data[$field], $field, 0, $max); }
        }
        if (isset($data['experience_years'])) { Validator::integer($data['experience_years'], 'experience_years', 0, 80); }
        if (isset($data['email'])) {
            Validator::email($data['email']);
            $existing = $this->dao->getByEmail($data['email']);
            if ($existing && (int)$existing['trainer_id'] !== $id) {
                throw new ValidationException('A trainer with this email already exists.');
            }
        }
    }
    public function delete($id): void {
        $this->find($id);
        if ((new ClassDao())->getByTrainer($id)) { throw new ValidationException('Reassign or delete this trainer\'s classes first.'); }
        parent::delete($id);
    }
    public function getClasses($id): array { $this->find($id); return (new ClassDao())->getByTrainer($id); }
}
