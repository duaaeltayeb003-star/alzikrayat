<?php
// controllers/AuthController.php

require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function showRegister(): void {
        $this->render('auth/register');
    }

    public function register(): void {
        $firstName   = trim($_POST['first_name'] ?? '');
        $lastName    = trim($_POST['last_name'] ?? '');
        $email       = trim($_POST['email'] ?? '');
        $password    = $_POST['password'] ?? '';
        $location    = trim($_POST['location'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $occupation  = trim($_POST['occupation'] ?? '');

        $errors = [];

        if (empty($firstName) || !preg_match('/^[a-zA-Z\s]+$/', $firstName)) {
            $errors[] = "First name is required and must contain letters only.";
        }
        if (empty($lastName) || !preg_match('/^[a-zA-Z\s]+$/', $lastName)) {
            $errors[] = "Last name is required and must contain letters only.";
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "A valid email address is required.";
        }
        if (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters.";
        }
        if ($this->userModel->findByEmail($email)) {
            $errors[] = "This email is already registered.";
        }

        if (!empty($errors)) {
            $this->render('auth/register', ['errors' => $errors]);
            return;
        }

        $created = $this->userModel->create([
            'first_name'  => $firstName,
            'last_name'   => $lastName,
            'email'       => $email,
            'password'    => $password,
            'location'    => $location,
            'description' => $description,
            'occupation'  => $occupation,
        ]);

        if ($created) {
            $this->redirect('/alzikrayat/public/login');
        } else {
            $this->render('auth/register', ['errors' => ['Failed to register user. Try again.']]);
        }
    }

    public function showLogin(): void {
        $lastLoginCookie = $_COOKIE['last_login'] ?? null;
        $this->render('auth/login', ['lastLoginCookie' => $lastLoginCookie]);
    }

    public function login(): void {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        if (empty($email) || empty($password)) {
            $errors[] = "Both email and password are required.";
            $this->render('auth/login', ['errors' => $errors]);
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name']  = $user['last_name'];
            $_SESSION['email']      = $user['email'];

            $timestamp = date('Y-m-d H:i:s');
            setcookie('last_login', $timestamp, time() + (7 * 24 * 60 * 60), '/');

            $this->redirect('/alzikrayat/public/');
        } else {
            $errors[] = "Invalid email or password.";
            $lastLoginCookie = $_COOKIE['last_login'] ?? null;
            $this->render('auth/login', [
                'errors'          => $errors,
                'lastLoginCookie' => $lastLoginCookie
            ]);
        }
    }

    public function logout(): void {
        unset($_SESSION['user_id']);
        unset($_SESSION['first_name']);
        unset($_SESSION['last_name']);
        unset($_SESSION['email']);
        session_destroy();

        $this->redirect('/alzikrayat/public/login');
    }
}