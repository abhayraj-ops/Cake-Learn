---
layout: default
title: Controller Components
description: Learn about CakePHP Controller Components - packages of logic shared between controllers
---

# Controller Components

> **Source:** [CakePHP Official Documentation](https://book.cakephp.org/5.x/controllers/components.html)

<nav style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 6px; padding: 15px 20px; margin: 20px 0;">
  <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
    <a href="04-cms-tutorial.html" style="color: var(--link-color);">← Previous: CMS Tutorial</a>
    <span style="color: var(--text-secondary);">⚙️ Page 5 of 5</span>
    <a href="index.html" style="color: var(--link-color);">Home →</a>
  </div>
</nav>

## Table of Contents

- [Introduction](#introduction)
- [Configuring Components](#configuring-components)
- [Using Components](#using-components)
- [Creating a Component](#creating-a-component)
- [Component Callbacks](#component-callbacks)
- [Flash Component](#flash-component)
- [Check HTTP Cache Component](#check-http-cache-component)
- [Form Protection Component](#form-protection-component)

---

## Introduction

Components are packages of logic that are shared between controllers. CakePHP comes with a fantastic set of core components you can use to aid in various common tasks. You can also create your own components. If you find yourself wanting to copy and paste things between controllers, you should consider creating your own component to contain the functionality. Creating components keeps controller code clean and allows you to reuse code between different controllers.

> **Note:** Since both Models and Components are added to Controllers as properties they share the same 'namespace'. Be sure to not give a component and a model the same name.

---

## Configuring Components

Many of the core components require configuration. Configuration for these components, and for components in general, is usually done via `loadComponent()` in your Controller's `initialize()` method or via the `$components` array:

```php
<?php
namespace App\Controller;

use App\Controller\AppController;

class PostsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('FormProtection', [
            'unlockedActions' => ['index'],
        ]);
        $this->loadComponent('Flash');
    }
}
?>
```

You can configure components at runtime using the `setConfig()` method. Often, this is done in your controller's `beforeFilter()` method:

```php
<?php
public function beforeFilter(EventInterface $event): void
{
    $this->FormProtection->setConfig('unlockedActions', ['index']);
}
?>
```

Like helpers, components implement `getConfig()` and `setConfig()` methods to read and write configuration data:

```php
<?php
// Read config data.
$this->FormProtection->getConfig('unlockedActions');

// Set config
$this->Flash->setConfig('key', 'myFlash');
?>
```

### Aliasing Components

One common setting to use is the `className` option, which allows you to alias components. This feature is useful when you want to replace `$this->Flash` or another common Component reference with a custom implementation:

```php
<?php
// Alias MyFlashComponent to $this->Flash
$this->loadComponent('Flash', [
    'className' => 'MyFlash',
]);
?>
```

> **Note:** Aliasing a component replaces that instance anywhere that component is used, including inside other Components.

---

## Using Components

Once you've included some components in your controller, using them is pretty simple. Each component you use is exposed as a property on your controller:

```php
<?php
// If you loaded the FlashComponent, you can use it like this:
$this->Flash->success('Your message here');
?>
```

### Loading Components on the Fly

You might not need all of your components available on every controller action. In situations like this you can load a component at runtime using the `loadComponent()` method:

```php
<?php
$this->loadComponent('Flash');
?>
```

> **Note:** Keep in mind that components loaded on the fly will not have missed callbacks called. If you rely on the beforeFilter or startup callbacks being called, you may need to call them manually depending on when you load your component.

### Using Other Components in your Component

Sometimes one of your components may need to use another component. You can load other components by adding them to the `$components` property:

```php
<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class MathComponent extends Component
{
    protected $components = ['Flash'];
}
?>
```

> **Note:** In contrast to a component included in a controller no callbacks will be triggered on a component's component.

### Accessing a Component's Controller

From within a Component you can access the current controller through the registry:

```php
<?php
$controller = $this->getController();
?>
```

---

## Creating a Component

Suppose our application needs to perform a complex mathematical operation in many different parts of the application. We could create a component to house this shared logic for use in many different controllers.

The first step is to create a new component file and class. Create the file in `src/Controller/Component/MathComponent.php`:

```php
<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class MathComponent extends Component
{
    public function calculate($operator, $operand1, $operand2)
    {
        switch ($operator) {
            case 'add':
                return $operand1 + $operand2;
            case 'subtract':
                return $operand1 - $operand2;
            case 'multiply':
                return $operand1 * $operand2;
            case 'divide':
                return $operand1 / $operand2;
        }
    }
}
?>
```

> **Note:** All components must extend `Cake\Controller\Component`. Failing to do this will trigger an exception.

### Dependency Injection

Components can use Dependency Injection to receive services as constructor parameters (added in version 5.1.0):

```php
<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use App\Service\MathService;

class MathComponent extends Component
{
    protected MathService $mathService;

    public function __construct(ComponentCollection $collection, array $config = [], MathService $mathService)
    {
        parent::__construct($collection, $config);
        $this->mathService = $mathService;
    }
}
?>
```

Once our component is finished, we can use it in the application's controllers by loading it during the controller's `initialize()` method:

```php
<?php
public function initialize(): void
{
    parent::initialize();
    $this->loadComponent('Math');
}
?>
```

---

## Component Callbacks

Components also offer a few request life-cycle callbacks that allow them to augment the request cycle:

- `beforeFilter(EventInterface $event): void` - Called before the controller's beforeFilter method
- `startup(EventInterface $event): void` - Called after the controller's startup method
- `beforeRender(EventInterface $event): void` - Called before the controller renders a view
- `afterFilter(EventInterface $event): void` - Called after the controller renders a view
- `beforeRedirect(EventInterface $event, $url, Response $response): void` - Called when a redirect is about to occur

### Using Redirects in Component Events

To redirect from within a component callback method you can use the following:

```php
<?php
// Setting redirect as event result
$event->setResult([
    'url' => '/some/path',
    'status' => 302
]);
?>
```

By setting a redirect as event result you let CakePHP know that you don't want any other component callbacks to run, and that the controller should not handle the action any further.

As of 4.1.0 you can raise a `RedirectException` to signal a redirect:

```php
<?php
use Cake\Http\Exception\RedirectException;

// Raising an exception will halt all other event listeners
throw new RedirectException('/some/path');
?>
```

Raising an exception will halt all other event listeners and create a new response that doesn't retain or inherit any of the current response's headers.

---

## Flash Component

The FlashComponent provides a way to set one-time notification messages to be displayed after processing a form or acknowledging data. CakePHP refers to these messages as "flash messages".

### Setting Flash Messages

FlashComponent provides two ways to set flash messages: its `__call()` magic method and its `set()` method:

```php
<?php
// Uses templates/element/flash/success.php
$this->Flash->success('This was successful');

// Uses templates/element/flash/great_success.php
$this->Flash->greatSuccess('This was greatly successful');
?>
```

Alternatively, to set a plain-text message without rendering an element, you can use the `set()` method:

```php
<?php
$this->Flash->set('This is a message');
?>
```

Flash messages are appended to an array internally. If you want to overwrite existing messages when setting a flash message, set the `clear` option to true:

```php
<?php
$this->Flash->success('New message', ['clear' => true]);
?>
```

### Options for Flash Messages

FlashComponent's `__call()` and `set()` methods optionally take a second parameter, an array of options:

```php
<?php
$this->Flash->success('The user has been saved', [
    'key' => 'positive',
    'clear' => true,
    'params' => [
        'name' => $user->name,
        'email' => $user->email,
    ],
]);
?>
```

### HTML in Flash Messages

By default, CakePHP escapes the content in flash messages to prevent cross site scripting. If you want to include HTML in your flash messages, you need to pass the `escape` option:

```php
<?php
// In your controller
$this->Flash->success('<b>Success!</b> Message', ['escape' => false]);

// In your flash element template, make sure to handle escaping
// templates/element/flash/success.php
echo '<div class="message">' . $message . '</div>';
?>
```

> **Warning:** Make sure that you escape the input manually if you use user data in your flash messages.

---

## Check HTTP Cache Component

The HTTP cache validation model is one of the processes used for cache gateways, also known as reverse proxies, to determine if they can serve a stored copy of a response to the client. Under this model, you mostly save bandwidth, but when used correctly you can also save some CPU processing, reducing response times.

### Enabling CheckHttpCacheComponent

```php
<?php
// in a Controller
public function initialize(): void
{
    parent::initialize();

    $this->addComponent('CheckHttpCache');
}
?>
```

Enabling the CheckHttpCacheComponent in your controller automatically activates a `beforeRender` check. This check compares caching headers set in the response object to the caching headers sent in the request to determine whether the response was not modified since the last time the client asked for it.

### How It Works

The following request headers are used:
- `If-None-Match` - Compares with response `ETag`
- `If-Modified-Since` - Compares with response `Last-Modified`

If response headers match the request header criteria, then view rendering is skipped. This saves your application generating a view, saving bandwidth and time. When response headers match, an empty response is returned with a `304 Not Modified` status code.

---

## Form Protection Component

The FormProtection Component provides protection against form data tampering.

> **Note:** When using the FormProtection Component you must use the FormHelper to create your forms. In addition, you must not override any of the fields' "name" attributes.

### Form Tampering Prevention

By default, the FormProtectionComponent prevents users from tampering with forms in specific ways. It will prevent:
- Adding new fields to the form
- Removing fields from the form
- Modifying hidden field values

Configuring the form protection component is generally done in the controller's `initialize()` or `beforeFilter()` callbacks:

```php
<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;

class WidgetsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('FormProtection');
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        if ($this->request->getParam('prefix') === 'Admin') {
            $this->FormProtection->setConfig('validate', false);
        }
    }
}
?>
```

### Configuration Options

Available options are:

- `validate` - Set to false to completely skip the validation of POST requests
- `unlockedFields` - List of form fields to exclude from POST validation
- `unlockedActions` - Actions to exclude from POST validation checks
- `validationFailureCallback` - Callback to call in case of validation failure

### Disabling Form Protection for Specific Actions

```php
<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;

class WidgetController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('FormProtection');
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        // Disable form protection for the edit action (e.g., for AJAX requests)
        $this->FormProtection->setConfig('unlockedActions', ['edit']);
    }
}
?>
```

### Handling Validation Failure

If form protection validation fails it will result in a 400 error by default. You can configure this behavior by setting the `validationFailureCallback` configuration option:

```php
<?php
public function beforeFilter(EventInterface $event): void
{
    parent::beforeFilter($event);

    $this->FormProtection->setConfig('validationFailureCallback', function ($controller) {
        $controller->response->statusCode(403);
        $controller->response->body('Invalid form submission');
        return $controller->response;
    });
}
?>
```

---

<nav style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 6px; padding: 15px 20px; margin: 30px 0;">
  <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
    <a href="04-cms-tutorial.html" style="color: var(--link-color);">← Previous: CMS Tutorial</a>
    <span style="color: var(--text-secondary);">⚙️ Page 5 of 5</span>
    <a href="index.html" style="color: var(--link-color);">Home →</a>
  </div>
</nav>

---

**Released under the MIT License.**

**Copyright © Cake Software Foundation, Inc. All rights reserved.**
