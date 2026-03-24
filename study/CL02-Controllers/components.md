## CakePHP Components — Topic Index

---

**Topic 1: Components Basics**
- What components are — shared controller logic
- Loading via `loadComponent()` in `initialize()`
- Accessing as `$this->ComponentName`
- Loading on the fly in actions
- Configuring via `setConfig()` / `getConfig()`
- Aliasing components via `className`
- Using components inside components via `$components` property
- Accessing controller from component via `getController()`

**Topic 2: Component Callbacks (Lifecycle)**
- `beforeFilter()` — runs before action
- `startup()` — runs after beforeFilter
- `beforeRender()` — runs before view renders
- `afterFilter()` — runs after response
- `beforeRedirect()` — runs before redirect
- Redirecting from callbacks — `$event->setResult()` vs `RedirectException`

**Topic 3: Creating Custom Components**
- File location — `src/Controller/Component/`
- Naming convention — suffix `Component`
- Extending `Cake\Controller\Component`
- Constructor and `initialize()` method
- Dependency injection in components
- `$_defaultConfig` property

**Topic 4: Flash Component**
- `__call()` magic method — `success()`, `error()`, `warning()`
- `set()` method — plain text messages
- Options — `key`, `element`, `params`, `clear`
- Session storage — messages stack per key
- HTML in flash messages — `escape` option
- Plugin flash elements

**Topic 5: FormProtection Component**
- What it protects — URL, fields, hidden values
- `validate` — disable all validation
- `unlockedFields` — exclude specific fields
- `unlockedActions` — exclude specific actions
- `validationFailureCallback` — custom error handling
- Must use FormHelper with this component

**Topic 6: CheckHttpCache Component**
- HTTP cache validation model
- `If-None-Match` vs `Etag`
- `If-Modified-Since` vs `Last-Modified`
- 304 Not Modified — skip view rendering
- Saves bandwidth and CPU

---
