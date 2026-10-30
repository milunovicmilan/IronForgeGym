<?php
require_once __DIR__ . '/../config/Database.php';

class BaseDao {
    protected $table;
    protected $primaryKey;
    protected $connection;
    private $columns;

    public function __construct($table, $primaryKey) {
        $schema = [
            'users' => [
                'user_id','full_name','email',
                'password_hash','role','join_date'
            ],
            'categories' => [
                'category_id','name','description'
            ],
            'trainers' => [
                'trainer_id','full_name','specialization',
                'phone','email','experience_years'
            ],
            'classes' => [
                'class_id','title','description','category_id',
                'trainer_id','schedule_time','capacity'
            ],
            'memberships' => [
                'membership_id','name','description',
                'price','duration_months'
            ],
            'bookings' => [
                'booking_id','user_id','class_id',
                'booking_date','status'
            ],
            'user_memberships' => [
                'user_membership_id','user_id',
                'membership_id','start_date','end_date'
            ]
        ];

        if (!isset($schema[$table]) ||
            $schema[$table][0] !== $primaryKey) {
            throw new InvalidArgumentException(
                'Unsupported table or primary key.'
            );
        }

        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->columns = array_slice($schema[$table], 1);
        $this->connection = Database::connect();
    }

    public function getAll() {
        $stmt = $this->connection->prepare(
            "SELECT * FROM `{$this->table}`"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->connection->prepare(
            "SELECT * FROM `{$this->table}`
             WHERE `{$this->primaryKey}` = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    private function validateData($data) {
        if (!is_array($data) || !$data) {
            throw new InvalidArgumentException(
                'Data must be a non-empty array.'
            );
        }

        foreach (array_keys($data) as $column) {
            if (!in_array($column, $this->columns, true)) {
                throw new InvalidArgumentException(
                    'Unknown or non-writable column.'
                );
            }
        }
    }

    public function insert($data) {
        $this->validateData($data);

        $columns = '`' .
            implode('`, `', array_keys($data)) . '`';
        $parameters = ':' .
            implode(', :', array_keys($data));

        $stmt = $this->connection->prepare(
            "INSERT INTO `{$this->table}`
             ($columns) VALUES ($parameters)"
        );
        $stmt->execute($data);

        return (int)$this->connection->lastInsertId();
    }

    public function update($id, $data) {
        $this->validateData($data);
        $fields = [];

        foreach (array_keys($data) as $column) {
            $fields[] = "`$column` = :$column";
        }

        $sql = "UPDATE `{$this->table}` SET " .
            implode(', ', $fields) .
            " WHERE `{$this->primaryKey}` = :_id";

        $stmt = $this->connection->prepare($sql);
        $data['_id'] = $id;

        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->connection->prepare(
            "DELETE FROM `{$this->table}`
             WHERE `{$this->primaryKey}` = :id"
        );

        return $stmt->execute(['id' => $id]);
    }
}