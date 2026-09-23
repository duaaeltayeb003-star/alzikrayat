<?php
// models/Photo.php

require_once __DIR__ . '/../core/Model.php';

class Photo extends Model {
    /**
     * Create photo record
     */
    public function create(array $data): bool {
        $sql = "INSERT INTO photos (user_id, file_name, title, description) 
                VALUES (:user_id, :file_name, :title, :description)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id'     => $data['user_id'],
            ':file_name'   => $data['file_name'],
            ':title'       => $data['title'],
            ':description' => $data['description'] ?? null
        ]);
    }

    /**
     * Get all photos with uploader info
     */
    public function getAll(): array {
        $sql = "SELECT p.*, u.first_name, u.last_name 
                FROM photos p 
                JOIN users u ON p.user_id = u.id 
                ORDER BY p.date_time DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Find single photo by ID with uploader details
     */
    public function findById(int $id): ?array {
        $sql = "SELECT p.*, u.first_name, u.last_name 
                FROM photos p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $photo = $stmt->fetch();
        return $photo ?: null;
    }

    /**
     * Delete a photo record
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM photos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}