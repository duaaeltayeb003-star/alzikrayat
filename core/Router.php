<?php
// core/Router.php

class Router {
    private array $routes = [];

    public function add(string $method, string $path, array $handler): void {
        $this->routes[] = [
            'method'  => strtoupper($method),
            'path'    => '/' . trim($path, '/'),
            'handler' => $handler
        ];
    }

    public function dispatch(string $method, string $uri): void {
        $path = parse_url($uri, PHP_URL_PATH);

        // إزالة مسار المجلد الفرعي (alzikrayat/public) تلقائياً
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if ($scriptDir !== '/' && str_starts_with($path, $scriptDir)) {
            $path = substr($path, strlen($scriptDir));
        }

        $path = '/' . trim($path, '/');
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            // تحويل المعاملات مثل {id} إلى نمط regex يقبل الأرقام والحروف
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#i';

            if ($route['method'] === $method && preg_match($pattern, $path, $matches)) {
                array_shift($matches); // إزالة الرابط الكامل وإبقاء قيمة المعامل (مثل 5)
                
                [$controllerName, $action] = $route['handler'];
                
                $controllerFile = dirname(__DIR__) . '/controllers/' . $controllerName . '.php';
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                }

                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (method_exists($controller, $action)) {
                        call_user_func_array([$controller, $action], $matches);
                        return;
                    }
                }
            }
        }

        http_response_code(404);
        $base = $GLOBALS['base'] ?? '/alzikrayat/public';
        echo "<div style='text-align:center; padding:50px; font-family:sans-serif;'>";
        echo "<h2>404 - Page Not Found</h2>";
        echo "<p>No route matched for <strong>[$method] $path</strong></p>";
        echo "<a href='{$base}/photos'>Return to Gallery</a>";
        echo "</div>";
        exit;
    }
}