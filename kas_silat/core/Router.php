<?php
/**
 * Core Router Class
 */

class Router {
    protected $routes = [];
    protected $params = [];
    protected $middleware = [];
    
    /**
     * Add route - PERBAIKAN PENTING DI SINI!
     * Method ini harus menerima 4 parameter
     */
    public function add($route, $controller, $action, $method = 'GET') {
        $this->routes[] = [
            'route' => $route,
            'controller' => $controller,
            'action' => $action,
            'method' => strtoupper($method)
        ];
        return $this;
    }
    
    /**
     * Add GET route
     */
    public function get($route, $controller, $action) {
        return $this->add($route, $controller, $action, 'GET');
    }
    
    /**
     * Add POST route
     */
    public function post($route, $controller, $action) {
        return $this->add($route, $controller, $action, 'POST');
    }
    
    /**
     * Add PUT route
     */
    public function put($route, $controller, $action) {
        return $this->add($route, $controller, $action, 'PUT');
    }
    
    /**
     * Add DELETE route
     */
    public function delete($route, $controller, $action) {
        return $this->add($route, $controller, $action, 'DELETE');
    }
    
    /**
     * Dispatch route
     */
    public function dispatch($url) {
        $url = $this->removeQueryString($url);
        $method = $_SERVER['REQUEST_METHOD'];
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            
            if ($this->match($route['route'], $url)) {
                // Run middleware jika ada
                foreach ($this->middleware as $middleware) {
                    $this->runMiddleware($middleware);
                }
                
                // Load controller
                return $this->callController($route['controller'], $route['action']);
            }
        }
        
        // Cek route default (callback)
        foreach ($this->routes as $route) {
            if ($route['route'] === '' && is_callable($route['controller'])) {
                call_user_func($route['controller']);
                return;
            }
        }
        
        // Route not found
        $this->notFound();
    }
    
    /**
     * Match route pattern
     */
    protected function match($route, $url) {
        // Ubah parameter route menjadi regex pattern
        $pattern = $this->compilePattern($route);
        
        if (preg_match($pattern, $url, $matches)) {
            // Hapus full match
            array_shift($matches);
            $this->params = $matches;
            return true;
        }
        
        return false;
    }
    
    /**
     * Compile route pattern to regex
     */
    protected function compilePattern($route) {
        // Escape slashes
        $route = preg_replace('/\//', '\\/', $route);
        
        // Convert numeric parameter {id} atau ([0-9]+)
        $route = preg_replace('/\(\[0-9\]\+\)/', '([0-9]+)', $route);
        
        // Convert {param} to regex
        $route = preg_replace('/\{([a-z]+)\}/', '([a-zA-Z0-9-]+)', $route);
        
        // Add start and end delimiters
        return '/^' . $route . '$/';
    }
    
    /**
     * Remove query string from URL
     */
    protected function removeQueryString($url) {
        if ($url != '') {
            $parts = explode('?', $url, 2);
            $url = $parts[0];
        }
        return rtrim($url, '/');
    }
    
    /**
     * Call controller method
     */
    protected function callController($controller, $action) {
        $controllerFile = BASE_PATH . 'controllers/' . $controller . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            if (class_exists($controller)) {
                $controllerObject = new $controller();
                
                if (method_exists($controllerObject, $action)) {
                    call_user_func_array([$controllerObject, $action], $this->params);
                    return true;
                } else {
                    die("Method {$action} tidak ditemukan di controller {$controller}");
                }
            } else {
                die("Class {$controller} tidak ditemukan");
            }
        } else {
            die("File controller {$controller}.php tidak ditemukan");
        }
    }
    
    /**
     * Run middleware
     */
    protected function runMiddleware($middleware) {
        $middlewareFile = BASE_PATH . 'middleware/' . $middleware . '.php';
        
        if (file_exists($middlewareFile)) {
            require_once $middlewareFile;
            $middlewareClass = new $middleware();
            
            if (method_exists($middlewareClass, 'handle')) {
                $middlewareClass->handle();
            }
        }
    }
    
    /**
     * 404 Not Found
     */
    protected function notFound() {
        http_response_code(404);
        
        if (file_exists(BASE_PATH . 'views/errors/404.php')) {
            require_once BASE_PATH . 'views/errors/404.php';
        } else {
            echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
            echo "<p>URL yang Anda minta tidak tersedia.</p>";
            echo "<p><a href='" . BASE_URL . "/dashboard'>Kembali ke Dashboard</a></p>";
        }
        exit;
    }
}
?>