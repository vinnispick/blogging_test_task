<?php

declare(strict_types=1);

namespace App\Presentation\Web\Responder;

/**
 * Responder Interface for handling output in the ADR pattern.
 */
interface ResponderInterface
{
    /**
     * Renders a template with the given data.
     * 
     * @param string $template Template name (without extension).
     * @param array $data Variables to pass to the template.
     */
    public function render(string $template, array $data = []): void;

    /**
     * Handles errors (404, 500, etc.)
     * 
     * @param int $statusCode HTTP Status Code.
     * @param string $message Error message.
     */
    public function error(int $statusCode, string $message): void;
}
