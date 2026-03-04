<?php
require __DIR__ . '/../../core/Database.php';
require __DIR__ .'/../../core/utils.php';
class User {
    public int $id;
    public string $name;
    public string $role;
    public string $hashed_password;

    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findById(int $id): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class, [$this->db]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findByName(string $name): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE name = :name LIMIT 1");
        $stmt->execute(['name' => $name]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class, [$this->db]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(string $name, string $role, string $hashed_password): bool {
        $stmt = $this->db->prepare("
            INSERT INTO users (name, role, hashed_password) VALUES (:name, :role, :hashed_password)
        ");
        return $stmt->execute([
            'name' => $name,
            'role' => $role,
            'hashed_password' => hashUserPassword($hashed_password)
        ]);
    }

    public function existsByName(string $name): bool {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE name = :name");
        $stmt->execute(['name' => $name]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function getAllUsers(): array {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class, [$this->db]);
    }

    public function deleteById(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}