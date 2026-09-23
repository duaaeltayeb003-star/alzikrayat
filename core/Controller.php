<?php
// core/Controller.php

class Controller {
    /**
     * Render a view template and extract passed variables.
     *
     * @param string $viewPath e.g. 'photos/index'
     * @param array $data Data to inject into the view
     */
    protected function render(string $viewPath, array $data = []): void {
        extract($data);

        $file = __DIR__ . '/../views/' . $viewPath . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo "View file not found: " . htmlspecialchars($viewPath);
        }
    }

    /**
     * Redirect to a specific application path.
     *
     * @param string $path
     */
    protected function redirect(string $path): void {
        header("Location: " . $path);
        exit;
    }
}