<?php

namespace App\Core;

class Controller
{
    public function render(string $view, array $data = []): void
    {
        extract($data); // Extract array to variables for the view
        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "View not found: " . htmlspecialchars($view);
        }
    }
    public function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }
}
