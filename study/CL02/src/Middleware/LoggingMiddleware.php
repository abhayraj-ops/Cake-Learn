<?php
declare(strict_types=1);

namespace App\Middleware;

use Cake\Log\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoggingMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {

        Log::info(sprintf(
            '[%s] %s %s',
            date('Y-m-d H:i:s'),
            $request->getMethod(),
            $request->getRequestTarget()
        ));

        $response = $handler->handle($request);

        Log::info(sprintf(
            'Response: %s for %s',
            $response->getStatusCode(),
            $request->getRequestTarget()
        ));

        return $response;

    }
}
