<?php

declare(strict_types=1);

namespace App\Presentation\Web\Action;

/**
 * Interface ActionInterface
 * Basis for all web-accessible actions.
 */
interface ActionInterface
{
    /**
     * Executes the action.
     * 
     * @param array $request Merged $_GET and $_POST parameters.
     */
    public function __invoke(array $request): void;
}
