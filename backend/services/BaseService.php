<?php
require_once __DIR__ . '/../utils/Validator.php';
abstract class BaseService {
    protected array $fields = [];
    public function __construct(protected $dao, protected string $entity) {}
    public function getAll(): array { return array_map([$this, 'output'], $this->dao->getAll()); }
    public function getById($id): array { return $this->output($this->find($id)); }
    protected function find($id): array {
        Validator::integer($id, 'id');
        $row = $this->dao->getById($id);
        if (!$row) { throw new NotFoundException("{$this->entity} not found."); }
        return $row;
    }
    public function create(array $data): array {
        $data = $this->input($data);
        $this->validate($data);
        $id = $this->write(fn() => $this->dao->insert($this->storage($data)));
        return $this->getById($id);
    }
    public function update($id, array $data): array {
        $current = $this->find($id);
        $changes = $this->input($data);
        $merged = array_replace($current, $changes);
        $this->validate($merged, (int)$id);
        $this->write(fn() => $this->dao->update($id, $this->storage($changes)));
        return $this->getById($id);
    }
    public function delete($id): void {
        $this->find($id);
        $this->write(fn() => $this->dao->delete($id));
    }
    protected function input(array $data): array {
        Validator::fields($data, $this->fields);
        foreach ($data as $field => &$value) {
            if (is_string($value) && $field !== 'password') { $value = trim($value); }
        }
        unset($value);
        return $data;
    }
    protected function output(array $row): array { return $row; }
    protected function storage(array $data): array { return $data; }
    protected function write(callable $operation): mixed {
        try { return $operation(); }
        catch (PDOException $e) {
            // Race-time unique/FK violations are client errors, never raw SQL responses.
            if ($e->getCode() === '23000') {
                throw new ValidationException('The operation conflicts with an existing or referenced record.');
            }
            throw $e;
        }
    }
    abstract protected function validate(array $data, ?int $id = null): void;
}
