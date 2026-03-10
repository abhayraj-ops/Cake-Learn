---
layout: default
title: Application Architecture
description: How CakePHP applications are structured and bootstrapped.
---

# Application Architecture

> **Source:** [CakePHP Official Documentation](https://book.cakephp.org/5.x/development/application.html)

<nav style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 6px; padding: 15px 20px; margin: 20px 0;">
  <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
    <a href="02-installation-guide.html" style="color: var(--link-color);">← Previous: Installation</a>
    <span style="color: var(--text-secondary);">📚 Page 3 of 3</span>
    <a href="index.html" style="color: var(--link-color);">Home →</a>
  </div>
</nav>

## The Application Class

The `Application` class is the heart of your application. It is responsible for bootstrapping and configuring your application, as well as defining the middleware, console commands, and routes.

Your application's `Application` class can be found at `src/Application.php`. It defines the following hook methods:

- `bootstrap()`: Used to initialize plugins, and attach global event listeners.
- `routes()`: Used to define your application's routes.
- `middleware()`: Used to define your application's middleware stack.
- `console()`: Used to define your application's console commands.

### Bootstrapping your Application

CakePHP provides two places to add bootstrapping logic to your application:

1. **`config/bootstrap.php`**: This file is included before every request and CLI command. It is ideal for low-level concerns like defining constants, and configuring logging.
2. **`Application::bootstrap()`**: This hook method is called after `config/bootstrap.php` is included. It is ideal for loading/initializing plugins, and attaching global event listeners.

```php
// in src/Application.php
namespace App;

use Cake\Http\BaseApplication;

class Application extends BaseApplication
{
    public function bootstrap(): void
    {
        // Call the parent to `require_once` config/bootstrap.php
        parent::bootstrap();

        // Load MyPlugin
        $this->addPlugin('MyPlugin');
    }
}
```

---

<nav style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 6px; padding: 15px 20px; margin: 30px 0;">
  <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
    <a href="02-installation-guide.html" style="color: var(--link-color);">← Previous: Installation</a>
    <span style="color: var(--text-secondary);">📚 Page 3 of 3</span>
    <a href="index.html" style="color: var(--link-color);">Home →</a>
  </div>
</nav>

---

**Released under the MIT License.**

**Copyright © Cake Software Foundation, Inc. All rights reserved.**