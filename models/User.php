<?php
// models/User.php

require_once __DIR__ . '/../core/Model.php';

class User extends Model {
    /**
     * Create a new user record.
     */
    public function create(array $data): bool {
        $sql = "INSERT INTO users (first_name, last_name, email, password, location, description, occupation) 
                VALUES (:first_name, :last_name, :email, :password, :location, :description, :occupation)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':first_name'  => $data['first_name'],
            ':last_name'   => $data['last_name'],
            ':email'       => $data['email'],
            ':password'    => password_hash($data['password'], PASSWORD_BCRYPT), // تشفير كلمة المرور
            ':location'    => $data['location'] ?? null,
            ':description' => $data['description'] ?? null,
            ':occupation'  => $data['occupation'] ?? null,
        ]);
    }

    /**
     * Find a user by their email address.
     */
    public function findByEmail(string $email): ?array {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    /**
     * Find a user by their ID.
     */
    public function findById(int $id): ?array {
        $sql = "SELECT id, first_name, last_name, email, location, description, occupation FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }
}