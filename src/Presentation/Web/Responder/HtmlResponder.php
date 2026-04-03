<?php

declare(strict_types=1);

namespace App\Presentation\Web\Responder;

use Smarty;

/**
 * Concrete HTML Responder using the Smarty Template Engine.
 */
class HtmlResponder implements ResponderInterface
{
    public function __construct(private readonly Smarty $smarty)
    {
    }

    /**
     * Renders a template with the given data.
     */
    public function render(string $template, array $data = []): void
    {
        if (!headers_sent()) {
            header('Content-Type: text/html; charset=UTF-8');
        }

        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display($template . '.tpl');
    }

    /**
     * Handles errors (404, 500, etc.)
     */
    public function error(int $statusCode, string $message): void
    {
        http_response_code($statusCode);
        
        $this->render('pages/error', [
            'statusCode' => $statusCode,
            'message' => $message,
            'pageTitle' => "Error {$statusCode}"
        ]);
        
        exit;
    }
}
