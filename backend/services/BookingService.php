<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/BookingDao.php';
require_once __DIR__ . '/../dao/ClassDao.php';
require_once __DIR__ . '/../dao/UserDao.php';
class BookingService extends BaseService {
    protected array $fields = ['user_id', 'class_id', 'status'];
    public function __construct() { parent::__construct(new BookingDao(), 'Booking'); }
    protected function validate(array $data, ?int $id = null): void {
        Validator::required($data, ['user_id', 'class_id', 'status']);
        Validator::integer($data['user_id'], 'user_id');
        Validator::integer($data['class_id'], 'class_id');
        Validator::choice($data['status'], 'status', ['booked', 'cancelled']);
        if (!(new UserDao())->getById($data['user_id'])) { throw new ValidationException('The selected user does not exist.'); }
        $class = (new ClassDao())->getById($data['class_id']);
        if (!$class) { throw new ValidationException('The selected class does not exist.'); }
        if ($data['status'] === 'booked') {
            if ($class['schedule_time'] <= date('Y-m-d H:i:s')) { throw new ValidationException('This class has already started.'); }
            $existing = $this->dao->checkIfUserBooked($data['user_id'], $data['class_id']);
            if ($existing && (int)$existing['booking_id'] !== $id) { throw new ValidationException('This user already booked the class.'); }
            $current = $id === null ? false : $this->dao->getById($id);
            // An unchanged active booking already occupies a seat.
            if ((!$current || $current['status'] !== 'booked') &&
                $this->dao->countActiveByClass($data['class_id']) >= (int)$class['capacity']) {
                throw new ValidationException('This class is full.');
            }
        }
    }
    public function create(array $data): array {
        $data += ['status' => 'booked'];
        Validator::required($data, ['class_id']);
        Validator::integer($data['class_id'], 'class_id');
        return (new ClassDao())->withLockedRow($data['class_id'], fn() => parent::create($data));
    }
    public function update($id, array $data): array {
        $current = $this->find($id);
        foreach (['user_id', 'class_id'] as $field) {
            if (array_key_exists($field, $data)) {
                Validator::integer($data[$field], $field);
                if ((int)$data[$field] !== (int)$current[$field]) {
                    throw new ValidationException('A booking cannot be moved. Cancel it and create a new booking.');
                }
            }
        }
        return (new ClassDao())->withLockedRow($current['class_id'], fn() => parent::update($id, $data));
    }
    public function cancel($id): array { return $this->update($id, ['status' => 'cancelled']); }
    public function getByUser($id): array {
        Validator::integer($id, 'user_id');
        if (!(new UserDao())->getById($id)) { throw new NotFoundException('User not found.'); }
        return $this->dao->getByUser($id);
    }
    public function getByClass($id): array {
        Validator::integer($id, 'class_id');
        if (!(new ClassDao())->getById($id)) { throw new NotFoundException('Class not found.'); }
        return $this->dao->getByClass($id);
    }
}
