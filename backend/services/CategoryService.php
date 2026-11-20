<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/CategoryDao.php';
require_once __DIR__ . '/../dao/ClassDao.php';
class CategoryService extends BaseService {
    protected array $fields = ['name', 'description'];
    public function __construct() { parent::__construct(new CategoryDao(), 'Category'); }
    protected function validate(array $data, ?int $id = null): void {
        Validator::required($data, ['name']);
        Validator::text($data['name'], 'name', 2, 100);
        if (isset($data['description'])) { Validator::text($data['description'], 'description', 0, 2000); }
        $existing = $this->dao->getByExactName($data['name']);
        if ($existing && (int)$existing['category_id'] !== $id) {
            throw new ValidationException('A category with this name already exists.');
        }
    }
    public function delete($id): void {
        $this->find($id);
        if ((new ClassDao())->getByCategory($id)) {
            throw new ValidationException('Move or delete the classes in this category first.');
        }
        parent::delete($id);
    }
    public function getClasses($id): array { $this->find($id); return (new ClassDao())->getByCategory($id); }
}
