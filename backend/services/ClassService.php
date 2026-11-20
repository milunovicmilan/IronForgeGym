<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ClassDao.php';
require_once __DIR__ . '/../dao/CategoryDao.php';
require_once __DIR__ . '/../dao/TrainerDao.php';
require_once __DIR__ . '/../dao/BookingDao.php';
class ClassService extends BaseService {
    protected array $fields = ['title', 'description', 'category_id', 'trainer_id', 'schedule_time', 'capacity'];
    public function __construct() { parent::__construct(new ClassDao(), 'Class'); }
    protected function input(array $data): array {
        $data = parent::input($data);
        if (isset($data['schedule_time']) && is_string($data['schedule_time'])) {
            $data['schedule_time'] = str_replace('T', ' ', $data['schedule_time']);
            if (strlen($data['schedule_time']) === 16) { $data['schedule_time'] .= ':00'; }
        }
        return $data;
    }
    protected function validate(array $data, ?int $id = null): void {
        Validator::required($data, ['title', 'category_id', 'trainer_id', 'schedule_time', 'capacity']);
        Validator::text($data['title'], 'title', 2, 100);
        if (isset($data['description'])) { Validator::text($data['description'], 'description', 0, 2000); }
        Validator::integer($data['capacity'], 'capacity', 1, 10000);
        Validator::integer($data['category_id'], 'category_id');
        Validator::integer($data['trainer_id'], 'trainer_id');
        if (!(new CategoryDao())->getById($data['category_id'])) { throw new ValidationException('The selected category does not exist.'); }
        if (!(new TrainerDao())->getById($data['trainer_id'])) { throw new ValidationException('The selected trainer does not exist.'); }
        $start = Validator::date($data['schedule_time'], 'schedule_time', true);
        if ($id === null && $start <= new DateTimeImmutable()) { throw new ValidationException('New classes must start in the future.'); }
        if ($id !== null && (new BookingDao())->countActiveByClass($id) > (int)$data['capacity']) {
            throw new ValidationException('Capacity cannot be smaller than the number of active bookings.');
        }
    }
    public function update($id, array $data): array {
        Validator::integer($id, 'id');
        return $this->dao->withLockedRow($id, fn() => parent::update($id, $data));
    }
    public function getDetails($id): array { $this->find($id); return $this->dao->getClassWithDetails($id); }
    public function getUpcoming(): array { return $this->dao->getUpcomingClasses(); }
    public function getAvailable(): array { return $this->dao->getAvailableClasses(); }
}
