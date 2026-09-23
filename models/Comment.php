<?php
// models/Comment.php

require_once __DIR__ . '/../core/Model.php';

class Comment extends Model {
    /**
     * Insert a new comment
     */
    public function create(array $data): bool {
        $sql = "INSERT INTO comments (photo_id, user_id, comment) 
                VALUES (:photo_id, :user_id, :comment)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':photo_id' => $data['photo_id'],
            ':user_id'  => $data['user_id'],
            ':comment'  => $data['comment']
        ]);
    }

    /**
     * Get all comments for a specific photo
     */
    public function getByPhotoId(int $photoId): array {
        $sql = "SELECT c.*, u.first_name, u.last_name 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.photo_id = :photo_id 
                ORDER BY c.date_time ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':photo_id' => $photoId]);
        return $stmt->fetchAll();
    }
}