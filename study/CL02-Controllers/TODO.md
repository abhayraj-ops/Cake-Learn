# CL02-Controllers - CakePHP Project Blueprint

---

## Topic 1: Controller Basics

- [ ] **Controller Basics**
  - Understand MVC pattern - Controllers sit between Model and View
  - Follow "Keep Controllers Thin" principle - move business logic to models/services
  - Follow naming conventions - controller named after primary model (e.g., `ArticlesController` for `Article` model)

---

## Topic 2: The App Controller

- [ ] **The App Controller**
  - Create `src/Controller/AppController.php` extending `Cake\Controller\Controller`
  - Implement `initialize()` method - load global components available to all controllers
  - Purpose: share common methods acssross all controllers

---

## Topic 3: Request Flow

- [ ] **Request Flow**
  - Routing maps URLs to controller/action
  - Request data available via `$this->request`
  - Flow: Routes → Controller → Action → Response

---

## Topic 4: Controller Actions

- [ ] **Controller Actions**
  - Create `src/Controller/ArticlesController.php` extending `AppController`
  - Each public method is an action by default
  - Actions to create:
    - `index()` - list articles with pagination
    - `view($id)` - show single article
    - `add()` - create new article
    - `edit($id)` - update existing article
    - `delete($id)` - delete article
    - `search($query)` - search articles
  - Convention: action name maps to view file (e.g., `view()` → `templates/Articles/view.php`)
  - Return Response object explicitly for JSON, file downloads, custom status codes

---

## Topic 5: Interacting with Views

- [ ] **Interacting with Views**
  - `$this->set()` - Pass data to views
    - Single variable: `$this->set('color', 'pink')`
    - Associative array: `$this->set(['color' => 'pink', 'type' => 'sugar'])`
  - `$this->viewBuilder()` - Customize view before rendering
    - `addHelper()` - load custom helpers
    - `setTheme()` - set view theme
    - `setClassName()` - use custom view class
    - `setConfigMergeStrategy()` - MERGE_DEEP (default) vs MERGE_SHALLOW

---

## Topic 6: Rendering a View

- [ ] **Rendering a View**
  - `$this->render()` - Manually render a view
    - `$this->render()` - auto-renders based on action name
    - `$this->render('custom_file')` - render specific view
    - `$this->render('/element/ajaxreturn')` - render elements directly (useful for AJAX)
    - `$this->render('view', 'layout')` - specify layout second parameter
  - `$this->disableAutoRender()` - Skip automatic view rendering
    - Use when action fully handles the response

---

## Topic 7: Content Type Negotiation

- [ ] **Content Type Negotiation**
  - `$this->addViewClasses()` - Support multiple content types
    - Add JsonView, XmlView, CsvView classes
    - CakePHP auto-negotiates based on Accept header or URL extension
  - In actions, check content type:
    - `$this->request->is('json')`
    - `$this->request->is('ajax')`
  - Special View Classes:
    - NegotiationRequiredView - return 406 if no match
    - AjaxView - for AJAX requests without layout
    - TYPE_MATCH_ALL - custom fallback logic

---

## Topic 8: Redirecting

- [ ] **Redirecting**
  - `$this->redirect()` - Redirect to other pages
    - Array: `$this->redirect(['controller' => 'Orders', 'action' => 'confirm'])`
    - Relative: `$this->redirect('/orders/confirm')`
    - Absolute: `$this->redirect('https://example.com')`
    - Referer: `$this->redirect($this->referer())`
    - Status codes: `$this->redirect('/url', 301)` // 301 permanent, 303 see other
  - Redirect in Callbacks:
    - `$event->setResult($this->redirect('/'))`
    - `throw new RedirectException('/')` // CakePHP 4.1+

---

## Topic 9: Loading Tables/Models

- [ ] **Loading Tables/Models**
  - `$this->fetchTable()` - Load ORM tables not tied to controller
    - `$this->fetchTable('Articles')->find('all')->all()`
  - `$this->fetchModel()` - Load non-ORM models
    - `$this->fetchModel('Articles', 'Elastic')` // ElasticSearch
    - `$this->fetchModel('GitHub', 'Webservice')`

---

## Topic 10: Pagination

- [ ] **Pagination**
  - `$paginate` property - Configure pagination globally in controller
    ```php
    protected $paginate = [
        'Articles' => [
            'conditions' => ['published' => 1],
            'limit' => 10,
        ]
    ];
    ```
  - `$this->paginate()` - Paginate model results
    - `$articles = $this->paginate($this->Articles);`

---

## Topic 11: Loading Components

- [ ] **Loading Components**
  - In `initialize()` method:
    ```php
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('FormProtection');
        $this->loadComponent('Comments', ['priority' => 5]);
    }
    ```
  - Common built-in components: Flash, FormProtection, Authentication, Authorization

---

## Topic 12: Request Life-cycle Callbacks

- [ ] **Request Life-cycle Callbacks**
  - `beforeFilter($event)` - Runs before any action logic
    - Authentication checks
    - Setup operations
    - Always call `parent::beforeFilter($event)`
  - `beforeRender($event)` - Runs before view rendering
    - Set common view variables
    - Modify view builder
  - `afterFilter($event)` - Runs after all controller logic and rendering
    - Cleanup operations

---

## Topic 13: Controller Middleware

- [ ] **Controller Middleware**
  - `$this->middleware()` - Define controller-specific middleware
    - Defined in `initialize()` method
    - Runs before `beforeFilter()` and actions
  - Example:
    ```php
    public function initialize(): void
    {
        parent::initialize();
        $this->middleware(function ($request, $handler) {
            // Middleware logic
            return $handler->handle($request);
        });
    }
    ```

---

## Topic 14: Request Object ($this->request)

- [ ] **Request Object ($this->request)**
  - Request Parameters
    - `$this->request->getParam('controller')` - get routing parameter
    - `$this->request->getParam('action')` - get action name
    - `$this->request->getParam('pass')` - get passed arguments
    - `$this->request->getAttribute('params')` - get all params as array
  - Query String Parameters
    - `$this->request->getQuery('page')` - get query param
    - `$this->request->getQuery('page', 1)` - with default value
    - `$this->request->getQueryParams()` - get all query params
    - Use casting: `toInt()`, `toBool()`, `toString()`, `toDate()`
  - Request Body Data (POST)
    - `$this->request->getData('title')` - get POST data
    - `$this->request->getData('address.street_name')` - nested data
    - `$this->request->getData('missing', 'default')` - with default
  - File Uploads
    - `$this->request->getData('attachment')` - get uploaded file
    - `$attachment->getClientFilename()` - file name
    - `$attachment->getClientMediaType()` - MIME type
    - `$attachment->getSize()` - file size
    - `$attachment->moveTo($targetPath)` - move to permanent location
  - REST Methods
    - `$this->request->is('get')` - check HTTP method
    - `$this->request->is('post')`
    - `$this->request->is('put')`
    - `$this->request->is('patch')`
    - `$this->request->is('delete')`
    - `$this->request->getMethod()` - get HTTP method string
    - `$this->request->allowMethod(['post', 'delete'])` - restrict methods
  - Reading JSON/XML
    - `$this->request->input('json_decode')` - parse JSON body
    - `$this->request->input('Cake\Utility\Xml::build', ['return' => 'domdocument'])` - parse XML
  - Request Conditions (is)
    - `$this->request->is('ajax')` - check AJAX request
    - `$this->request->is('ssl')` - check SSL
    - `$this->request->is('json')` - check JSON request
    - `$this->request->is('xml')` - check XML request
  - Custom Detectors
    - `$this->request->addDetector('iphone', ['env' => 'HTTP_USER_AGENT', 'pattern' => '/iPhone/i'])`
    - `$this->request->addDetector('awesome', function ($request) { return $request->getParam('awesome'); })`
  - HTTP Headers
    - `$this->request->getHeaderLine('User-Agent')` - get header value
    - `$this->request->getHeader('Accept')` - get all header values
    - `$this->request->hasHeader('Accept')` - check header exists
  - Path & Environment
    - `$this->request->getRequestTarget()` - full URL path
    - `$this->request->getAttribute('base')` - base path
    - `$this->request->getAttribute('webroot')` - webroot path
    - `$this->request->getEnv('HTTP_HOST')` - environment variable
    - `$this->request->getServerParams()` - all server params
  - Client Information
    - `$this->request->clientIp()` - client IP address
    - `$this->request->referer()` - referring URL
    - `$this->request->domain()` - domain name
    - `$this->request->host()` - host name
    - `$this->request->subdomains()` - subdomains array
  - Accept Headers
    - `$this->request->accepts()` - all accepted content types
    - `$this->request->accepts('application/json')` - check specific type
    - `$this->request->acceptLanguage()` - accepted languages
  - Cookies
    - `$this->request->getCookie('remember_me')` - get cookie value
    - `$this->request->getCookie('remember_me', 0)` - with default
    - `$this->request->getCookieParams()` - all cookies
  - Session
    - `$this->request->getSession()` - get session object
    - `$session->read('key')` - read session data
  - Trusting Proxies (for load balancers)
    - `$this->request->trustProxy = true`
    - `$this->request->setTrustedProxies(['127.1.1.1'])`

---

## Topic 15: Response Object ($this->response)

- [ ] **Response Object ($this->response)**
  - Setting Content Type
    - `$this->response->withType('application/json')` - set content type
    - `$this->response->setTypeMap('vcf', ['text/v-card'])` - add custom type
  - Sending Files
    - `$this->response->withFile($filePath)` - send file
    - `$this->response->withFile($path, ['download' => true, 'name' => 'file.pdf'])` - force download
  - Sending String as File (generated content)
    - `$this->response->withStringBody($content)` - set body string
    - `$this->response->withType('ics')` - set content type
    - `$this->response->withDownload('filename.ics')` - set download name
  - Setting Headers
    - `$this->response->withHeader('X-Extra', 'My header')` - set header
    - `$this->response->withAddedHeader('Set-Cookie', 'value')` - append header
    - `$this->response->withLocation('https://example.com')` - redirect location
  - Setting Body
    - `$this->response->withStringBody('My Body')` - set string body
    - `$this->response->withBody($stream)` - set PSR-7 stream body
  - Character Set
    - `$this->response->withCharset('UTF-8')` - set charset
  - Browser Caching
    - `$this->response->withDisabledCache()` - disable browser caching
    - `$this->response->withCache('-1 minute', '+5 days')` - enable caching
  - HTTP Cache (Fine-tuning)
    - Cache-Control:
      - `$this->response->withSharable(true, 3600)` - public cache, max-age
      - `$this->response->withSharable(false, 3600)` - private cache
    - Expires Header:
      - `$this->response->withExpires('+5 days')` - set expiration
    - ETag Header:
      - `$this->response->withEtag($checksum)` - set etag
      - `$this->response->isNotModified($this->request)` - check if not modified
    - Last-Modified:
      - `$this->response->withModified($datetime)` - set last modified
    - Vary Header:
      - `$this->response->withVary('User-Agent')` - vary by header
      - `$this->response->withVary(['Accept-Encoding', 'User-Agent'])`
  - Not-Modified Responses
    - `if ($this->response->isNotModified($this->request)) { return $this->response; }`
  - Cookies
    - Using Cookie object:
      ```php
      use Cake\Http\Cookie\Cookie;
      use DateTime;
      $cookie = new Cookie('name', 'value', new DateTime('+1 year'), '/');
      $this->response->withCookie($cookie);
      ```
    - Fluent interface:
      ```php
      $cookie = (new Cookie('remember_me'))
          ->withValue('1')
          ->withExpiry(new DateTime('+1 year'))
          ->withPath('/')
          ->withDomain('example.com')
          ->withSecure(false)
          ->withHttpOnly(true);
      ```
    - Expire cookie:
      - `$this->response->withExpiredCookie(new Cookie('remember_me'))`
  - CORS (Cross-Origin)
    ```php
    $this->response = $this->response->cors($this->request)
        ->allowOrigin(['https://example.com'])
        ->allowMethods(['GET', 'POST', 'PUT', 'DELETE'])
        ->allowHeaders(['X-CSRF-Token'])
        ->allowCredentials()
        ->exposeHeaders(['Link'])
        ->maxAge(3600)
        ->build();
    ```
  - Important: Immutable Response
    - Always reassign: `$this->response = $this->response->withHeader('X-Header', 'value')`
    - Don't do: `$this->response->withHeader(...)` // WRONG - result not stored

---

## Views/Templates to Create

- [ ] **Views/Templates to Create**
  - templates/Articles/
    - `index.php` (list with pagination)
    - `view.php` (single article)
    - `add.php` (create form)
    - `edit.php` (edit form)
    - `search.php` (search results)
  - templates/Categories/
    - `index.php`
    - `view.php`
    - `add.php`
    - `edit.php`
  - templates/Tags/
    - `index.php`
    - `view.php`
    - `add.php`
    - `edit.php`

---

## Routes to Configure

- [ ] **Routes to Configure**
  - config/routes.php
  - Articles:
    - GET `/articles` → `ArticlesController::index()`
    - GET `/articles/view/:id` → `ArticlesController::view()`
    - GET `/articles/add` → `ArticlesController::add()`
    - POST `/articles` → `ArticlesController::add()`
    - GET `/articles/edit/:id` → `ArticlesController::edit()`
    - PUT `/articles/:id` → `ArticlesController::edit()`
    - GET `/articles/delete/:id` → `ArticlesController::delete()`
    - DELETE `/articles/:id` → `ArticlesController::delete()`
    - GET `/articles/search` → `ArticlesController::search()`
  - Categories:
    - GET `/categories` → `CategoriesController::index()`
    - GET `/categories/view/:id` → `CategoriesController::view()`
    - GET `/categories/add` → `CategoriesController::add()`
    - POST `/categories` → `CategoriesController::add()`
    - GET `/categories/edit/:id` → `CategoriesController::edit()`
    - PUT `/categories/:id` → `CategoriesController::edit()`
    - GET `/categories/delete/:id` → `CategoriesController::delete()`
    - DELETE `/categories/:id` → `CategoriesController::delete()`
  - Tags:
    - GET `/tags` → `TagsController::index()`
    - GET `/tags/view/:slug` → `TagsController::view()`
    - GET `/tags/add` → `TagsController::add()`
    - POST `/tags` → `TagsController::add()`
    - GET `/tags/edit/:id` → `TagsController::edit()`
    - PUT `/tags/:id` → `TagsController::edit()`
    - GET `/tags/delete/:id` → `TagsController::delete()`
    - DELETE `/tags/:id` → `TagsController::delete()`

---

## Advanced/Bonus Features

- [ ] **Advanced/Bonus Features**
  - Implement JSON API alongside HTML views
  - Add file upload/download functionality
  - Create custom middleware for auth checks
  - Implement custom view classes
  - Add soft delete support
  - Implement rate limiting
  - Create CORS middleware
  - Implement cookie-based features (remember me)
  - Use HTTP cache headers for performance
