<?php
declare(strict_types=1);

namespace App;

use App\Middleware\CorsMiddleware;
use App\Middleware\LoggingMiddleware;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\Middleware\EncryptedCookieMiddleware;
use Cake\Http\Middleware\SecurityHeadersMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\I18n\Middleware\LocaleSelectorMiddleware;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

class Application extends BaseApplication
{
    public function bootstrap(): void
    {
        parent::bootstrap();
        $this->addPlugin('Modern');

        if (PHP_SAPI !== 'cli') {
            FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
        }
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $securityHeaders = new SecurityHeadersMiddleware();
        $securityHeaders->setXFrameOptions("sameorigin");

        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
            ->add(new LoggingMiddleware())
            ->add(new CorsMiddleware())
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]))
            ->add(new EncryptedCookieMiddleware(
                [],
                "Configure::read('Security.cookieKey')"
            ))
            ->add($securityHeaders)
            ->add(new LocaleSelectorMiddleware(['en', 'hi', 'fr']));

        return $middlewareQueue;
    }

    public function services(ContainerInterface $container): void
    {
    }
}
