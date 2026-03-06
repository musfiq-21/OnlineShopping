<?php
require_once __DIR__ . '/../config/database.php';

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
        $stmt = $this->db->prepare("
            SELECT ID as id, Name as name, Role as role, Hashed_password as hashed_password 
            FROM Users WHERE ID = :id LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    public function findByName(string $name): ?User {
        $stmt = $this->db->prepare("
            SELECT ID as id, Name as name, Role as role, Hashed_password as hashed_password 
            FROM Users WHERE Name = :name LIMIT 1
        ");
        $stmt->execute(['name' => $name]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    public function create(string $name, string $role, string $password): bool {
        $stmt = $this->db->prepare("
            INSERT INTO Users (Name, Role, Hashed_password) 
            VALUES (:name, :role, :password)
        ");
        return $stmt->execute([
            'name' => $name,
            'role' => $role,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public function existsByName(string $name): bool {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Users WHERE Name = :name");
        $stmt->execute(['name' => $name]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function getAll(): array {
        $stmt = $this->db->query("
            SELECT ID as id, Name as name, Role as role 
            FROM Users ORDER BY ID
        ");
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM Users WHERE ID = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function updatePassword(int $id, string $password): bool {
        $stmt = $this->db->prepare("UPDATE Users SET Hashed_password = :password WHERE ID = :id");
        return $stmt->execute([
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'id' => $id
        ]);
    }
}
