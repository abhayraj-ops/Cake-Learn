# CakePHP Routing Tutorial Task

Complete the following tasks to master CakePHP Routing. This tutorial covers all routing concepts from the CakePHP documentation.

## Prerequisites
- A working CakePHP 5.x application
- Basic understanding of MVC pattern
- Access to `config/routes.php`

---

## Task 1: Basic Routing (Quick Tour)

### 1.1 Home Page Route
Create a route that maps the homepage URL `/` to the `index` action of `ArticlesController`.

```php
$routes->connect('/', ['controller' => 'Articles', 'action' => 'index']);
```

**Task**: Implement this route in your `config/routes.php` and create the `ArticlesController` with an `index()` action that displays "Welcome to Articles".

### 1.2 Wildcard Routes
Create a route that accepts any URL pattern starting with `/articles/` and maps to the `view` action.

**Task**: 
- Add route: `$routes->connect('/articles/*', ['controller' => 'Articles', 'action' => 'view']);`
- Create a `view($id = null)` action that accepts the ID parameter
- Test URLs like `/articles/15`, `/articles/foobar`

### 1.3 Route Elements with Regex
Create a route that only accepts numeric IDs using placeholders and regex patterns.

**Task**: Implement:
```php
$routes->connect(
    '/articles/{id}',
    ['controller' => 'Articles', 'action' => 'view'],
)->setPatterns(['id' => '\d+'])->setPass(['id']);
```

Test that `/articles/123` works but `/articles/abc` fails.

### 1.4 Reverse Routing
**Task**: Use `Router::url()` to generate URLs from arrays:
```php
echo Router::url(['controller' => 'Articles', 'action' => 'view', 'id' => 15]);
// Should output: /articles/15
```

---

## Task 2: Connecting Routes & Routing Scopes

### 2.1 Basic connect() Method
**Task**: Create routes using different formats:
```php
// Array target
$routes->connect('/users/view/*', ['controller' => 'Users', 'action' => 'view']);

// String target
$routes->connect('/users/view/*', 'Users::view');
```

### 2.2 Routing Scopes
**Task**: Create a scope for blog routes:
```php
$routes->scope('/blog', ['plugin' => 'Blog'], function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Articles']);
});
```
This should match `/blog/` and map to `Blog\Controller\ArticlesController::index()`.

### 2.3 Default Route Parameters
**Task**: Create a route with default parameters:
```php
$routes->connect('/government', ['controller' => 'Pages', 'action' => 'display', 5]);
```
This should map `/government` to `/pages/display/5`.

---

## Task 3: Route Elements

### 3.1 Custom Route Elements
**Task**: Create a generic route for any controller:
```php
$routes->connect(
    '/{controller}/{id}',
    ['action' => 'view'],
)->setPatterns(['id' => '[0-9]+']);
```
Test `/apples/5` should call `ApplesController::view(5)`.

### 3.2 DashedRoute for SEO
**Task**: Configure routes to use DashedRoute for lowercase dashed URLs:
```php
use Cake\Routing\Route\DashedRoute;

$routes->scope('/', function (RouteBuilder $routes) {
    $routes->setRouteClass(DashedRoute::class);
    $routes->connect('/{controller}/{id}', ['action' => 'view'])
        ->setPatterns(['id' => '[0-9]+']);
});
```

### 3.3 Date-based Routes
**Task**: Create a route with multiple route elements and regex:
```php
$routes->connect(
    '/{controller}/{year}/{month}/{day}',
    ['action' => 'index'],
)->setPatterns([
    'year' => '[12][0-9]{3}',
    'month' => '0[1-9]|1[012]',
    'day' => '0[1-9]|[12][0-9]|3[01]',
]);
```
Test URLs like `/articles/2007/02/01`.

---

## Task 4: Reserved Route Elements

**Task**: Understand and use special route elements:
- `controller` - Specifies the controller
- `action` - Specifies the controller action
- `plugin` - Specifies the plugin
- `prefix` - For prefix routing
- `_ext` - For file extensions
- `_name` - For named routes
- `_https` - Force HTTPS
- `_host` - Specify hostname
- `_full` - Include full base URL

Example:
```php
$routes->connect('/login', ['controller' => 'Users', 'action' => 'login'], ['_name' => 'login']);
```

---

## Task 5: Route Options Configuration

### 5.1 Fluent Route Builders
**Task**: Use fluent setters to configure routes:
```php
$routes->connect(
    '/{lang}/articles/{slug}',
    ['controller' => 'Articles', 'action' => 'view'],
)
->setMethods(['GET', 'POST'])
->setHost('blog.example.com')
->setPass(['slug'])
->setPatterns([
    'slug' => '[a-z0-9-_]+',
    'lang' => 'en|fr|es',
])
->setExtensions(['json'])
->setPersist(['lang']);
```

### 5.2 Default Options for Scope
**Task**: Set default options for all routes in a scope:
```php
$routes->scope('/api', function (RouteBuilder $routes) {
    $routes->setOptions([
        '_host' => 'api.example.com',
        '_https' => true,
    ]);
    $routes->get('/users', ['controller' => 'Users', 'action' => 'index']);
    $routes->get('/posts', ['controller' => 'Posts', 'action' => 'index']);
});
```

---

## Task 6: Passing Parameters to Actions

**Task**: Use `setPass()` to pass route elements as function arguments:
```php
// In routes.php
$routes->connect(
    '/blog/{id}-{slug}',
    ['controller' => 'Blogs', 'action' => 'view'],
)->setPass(['id', 'slug'])->setPatterns(['id' => '[0-9]+']);

// In BlogsController.php
public function view($articleId = null, $slug = null)
{
    // $this->request->getParam('id') and $slug are available
}
```

Test URL `/blog/3-CakePHP_Rocks` should call `view(3, 'CakePHP_Rocks')`.

---

## Task 7: Path Routing & Named Routes

### 7.1 Using Router::pathUrl()
**Task**: Generate URLs using path syntax:
```php
echo Router::pathUrl('Articles::index'); // outputs: /articles
echo Router::pathUrl('MyBackend.Admin/Articles::view', [3]); 
// outputs: /admin/my-backend/articles/view/3
```

### 7.2 Named Routes
**Task**: Create and use named routes:
```php
// In routes.php
$routes->connect('/login', ['controller' => 'Users', 'action' => 'login'], ['_name' => 'login']);
$routes->post('/logout', ['controller' => 'Users', 'action' => 'logout'], 'logout');

// Generate URL
Router::url(['_name' => 'logout']);
Router::url(['_name' => 'login', 'username' => 'jimmy']);
```

### 7.3 Name Prefixes
**Task**: Use name prefixes in scopes:
```php
$routes->scope('/api', ['_namePrefix' => 'api:'], function (RouteBuilder $routes) {
    $routes->get('/ping', ['controller' => 'Pings'], 'ping');
});
Router::url(['_name' => 'api:ping']);
```

---

## Task 8: Prefix Routing

### 8.1 Basic Prefix Routes
**Task**: Create admin prefix routes:
```php
$routes->prefix('Admin', function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'index']);
    $routes->fallbacks(DashedRoute::class);
});
```
This creates `/admin` URL prefix. Access `src/Controller/Admin/UsersController.php` for `/admin/users`.

### 8.2 Nested Prefixes
**Task**: Create nested prefixes:
```php
$routes->prefix('Manager', function (RouteBuilder $routes) {
    $routes->prefix('Admin', function (RouteBuilder $routes) {
        $routes->connect('/{controller}/{action}');
    });
});
```
Creates `/manager/admin/{controller}/{action}`.

### 8.3 Custom Prefix Path
**Task**: Use custom path for multi-word prefixes:
```php
$routes->prefix('MyPrefix', ['path' => '/my_prefix'], function (RouteBuilder $routes) {
    $routes->connect('/{controller}');
});
```

### 8.4 Links to Prefix Routes
**Task**: Generate links to prefixed routes:
```php
// Go into a prefixed route
$this->Html->link('Manage articles', ['prefix' => 'Admin', 'controller' => 'Articles', 'action' => 'add']);

// Leave a prefix
$this->Html->link('View Post', ['prefix' => false, 'controller' => 'Articles', 'action' => 'view', 5]);
```

---

## Task 9: Plugin Routing

### 9.1 Basic Plugin Routes
**Task**: Create routes for a plugin:
```php
$routes->plugin('DebugKit', function (RouteBuilder $routes) {
    $routes->connect('/{controller}');
});
```
Creates `/debug-kit/{controller}` URL prefix.

### 9.2 Custom Plugin Path
**Task**: Customize plugin URL path:
```php
$routes->plugin('DebugKit', ['path' => '/debugger'], function (RouteBuilder $routes) {
    $routes->connect('/{controller}');
});
```

### 9.3 Nested Plugin and Prefix
**Task**: Nest plugin within prefix:
```php
$routes->prefix('Admin', function (RouteBuilder $routes) {
    $routes->plugin('DebugKit', function (RouteBuilder $routes) {
        $routes->connect('/{controller}');
    });
});
```
Creates `/admin/debug-kit/{controller}`.

### 9.4 Links to Plugin Routes
**Task**: Generate links to plugins:
```php
// Link to a plugin
$this->Html->link('New todo', ['plugin' => 'Todo', 'controller' => 'TodoItems', 'action' => 'create']);

// Link outside of plugin
$this->Html->link('New todo', ['plugin' => null, 'controller' => 'Users', 'action' => 'profile']);
```

---

## Task 10: HTTP Method Specific Routes

**Task**: Create routes that respond to specific HTTP methods:
```php
$routes->get('/cooks/{id}', ['controller' => 'Users', 'action' => 'view'], 'users:view');
$routes->put('/cooks/{id}', ['controller' => 'Users', 'action' => 'update'], 'users:update');
$routes->post('/reviews/start', ['controller' => 'Reviews', 'action' => 'start']);
$routes->connect('/reviews/start', ['controller' => 'Reviews', 'action' => 'start'])
    ->setMethods(['POST', 'PUT']);
```

Available methods: GET, POST, PUT, PATCH, DELETE, OPTIONS, HEAD

---

## Task 11: Hostname Routing

**Task**: Match specific hostnames:
```php
$routes->connect('/images/default-logo.png', ['controller' => 'Images', 'action' => 'default'])
    ->setHost('images.example.com');

$routes->connect('/images/old-logo.png', ['controller' => 'Images', 'action' => 'oldLogo'])
    ->setHost('*.example.com');

// Generate URL with host
Router::url(['controller' => 'Images', 'action' => 'oldLogo', '_host' => 'images.example.com']);
```

---

## Task 12: File Extensions

### 12.1 Basic Extensions
**Task**: Enable file extensions for routes:
```php
$routes->scope('/', function (RouteBuilder $routes) {
    $routes->setExtensions(['json', 'xml', 'html']);
});
```

### 12.2 Extension-based Routes
**Task**: Create routes that use extensions:
```php
$routes->scope('/page', function (RouteBuilder $routes) {
    $routes->setExtensions(['json', 'xml', 'html']);
    $routes->connect('/{title}', ['controller' => 'Pages', 'action' => 'view'])
        ->setPass(['title']);
});

// Generate URL with extension
$this->Html->link('Link title', ['controller' => 'Pages', 'action' => 'view', 'title' => 'super-article', '_ext' => 'html']);
```

---

## Task 13: Route Scoped Middleware

### 13.1 Applying Middleware to Scopes
**Task**: Register and apply middleware to routes:
```php
// In routes.php
use Cake\Http\Middleware\CsrfProtectionMiddleware;

$routes->registerMiddleware('csrf', new CsrfProtectionMiddleware());

$routes->scope('/cms', function (RouteBuilder $routes) {
    $routes->applyMiddleware('csrf');
    $routes->get('/articles/{action}/*', ['controller' => 'Articles']);
});
```

### 13.2 Middleware Groups
**Task**: Create and apply middleware groups:
```php
$routes->registerMiddleware('cookie', new EncryptedCookieMiddleware());
$routes->registerMiddleware('auth', new AuthenticationMiddleware());
$routes->registerMiddleware('csrf', new CsrfProtectionMiddleware());
$routes->middlewareGroup('web', ['cookie', 'auth', 'csrf']);

$routes->applyMiddleware('web');
```

### 13.3 Nested Scope Middleware
**Task**: Understand middleware inheritance:
```php
$routes->scope('/api', function (RouteBuilder $routes) {
    $routes->applyMiddleware('ratelimit', 'auth.api');
    $routes->scope('/v1', function (RouteBuilder $routes) {
        $routes->applyMiddleware('v1compat');
        // Routes here get all three middleware
    });
});
```

---

## Task 14: RESTful Routing

### 14.1 Basic Resource Routes
**Task**: Create RESTful routes for a controller:
```php
$routes->scope('/', function (RouteBuilder $routes) {
    $routes->setExtensions(['json']);
    $routes->resources('Recipes');
});
```

This creates:
| HTTP Method | URL | Controller Action |
|-------------|-----|-------------------|
| GET | /recipes | index() |
| GET | /recipes/{id} | view($id) |
| POST | /recipes | add() |
| PUT | /recipes/{id} | edit($id) |
| PATCH | /recipes/{id} | edit($id) |
| DELETE | /recipes/{id} | delete($id) |

### 14.2 Nested Resources
**Task**: Create nested resource routes:
```php
$routes->scope('/api', function (RouteBuilder $routes) {
    $routes->resources('Articles', function (RouteBuilder $routes) {
        $routes->resources('Comments');
    });
});
```
Creates `/api/articles/{article_id}/comments`.

### 14.3 Limited Resources
**Task**: Restrict which routes are created:
```php
$routes->resources('Articles', ['only' => ['index', 'view']]);
```

### 14.4 Custom Actions
**Task**: Map additional resource methods:
```php
$routes->resources('Articles', [
    'map' => [
        'deleteAll' => ['action' => 'deleteAll', 'method' => 'DELETE'],
    ],
]);
```

### 14.5 Custom Path and Inflection
**Task**: Customize resource URLs:
```php
$routes->resources('BlogPosts', ['path' => 'posts', 'inflect' => 'underscore']);
// Creates /blog_posts URL
```

---

## Task 15: Passed Arguments

### 15.1 Understanding Passed Arguments
**Task**: Work with passed arguments:
```php
// URL: /calendars/view/recent/mark
// In CalendarsController
public function view($arg1, $arg2)
{
    // $arg1 = 'recent', $arg2 = 'mark'
    // Also available at $this->request->getParam('pass')
}
```

### 15.2 Generating URLs with Passed Arguments
**Task**: Use numeric keys for passed arguments:
```php
Router::url(['controller' => 'Articles', 'action' => 'view', 5]);
// 5 is a passed argument
```

---

## Task 16: Generating URLs

### 16.1 Using Router::url()
**Task**: Generate URLs with various options:
```php
// Basic URL
Router::url(['controller' => 'Articles', 'action' => 'view', 'id' => 15]);

// With query string and fragment
Router::url(['controller' => 'Articles', 'action' => 'index', '?' => ['page' => 1], '#' => 'top']);

// With special elements
Router::url(['controller' => 'Articles', 'action' => 'view', 'id' => 15, '_full' => true, '_https' => true]);
```

### 16.2 Using Router::reverse()
**Task**: Generate URLs from request params:
```php
$requestParams = Router::getRequest()->getAttribute('params');
$this->Html->link('View', Router::reverse($requestParams));
```

### 16.3 Routing Arrays vs Request Parameters
**Task**: Understand the difference:

Routing Arrays (pass as un-keyed values):
```php
['controller' => 'Articles', 'action' => 'View', $id, 'page' => 3]
```

Request Parameters (pass on 'pass' key):
```php
['controller' => 'Articles', 'action' => 'View', 'pass' => [$id], '?' => ['page' => 3]]
```

---

## Task 17: Asset URLs

**Task**: Generate asset URLs:
```php
use Cake\Routing\Asset;

// JavaScript
Asset::scriptUrl('app.js');

// CSS
Asset::cssUrl('app.css');

// Images
Asset::imageUrl('logo.png');

// Files
Asset::url('files/upload/photo.png');

// With options
Asset::url('logo.png', ['fullBase' => true, 'timestamp' => true]);

// Plugin assets
Asset::imageUrl('DebugKit.cake.png');
```

---

## Task 18: Redirect Routing

### 18.1 Internal Redirects
**Task**: Create redirect routes:
```php
$routes->scope('/', function (RouteBuilder $routes) {
    $routes->redirect('/home/*', ['controller' => 'Articles', 'action' => 'view'], ['persist' => true]);
});
```
Redirects `/home/5` to `/articles/view/5`.

### 18.2 External Redirects
**Task**: Redirect to external URLs:
```php
$routes->redirect('/articles/*', 'http://google.com', ['status' => 302]);
```

---

## Task 19: Entity Routing

**Task**: Use entities for URL generation:
```php
use Cake\Routing\Route\EntityRoute;

// Enable entity routes for scope
$routes->setRouteClass(EntityRoute::class);

// Define route
$routes->get('/view/{id}/{slug}', ['controller' => 'Articles', 'action' => 'view'], 'articles:view');

// Generate URL using entity
Router::url(['_name' => 'articles:view', '_entity' => $article]);
// Automatically extracts id and slug from entity
```

---

## Task 20: Custom Route Classes

### 20.1 Creating Custom Route Class
**Task**: Create a custom route class:
```php
// src/Routing/Route/SlugRoute.php
namespace App\Routing\Route;

use Cake\Routing\Route\Route;

class SlugRoute extends Route
{
    public function parse($url, $method = '')
    {
        $params = parent::parse($url, $method);
        // Custom parsing logic
        return $params;
    }
    
    public function match($url, array $context = [])
    {
        // Custom matching logic
        return parent::match($url, $context);
    }
}
```

### 20.2 Using Custom Route Class
**Task**: Apply custom route class:
```php
// Per route
$routes->connect('/{slug}', ['controller' => 'Articles', 'action' => 'view'], ['routeClass' => 'SlugRoute']);

// For entire scope
$routes->scope('/', function (RouteBuilder $routes) {
    $routes->setRouteClass('SlugRoute');
    $routes->connect('/{slug}', ['controller' => 'Articles', 'action' => 'view']);
});
```

---

## Task 21: Fallbacks

**Task**: Use fallbacks method:
```php
use Cake\Routing\Route\DashedRoute;

// Simple fallback
$routes->fallbacks(DashedRoute::class);

// Equivalent to:
$routes->connect('/{controller}', ['action' => 'index'], ['routeClass' => DashedRoute::class]);
$routes->connect('/{controller}/{action}/*', [], ['routeClass' => DashedRoute::class]);
```

---

## Task 22: Persistent URL Parameters

### 22.1 URL Filters
**Task**: Create URL filter for persistent parameters:
```php
use Cake\Routing\Router;

Router::addUrlFilter(function (array $params, ServerRequest $request) {
    if ($request->getParam('lang') && !isset($params['lang'])) {
        $params['lang'] = $request->getParam('lang');
    }
    return $params;
});
```

### 22.2 Runtime Route Modifications
**Task**: Modify routes at runtime:
```php
Router::addUrlFilter(function (array $params, ServerRequest $request) {
    if (empty($params['plugin']) || $params['plugin'] !== 'MyPlugin') {
        return $params;
    }
    if ($params['controller'] === 'Languages' && $params['action'] === 'view') {
        $params['controller'] = 'Locations';
        $params['action'] = 'index';
        $params['language'] = $params[0];
        unset($params[0]);
    }
    return $params;
});
```

---

## Final Project: Build a Complete Blog API

Combine all concepts to build a complete blog API:

1. **Basic Routes**: Home page, static pages
2. **Resource Routes**: Articles CRUD at `/articles`
3. **Nested Resources**: Comments at `/articles/{article_id}/comments`
4. **Prefix Routing**: Admin panel at `/admin`
5. **Plugin Routing**: Comments plugin at `/comments`
6. **REST API**: JSON API at `/api`
7. **Custom Routes**: Custom search at `/search`
8. **Redirects**: Old URLs to new ones
9. **File Extensions**: JSON/XML responses
10. **Authentication**: Protected routes with middleware

### Example Implementation:
```php
// config/routes.php
use Cake\Routing\Route\DashedRoute;

$routes->scope('/', function (RouteBuilder $routes) {
    $routes->setRouteClass(DashedRoute::class);
    
    // Home
    $routes->connect('/', ['controller' => 'Articles', 'action' => 'index'], ['_name' => 'home']);
    
    // REST API
    $routes->scope('/api', ['_namePrefix' => 'api:'], function (RouteBuilder $routes) {
        $routes->setExtensions(['json']);
        $routes->applyMiddleware('csrf'); // Apply CSRF to API
        $routes->resources('Articles', function (RouteBuilder $routes) {
            $routes->resources('Comments');
        });
    });
    
    // Public resources
    $routes->resources('Articles');
    
    // Admin prefix
    $routes->prefix('Admin', ['_namePrefix' => 'admin:'], function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);
        $routes->resources('Articles');
        $routes->resources('Comments');
    });
    
    // Redirects
    $routes->redirect('/old-articles/*', ['controller' => 'Articles'], ['status' => 301]);
    
    // Fallbacks
    $routes->fallbacks(DashedRoute::class);
});
```

---

## Testing Your Routes

Use CakePHP's routing shell to test:
```bash
bin/cake routes
bin/cake routes check /articles
bin/cake routes generate controller:Articles action:view id:5
```

---

## Summary

After completing this tutorial, you should understand:
- Basic and advanced routing concepts
- Route configuration and options
- RESTful routing
- Prefix and plugin routing
- URL generation and reverse routing
- Custom route classes
- Middleware in routing
- Route optimization and best practices

Good luck!

![Build Status](https://github.com/cakephp/app/actions/workflows/ci.yml/badge.svg?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%207-brightgreen.svg?style=flat-square)](https://github.com/phpstan/phpstan)

A skeleton for creating applications with [CakePHP](https://cakephp.org) 5.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app [app_name]`.

If Composer is installed globally, run

```bash
composer create-project --prefer-dist cakephp/app
```

In case you want to use a custom app dir name (e.g. `/myapp/`):

```bash
composer create-project --prefer-dist cakephp/app myapp
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.

## Update

Since this skeleton is a starting point for your application and various files
would have been modified as per your needs, there isn't a way to provide
automated upgrades, so you have to do any updates manually.

## Configuration

Read and edit the environment specific `config/app_local.php` and set up the
`'Datasources'` and any other configuration relevant for your application.
Other environment agnostic settings can be changed in `config/app.php`.

## Layout

The app skeleton uses [Milligram](https://milligram.io/) (v1.3) minimalist CSS
framework by default. You can, however, replace it with any other library or
custom styles.
