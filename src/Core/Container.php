<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use Smarty;
use RuntimeException;
use Dotenv\Dotenv;

/**
 * Dependency Injection Container.
 * Bootstraps the application and manages service lifecycles.
 */
class Container
{
    private array $services = [];
    private array $instances = [];

    public function __construct()
    {
        $this->bootstrap();
    }

    private function bootstrap(): void
    {
        // Load Environment Variables
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        // 1. Core Infrastructure: Database Connection (PDO)
        $this->set(PDO::class, function () {
            $dsn = sprintf(
                "mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4",
                $_ENV['DB_HOST'],
                $_ENV['DB_PORT'],
                $_ENV['DB_NAME']
            );

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                return new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $options);
            } catch (\PDOException $e) {
                throw new RuntimeException("Database connection failed: " . $e->getMessage());
            }
        });

        // 2. Core Infrastructure: Template Engine (Smarty)
        $this->set(Smarty::class, function () {
            $smarty = new Smarty();
            $baseDir = dirname(__DIR__, 2);
            
            $smarty->setTemplateDir($baseDir . '/templates');
            $smarty->setCompileDir($baseDir . '/templates_c');
            $smarty->setCacheDir($baseDir . '/cache');
            $smarty->setConfigDir($baseDir . '/config');
            
            // Security: Auto-escape all variables
            $smarty->escape_html = true;
            
            return $smarty;
        });

        // 3. Infrastructure Layer (Persistence)
        $this->set(\App\Domain\Repository\CategoryRepositoryInterface::class, function (Container $c) {
            return new \App\Infrastructure\Persistence\Pdo\PdoCategoryRepository($c->get(PDO::class));
        });

        $this->set(\App\Domain\Repository\ArticleRepositoryInterface::class, function (Container $c) {
            return new \App\Infrastructure\Persistence\Pdo\PdoArticleRepository($c->get(PDO::class));
        });

        // 4. Domain Layer (Services)
        $this->set(\App\Domain\Service\ArticleService::class, function (Container $c) {
            return new \App\Domain\Service\ArticleService(
                $c->get(\App\Domain\Repository\ArticleRepositoryInterface::class),
                $c->get(\App\Domain\Repository\CategoryRepositoryInterface::class)
            );
        });

        // 5. Presentation Layer (Responders)
        $this->set(\App\Presentation\Web\Responder\ResponderInterface::class, function (Container $c) {
            return new \App\Presentation\Web\Responder\HtmlResponder(
                $c->get(Smarty::class),
                $c->get(\App\Domain\Repository\CategoryRepositoryInterface::class)
            );
        });

        // 6. Presentation Layer (Actions)
        $this->set(\App\Presentation\Web\Action\MainPageAction::class, function (Container $c) {
            return new \App\Presentation\Web\Action\MainPageAction(
                $c->get(\App\Domain\Repository\ArticleRepositoryInterface::class),
                $c->get(\App\Presentation\Web\Responder\ResponderInterface::class)
            );
        });

        $this->set(\App\Presentation\Web\Action\CategoryPageAction::class, function (Container $c) {
            return new \App\Presentation\Web\Action\CategoryPageAction(
                $c->get(\App\Domain\Service\ArticleService::class),
                $c->get(\App\Presentation\Web\Responder\ResponderInterface::class)
            );
        });

        $this->set(\App\Presentation\Web\Action\ArticlePageAction::class, function (Container $c) {
            return new \App\Presentation\Web\Action\ArticlePageAction(
                $c->get(\App\Domain\Service\ArticleService::class),
                $c->get(\App\Presentation\Web\Responder\ResponderInterface::class)
            );
        });

        // 7. Core Infrastructure: Router
        $this->set(Router::class, function () {
            $router = new Router();
            
            // Register Routes
            $router->addRoute('GET', '/', \App\Presentation\Web\Action\MainPageAction::class, 'home');
            $router->addRoute('GET', '/index.php', \App\Presentation\Web\Action\MainPageAction::class);
            $router->addRoute('GET', '/article/{id}', \App\Presentation\Web\Action\ArticlePageAction::class, 'article');
            $router->addRoute('GET', '/category/{id}', \App\Presentation\Web\Action\CategoryPageAction::class, 'category');
            
            return $router;
        });
    }

    public function set(string $id, callable $factory): void
    {
        $this->services[$id] = $factory;
    }

    public function get(string $id): object
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (!isset($this->services[$id])) {
            throw new RuntimeException("Service not found: {$id}");
        }

        $this->instances[$id] = $this->services[$id]($this);
        return $this->instances[$id];
    }
}
