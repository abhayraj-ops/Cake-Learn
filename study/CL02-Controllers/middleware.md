## CakePHP Middleware — Topic Index

---

**Topic 1: What is Middleware**
- Onion layer concept — request wraps through each layer
- PSR-7 request/response, PSR-15 standard

**Topic 2: Built-in CakePHP Middleware**
- ErrorHandlerMiddleware
- AssetMiddleware
- RoutingMiddleware
- CsrfProtectionMiddleware
- BodyParserMiddleware
- HttpsEnforcerMiddleware
- EncryptedCookieMiddleware
- SecurityHeadersMiddleware
- RateLimitMiddleware
- LocaleSelectorMiddleware

**Topic 3: Applying Middleware**
- Globally via `Application::middleware()`
- MiddlewareQueue operations — `add()`, `prepend()`, `insertAt()`, `insertBefore()`, `insertAfter()`
- Route scoped middleware
- Controller middleware
- Plugin middleware

**Topic 4: Creating Custom Middleware**
- File location — `src/Middleware/`
- Naming convention — suffix `Middleware`
- Implementing `MiddlewareInterface`
- `process(ServerRequestInterface, RequestHandlerInterface)` method
- `$handler->handle()` — delegate to next layer
- Returning own response — short circuit

**Topic 5: Practical Middleware**
- Tracking/logging middleware
- CORS middleware
- Auth check middleware
- Request modification middleware

