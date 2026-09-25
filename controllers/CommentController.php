<?php
// controllers/CommentController.php

require_once __DIR__ . '/../models/Comment.php';

class CommentController extends Controller {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new Comment();
    }

    public function store(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ($GLOBALS['base'] ?? '/alzikrayat/public') . '/login');
            exit;
        }

        $photoId = $_POST['photo_id'] ?? null;
        $commentText = trim($_POST['comment'] ?? '');

        if ($photoId && !empty($commentText)) {
            $this->commentModel->create([
                'photo_id' => $photoId,
                'user_id'  => $_SESSION['user_id'],
                'comment'  => $commentText
            ]);
        }

        header('Location: ' . ($GLOBALS['base'] ?? '/alzikrayat/public') . '/photos/' . $photoId);
        exit;
    }
}