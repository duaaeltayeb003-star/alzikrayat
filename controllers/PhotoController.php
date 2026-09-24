<?php
// controllers/PhotoController.php

require_once __DIR__ . '/../models/Photo.php';
require_once __DIR__ . '/../models/Comment.php';

class PhotoController extends Controller {
    private Photo $photoModel;
    private Comment $commentModel;

    public function __construct() {
        $this->photoModel = new Photo();
        $this->commentModel = new Comment();
    }

    /**
     * Display photo gallery with live statistics and layout support
     */
    public function index(): void {
        $photos = $this->photoModel->getAll();

        // Fetch live statistics
        $db = Database::getConnection();
        $totalUsers = (int) $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $totalPhotos = (int) $db->query("SELECT COUNT(*) FROM photos")->fetchColumn();
        $totalComments = (int) $db->query("SELECT COUNT(*) FROM comments")->fetchColumn();

        $this->render('photos/index', [
            'photos'        => $photos,
            'layoutStyle'   => $_GET['style'] ?? 'grid-3',
            'totalUsers'    => $totalUsers,
            'totalPhotos'   => $totalPhotos,
            'totalComments' => $totalComments
        ]);
    }

    /**
     * Show upload form
     */
    public function create(): void {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/alzikrayat/public/login');
        }
        $this->render('photos/create');
    }

    /**
     * Handle photo upload
     */
    public function store(): void {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/alzikrayat/public/login');
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $errors = [];

        if (empty($title)) {
            $errors[] = "Photo title is required.";
        }

        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Please select a valid image file.";
        } else {
            $file = $_FILES['image'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            
            // Validate MIME type securely
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mimeType, $allowedTypes)) {
                $errors[] = "Only JPG, PNG, GIF, and WEBP images are allowed.";
            }

            if ($file['size'] > 5 * 1024 * 1024) { // 5MB limit
                $errors[] = "Image size must not exceed 5MB.";
            }
        }

        if (!empty($errors)) {
            $this->render('photos/create', ['errors' => $errors]);
            return;
        }

        // Generate unique filename
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newFileName = 'photo_' . uniqid() . '.' . strtolower($extension);
        $destination = __DIR__ . '/../public/images/uploads/' . $newFileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            $this->photoModel->create([
                'user_id'     => $_SESSION['user_id'],
                'file_name'   => $newFileName,
                'title'       => $title,
                'description' => $description
            ]);
            $this->redirect('/alzikrayat/public/photos');
        } else {
            $this->render('photos/create', ['errors' => ['Failed to save uploaded file on server disk.']]);
        }
    }

    /**
     * Show single photo details with its comments
     */
    public function show(string $id): void {
        $photoId = (int)$id;
        $photo = $this->photoModel->findById($photoId);

        if (!$photo) {
            http_response_code(404);
            echo "Photo not found.";
            return;
        }

        $comments = $this->commentModel->getByPhotoId($photoId);
        $this->render('photos/show', [
            'photo'    => $photo,
            'comments' => $comments
        ]);
    }

    /**
     * Delete photo (Restricted to photo owner only)
     */
    /**
     * Delete photo (Restricted to photo owner only)
     */
    public function delete(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ($GLOBALS['base'] ?? '/alzikrayat/public') . '/login');
            exit;
        }

        $photoId = (int)($_POST['id'] ?? 0);
        if ($photoId > 0) {
            $photo = $this->photoModel->findById($photoId);

            // التحقق من أن المستخدم الحالي هو صاحب الصورة فقط
            if ($photo && (int)$photo['user_id'] === (int)$_SESSION['user_id']) {
                $filePath = dirname(__DIR__) . '/public/images/uploads/' . $photo['file_name'];
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
                $this->photoModel->delete($photoId);
            }
        }

        header('Location: ' . ($GLOBALS['base'] ?? '/alzikrayat/public') . '/photos');
        exit;
    }
}