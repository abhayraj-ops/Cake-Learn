
## CakePHP Views — Topic Index


**Topic 1: View Basics**
- What views are — V in MVC
- `AppView` — global view base class
- Template files — location, naming convention
- Alternative PHP syntax — `<?=`, `foreach:`, `endforeach`
- `h()` function — escaping user data
- `set()` in view — passing vars to layout

**Topic 2: View Templates**
- Template file location — `templates/Controller/action.php`
- View parts — templates, elements, layouts, helpers, cells
- Extending views — `$this->extend()`
- View blocks — `start()`, `end()`, `fetch()`, `assign()`, `append()`, `prepend()`, `reset()`
- Using blocks for scripts and CSS — `HtmlHelper` + `block => true`

**Topic 3: Layouts**
- What layouts are — wrapping views
- Default layout — `templates/layout/default.php`
- `$this->fetch('content')` — where view renders inside layout
- Setting layout from controller — `viewBuilder()->setLayout()`
- Multiple layouts — admin, ajax, image
- Plugin layouts — `Contacts.contact`

**Topic 4: Elements**
- What elements are — reusable partial views
- Location — `templates/element/`
- Rendering — `$this->element('name')`
- Passing variables — second argument array
- Element caching — `cache` option
- Plugin elements — `Contacts.helpbox`

**Topic 5: View Cells**
- What cells are — mini-controllers for UI components
- When to use — cart, notification count, nav menu
- Creating a cell — `src/View/Cell/`, `templates/cell/`
- `display()` — default method
- Passing arguments to cells
- Caching cell output
- Cell options — `$_validCellOptions`
- Using helpers inside cells
- Paginating data inside a cell

**Topic 6: Themes**
- What themes are — plugins that provide templates
- Loading a theme plugin
- Setting theme in controller
- Template file location inside theme plugin
- Fallback — if template not in theme, uses default
- Theme assets — webroot directory

**Topic 7: JSON and XML Views**
- `JsonView` and `XmlView` — built-in view classes
- `viewClasses()` — register supported formats
- `serialize` option — skip template files
- Template files for custom formatting
- `jsonOptions` — bitmask for `json_encode`
- `XmlView` — `rootNode`, `xmlOptions`
- JSONP responses
- Choosing view class directly — `setClassName()`

**Topic 8: Custom View Classes**
- File location — `src/View/`
- Naming — suffix `View`
- Extending `Cake\View\View`
- `contentType()` method
- Overriding `render()` for full control

**Topic 9: View Events**
- `View.beforeRender`
- `View.beforeRenderFile`
- `View.afterRenderFile`
- `View.afterRender`
- `View.beforeLayout`
- `View.afterLayout`

---
