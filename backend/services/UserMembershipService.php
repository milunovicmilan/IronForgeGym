<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserMembershipDao.php';
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../dao/MembershipDao.php';
class UserMembershipService extends BaseService {
    protected array $fields = ['user_id', 'membership_id', 'start_date', 'end_date'];
    public function __construct() { parent::__construct(new UserMembershipDao(), 'User membership'); }
    public function create(array $data): array {
        $data = $this->input($data);
        Validator::required($data, ['user_id', 'membership_id', 'start_date']);
        Validator::integer($data['user_id'], 'user_id');
        Validator::integer($data['membership_id'], 'membership_id');
        $start = Validator::date($data['start_date'], 'start_date');
        $plan = (new MembershipDao())->getById($data['membership_id']);
        if (!$plan) { throw new ValidationException('The selected membership does not exist.'); }
        if (!isset($data['end_date'])) {
            // Clamp January 31 + one month to February's last day, not March.
            $month = $start->modify('first day of this month')->modify('+' . (int)$plan['duration_months'] . ' months');
            $day = min((int)$start->format('d'), (int)$month->format('t'));
            $data['end_date'] = $month->setDate((int)$month->format('Y'), (int)$month->format('m'), $day)->format('Y-m-d');
        }
        return (new UserDao())->withLockedRow($data['user_id'], fn() => parent::create($data));
    }
    protected function validate(array $data, ?int $id = null): void {
        Validator::required($data, ['user_id', 'membership_id', 'start_date', 'end_date']);
        Validator::integer($data['user_id'], 'user_id');
        Validator::integer($data['membership_id'], 'membership_id');
        if (!(new UserDao())->getById($data['user_id'])) { throw new ValidationException('The selected user does not exist.'); }
        if (!(new MembershipDao())->getById($data['membership_id'])) { throw new ValidationException('The selected membership does not exist.'); }
        $start = Validator::date($data['start_date'], 'start_date');
        $end = Validator::date($data['end_date'], 'end_date');
        if ($end < $start) { throw new ValidationException('Membership end date must not precede the start date.'); }
        if ($this->dao->findOverlapping($data['user_id'], $data['start_date'], $data['end_date'], $id ?? 0)) {
            throw new ValidationException('This user already has a membership in this date range.');
        }
    }
    public function update($id, array $data): array {
        $current = $this->find($id);
        if (array_key_exists('user_id', $data)) {
            Validator::integer($data['user_id'], 'user_id');
            if ((int)$data['user_id'] !== (int)$current['user_id']) {
                throw new ValidationException('A purchased membership cannot be transferred to another user.');
            }
        }
        return (new UserDao())->withLockedRow($current['user_id'], fn() => parent::update($id, $data));
    }
    public function getByUser($id): array {
        Validator::integer($id, 'user_id');
        if (!(new UserDao())->getById($id)) { throw new NotFoundException('User not found.'); }
        return $this->dao->getByUser($id);
    }
    public function getActive($id): array {
        $this->getByUser($id);
        $row = $this->dao->getActiveMembership($id);
        if (!$row) { throw new NotFoundException('No active membership found.'); }
        return $row;
    }
}
