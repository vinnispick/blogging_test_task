<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Reusable Router component for handling HTTP requests and dynamic parameters.
 */
class Router
{
    private array $routes = [];
    private array $namedRoutes = [];

    /**
     * Add a new route to the map.
     *
     * @param string $method HTTP Method (GET, POST, etc.)
     * @param string $pattern URI pattern (e.g., /article/{id})
     * @param string $actionClass The class name of the Action to handle this route.
     * @param string|null $name Optional name for this route.
     */
    public function addRoute(string $method, string $pattern, string $actionClass, ?string $name = null): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'regex' => $this->convertToRegex($pattern),
            'action' => $actionClass,
        ];

        if ($name) {
            $this->namedRoutes[$name] = $pattern;
        }
    }

    /**
     * Dispatch the request to the matching route.
     *
     * @param string $method
     * @param string $uri
     * @return array|null Returns ['action' => string, 'params' => array] or null if no match.
     */
    public function dispatch(string $method, string $uri): ?array
    {
        $method = strtoupper($method);
        $uri = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['regex'], (string)$uri, $matches) === 1) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return [
                    'action' => $route['action'],
                    'params' => $params,
                ];
            }
        }

        return null;
    }

    /**
     * Generate a URL for a named route.
     *
     * @param string $name
     * @param array $params
     * @return string
     * @throws \RuntimeException If route name is not found or params are missing.
     */
    public function generateUrl(string $name, array $params = []): string
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new \RuntimeException("Route named '{$name}' not found.");
        }

        $url = $this->namedRoutes[$name];

        foreach ($params as $key => $value) {
            $placeholder = '{' . $key . '}';
            if (str_contains($url, $placeholder)) {
                $url = str_replace($placeholder, (string)$value, $url);
                unset($params[$key]);
            }
        }

        // If there are still placeholders like {id} in the URL, it's an error
        if (preg_match('/\{[a-zA-Z0-9_]+\}/', $url)) {
            throw new \RuntimeException("Missing parameters for route '{$name}': '{$url}'");
        }

        // Append remaining params as query string
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    /**
     * Convert URI pattern like /article/{id} to a regex.
     */
    private function convertToRegex(string $pattern): string
    {
        $regex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $pattern);
        return '#^' . $regex . '$#';
    }
}
