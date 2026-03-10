---
layout: default
title: CakePHP Conventions
description: Learn CakePHP naming conventions and folder structure for rapid development
---

# CakePHP Conventions

> **Source:** [CakePHP Official Documentation](https://book.cakephp.org/5.x/intro/conventions.html)

<nav style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 6px; padding: 15px 20px; margin: 20px 0;">
  <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
    <a href="02-installation-guide.html" style="color: var(--link-color);">← Previous: Installation</a>
    <span style="color: var(--text-secondary);">📋 Page 3 of 4</span>
    <a href="04-cms-tutorial.html" style="color: var(--link-color);">Next: CMS Tutorial →</a>
  </div>
</nav>

CakePHP embraces **convention over configuration**. By following conventions, you get free functionality without tracking config files, and create a uniform codebase that other developers can quickly understand.

> **Tip:** Following these conventions means CakePHP automatically wires up your application - controllers find their models, views find their templates, and URLs map to actions without any configuration.

## Table of Contents

- [Application Folder Structure](#application-folder-structure)
- [The src/ Directory](#the-src-directory)
- [Naming Conventions](#naming-conventions)
- [Controller Conventions](#controller-conventions)
- [Model Conventions](#model-conventions)
- [View Conventions](#view-conventions)
- [Database Conventions](#database-conventions)
- [Plugin Conventions](#plugin-conventions)
- [Complete Example](#complete-example)

---

## Application Folder Structure

After downloading the CakePHP application skeleton, you'll see these top-level folders:

```mermaid
graph TB
    subgraph Essential["📁 Essential Folders"]
        SRC["src/<br/>Application Code"]
        TPL["templates/<br/>View Templates"]
        CFG["config/<br/>Configuration"]
        WEB["webroot/<br/>Public Files"]
    end

    subgraph Dev["🔧 Development"]
        TEST["tests/<br/>Test Cases"]
        BIN["bin/<br/>Console CLI"]
    end

    subgraph Runtime["⚙️ Runtime"]
        TMP["tmp/<br/>Cache & Sessions"]
        LOG["logs/<br/>Log Files"]
        VENDOR["vendor/<br/>Dependencies"]
    end

    subgraph Ext["🔌 Extensions"]
        PLG["plugins/<br/>Plugin Packages"]
        RES["resources/<br/>Assets"]
        LOC["locales/<br/>Translations"]
    end

    style Essential fill:#1a365d,color:#fff
    style Dev fill:#1a4731,color:#fff
    style Runtime fill:#744210,color:#fff
    style Ext fill:#553c9a,color:#fff
    style SRC fill:#2c5282,color:#fff
    style TPL fill:#2c5282,color:#fff
    style CFG fill:#2c5282,color:#fff
    style WEB fill:#2c5282,color:#fff
```

### Essential Folders

| Folder | Purpose |
|--------|---------|
| `src/` | Your application code (controllers, models, views) |
| `templates/` | View templates and layouts |
| `config/` | Configuration files (routes, database, app settings) |
| `webroot/` | Public files (CSS, JS, images) - document root |

### Development & Testing

| Folder | Purpose |
|--------|---------|
| `tests/` | PHPUnit test cases |
| `bin/` | Console executable (`bin/cake`) |

### Runtime & Dependencies

| Folder | Purpose |
|--------|---------|
| `tmp/` | Cache, logs, sessions (must be writable) |
| `logs/` | Application log files (must be writable) |
| `vendor/` | Composer dependencies |

### Extensions & Localization

| Folder | Purpose |
|--------|---------|
| `plugins/` | Plugin packages |
| `resources/` | Locale files and other resources |
| `locales/` | Translation files |

> **Warning:** Make sure `tmp/` and `logs/` folders are writable! Poor performance or errors will occur otherwise.

---

## The src/ Directory

The `src/` folder is where you'll do most development:

```mermaid
graph LR
    subgraph SRC["src/ Directory"]
        CTRL["Controller/<br/>Request Handlers"]
        MODEL["Model/"]
        VIEW["View/"]
        CMD["Command/"]
        MID["Middleware/"]
    end

    subgraph MODEL["Model Subfolders"]
        TBL["Table/<br/>Database Access"]
        ENT["Entity/<br/>Data Objects"]
        BEH["Behavior/<br/>Reusable Logic"]
    end

    subgraph VIEW["View Subfolders"]
        VCLS["View Classes"]
        HLP["Helper/<br/>View Helpers"]
        CELL["Cell/"]
    end

    SRC --> MODEL
    SRC --> VIEW

    style SRC fill:#1a365d,color:#fff
    style MODEL fill:#1a4731,color:#fff
    style VIEW fill:#553c9a,color:#fff
    style CTRL fill:#2c5282,color:#fff
    style CMD fill:#2c5282,color:#fff
    style MID fill:#2c5282,color:#fff
    style TBL fill:#276749,color:#fff
    style ENT fill:#276749,color:#fff
    style BEH fill:#276749,color:#fff
    style VCLS fill:#6b46c1,color:#fff
    style HLP fill:#6b46c1,color:#fff
    style CELL fill:#6b46c1,color:#fff
```

| Subfolder | Purpose |
|-----------|---------|
| `Controller/` | Controllers handle requests |
| `Model/Table/` | Table classes (database access) |
| `Model/Entity/` | Entity classes (data objects) |
| `Model/Behavior/` | Reusable model behaviors |
| `View/` | View classes and helpers |
| `View/Helper/` | View helpers |
| `Command/` | Console commands |
| `Middleware/` | HTTP middleware |

> **Note:** The `Command/` folder isn't present by default - it's auto-generated when you create your first command using bake.

---

## Naming Conventions

### File and Class Name Conventions

All files follow PSR-4 autoloading - filenames must match class names exactly:

```mermaid
flowchart TB
    subgraph Naming["📝 Naming Pattern"]
        A["Class Name"] --> B["File Name"]
        B --> C["Location"]
    end

    subgraph Examples["Examples"]
        E1["ArticlesController<br/>→ ArticlesController.php<br/>→ src/Controller/"]
        E2["UsersTable<br/>→ UsersTable.php<br/>→ src/Model/Table/"]
        E3["User Entity<br/>→ User.php<br/>→ src/Model/Entity/"]
    end

    Naming --> Examples

    style Naming fill:#1a365d,color:#fff
    style Examples fill:#1a4731,color:#fff
    style A fill:#2c5282,color:#fff
    style B fill:#2c5282,color:#fff
    style C fill:#2c5282,color:#fff
    style E1 fill:#276749,color:#fff
    style E2 fill:#276749,color:#fff
    style E3 fill:#276749,color:#fff
```

| Type | Class Name | File Name | Location |
|------|------------|-----------|----------|
| Controller | `ArticlesController` | `ArticlesController.php` | `src/Controller/` |
| Table | `ArticlesTable` | `ArticlesTable.php` | `src/Model/Table/` |
| Entity | `Article` | `Article.php` | `src/Model/Entity/` |
| Behavior | `TimestampBehavior` | `TimestampBehavior.php` | `src/Model/Behavior/` |
| Helper | `FormHelper` | `FormHelper.php` | `src/View/Helper/` |
| Command | `UpdateCacheCommand` | `UpdateCacheCommand.php` | `src/Command/` |

---

## Controller Conventions

### Rules

- **Name:** Plural, CamelCased, ends with `Controller`
- **File:** Same as class name in `src/Controller/`
- **Methods:** camelBacked (first word lowercase)
- **URLs:** Dashed lowercase (`/users/view-me` for `viewMe()`)

```mermaid
flowchart LR
    subgraph Controller["🎮 Controller Naming"]
        NAME["Plural + CamelCase<br/>+ 'Controller'"]
        FILE["Same name + .php<br/>src/Controller/"]
        METHOD["camelBacked<br/>methods"]
        URL["dashed-lowercase<br/>URLs"]
    end

    NAME --> FILE --> METHOD --> URL

    style Controller fill:#1a365d,color:#fff
    style NAME fill:#2c5282,color:#fff
    style FILE fill:#2c5282,color:#fff
    style METHOD fill:#2c5282,color:#fff
    style URL fill:#2c5282,color:#fff
```

```php
// File: src/Controller/UsersController.php
namespace App\Controller;

class UsersController extends AppController
{
    // URL: /users/view-me
    public function viewMe()
    {
        // camelBacked method names
    }
}
```

### Wrong Example

```php
// Wrong: singular, lowercase, no suffix
class user extends AppController
{
    // Wrong: underscores instead of camelCase
    public function view_me()
    {
    }
}
```

> **Warning:** Only public methods are accessible through routing. Protected and private methods cannot be accessed via URLs.

> **Tip:** Acronyms: Treat them as words. CMS becomes `CmsController`, not `CMSController`

### URL Arrays

```php
$this->Html->link('title', [
    'prefix' => 'MyPrefix',      // CamelCased
    'plugin' => 'MyPlugin',      // CamelCased
    'controller' => 'Users',     // CamelCased
    'action' => 'viewProfile'    // camelBacked
]);
```

---

## Model Conventions

```mermaid
flowchart TB
    subgraph Model["📊 Model Layer"]
        DB["Database Table<br/>(plural, underscored)"]
        TBL["Table Class<br/>(plural, CamelCase + Table)"]
        ENT["Entity Class<br/>(singular, CamelCase)"]
    end

    DB -->|"users"| TBL
    TBL -->|"UsersTable"| ENT
    ENT -->|"User"| APP["Application"]

    style Model fill:#1a4731,color:#fff
    style DB fill:#276749,color:#fff
    style TBL fill:#276749,color:#fff
    style ENT fill:#276749,color:#fff
    style APP fill:#2f855a,color:#fff
```

### Table Classes

- **Name:** Plural, CamelCased, ends with `Table`
- **File:** `src/Model/Table/UsersTable.php`

```php
// File: src/Model/Table/UsersTable.php
namespace App\Model\Table;

class UsersTable extends Table
{
    // Plural, CamelCased, ends in "Table"
}
```

### Entity Classes

- **Name:** Singular, CamelCased, no suffix
- **File:** `src/Model/Entity/User.php`

```php
// File: src/Model/Entity/User.php
namespace App\Model\Entity;

class User extends Entity
{
    // Singular, CamelCased, no suffix
}
```

### Examples

| Database Table | Table Class | Entity Class |
|----------------|-------------|--------------|
| `users` | `UsersTable` | `User` |
| `menu_links` | `MenuLinksTable` | `MenuLink` |
| `user_favorite_pages` | `UserFavoritePagesTable` | `UserFavoritePage` |

---

## View Conventions

```mermaid
flowchart LR
    subgraph View["👁️ View Layer"]
        CTRL["Controller Action<br/>viewAll()"]
        TPL["Template File<br/>view_all.php"]
        LOC["Location<br/>templates/Articles/"]
    end

    CTRL -->|"underscored"| TPL
    TPL --> LOC

    style View fill:#553c9a,color:#fff
    style CTRL fill:#6b46c1,color:#fff
    style TPL fill:#6b46c1,color:#fff
    style LOC fill:#6b46c1,color:#fff
```

### Template Files

- **Location:** `templates/{Controller}/{underscored_action}.php`
- **Naming:** Underscored action name

```php
// Controller method: ArticlesController::viewAll()
templates/Articles/view_all.php

// Controller method: MenuLinksController::editItem()
templates/MenuLinks/edit_item.php
```

### View Classes

- **Name:** CamelCased, ends with `View`
- **File:** `src/View/ArticlesView.php`

```php
// File: src/View/ArticlesView.php
class ArticlesView extends View
{
}
```

### Helpers

- **Name:** CamelCased, ends with `Helper`
- **File:** `src/View/Helper/BestEverHelper.php`

---

## Database Conventions

```mermaid
flowchart TB
    subgraph DB["🗄️ Database Naming"]
        TABLE["Table Names<br/>plural, underscored"]
        COL["Column Names<br/>underscored"]
        FK["Foreign Keys<br/>{singular}_id"]
        JUNC["Junction Tables<br/>alphabetical plurals"]
    end

    subgraph Correct["✅ Correct"]
        C1["users"]
        C2["menu_links"]
        C3["user_id"]
        C4["articles_tags"]
    end

    subgraph Wrong["❌ Wrong"]
        W1["user"]
        W2["MenuLinks"]
        W3["users_id"]
        W4["tags_articles"]
    end

    TABLE --> C1
    TABLE --> W1
    COL --> C2
    COL --> W2
    FK --> C3
    FK --> W3
    JUNC --> C4
    JUNC --> W4

    style DB fill:#744210,color:#fff
    style TABLE fill:#975a16,color:#fff
    style COL fill:#975a16,color:#fff
    style FK fill:#975a16,color:#fff
    style JUNC fill:#975a16,color:#fff
    style Correct fill:#1a4731,color:#fff
    style Wrong fill:#742a2a,color:#fff
    style C1 fill:#276749,color:#fff
    style C2 fill:#276749,color:#fff
    style C3 fill:#276749,color:#fff
    style C4 fill:#276749,color:#fff
    style W1 fill:#9b2c2c,color:#fff
    style W2 fill:#9b2c2c,color:#fff
    style W3 fill:#9b2c2c,color:#fff
    style W4 fill:#9b2c2c,color:#fff
```

### Table Names

```sql
-- Plural, underscored
CREATE TABLE users;
CREATE TABLE menu_links;
CREATE TABLE user_favorite_pages;

-- Foreign keys: {singular_table}_id
ALTER TABLE articles ADD user_id INT;
ALTER TABLE photos ADD menu_link_id INT;

-- Junction tables: alphabetically sorted plurals
CREATE TABLE articles_tags;
```

### Rules

| Convention | Correct | Wrong |
|------------|---------|-------|
| Table names | `users`, `menu_links` | `user`, `MenuLinks` |
| Column names | `first_name`, `created_at` | `FirstName`, `createdAt` |
| Foreign keys | `user_id`, `menu_link_id` | `users_id`, `UserId` |
| Junction tables | `articles_tags` | `tags_articles` |

> **Warning:** The bake command requires junction tables to be alphabetically sorted! Use `articles_tags`, not `tags_articles`.

### Wrong Examples

```sql
-- Wrong: singular
CREATE TABLE user;

-- Wrong: not underscored
CREATE TABLE MenuLinks;

-- Wrong: plural both words
CREATE TABLE users_favorites_pages;

-- Wrong: not alphabetical
CREATE TABLE tags_articles;
```

### Primary Keys

- Default: `id` (auto-increment)
- UUID: Use `Cake\Utility\Text::uuid()`

> **Tip:** If your junction table has extra columns beyond the foreign keys, create a dedicated Table and Entity class for it.

---

## Plugin Conventions

```mermaid
flowchart TB
    subgraph Plugin["🔌 Plugin Naming"]
        FORMAT["vendor/package-name"]
        PREFIX["Must include<br/>cakephp- prefix"]
        LOWER["Use lowercase<br/>and dashes"]
    end

    subgraph Good["✅ Correct"]
        G1["your-name/cakephp-blog"]
        G2["awesome-dev/cakephp-payment"]
        G3["company/cakephp-api-client"]
    end

    subgraph Bad["❌ Wrong"]
        B1["cakephp/blog<br/>(reserved namespace)"]
        B2["YourName/CakePHP-Blog<br/>(wrong case)"]
        B3["your-name/blog<br/>(missing prefix)"]
    end

    FORMAT --> Good
    FORMAT --> Bad

    style Plugin fill:#553c9a,color:#fff
    style FORMAT fill:#6b46c1,color:#fff
    style PREFIX fill:#6b46c1,color:#fff
    style LOWER fill:#6b46c1,color:#fff
    style Good fill:#1a4731,color:#fff
    style Bad fill:#742a2a,color:#fff
    style G1 fill:#276749,color:#fff
    style G2 fill:#276749,color:#fff
    style G3 fill:#276749,color:#fff
    style B1 fill:#9b2c2c,color:#fff
    style B2 fill:#9b2c2c,color:#fff
    style B3 fill:#9b2c2c,color:#fff
```

### Naming

Plugin names should follow Packagist conventions:

```
your-name/cakephp-blog
awesome-dev/cakephp-payment
company/cakephp-api-client
```

### Rules

- Use lowercase with dashes
- Include `cakephp-` prefix
- Avoid reserved `cakephp/` namespace

```php
cakephp/blog          // Reserved namespace!
YourName/CakePHP-Blog // Use lowercase & dashes
your-name/blog        // Missing cakephp- prefix
```

---

## Complete Example

Here's how all the conventions work together for a complete Articles feature:

```mermaid
flowchart TB
    subgraph Request["🌐 HTTP Request"]
        URL["URL: /articles/view/5"]
    end

    subgraph MVC["🎯 MVC Flow"]
        CTRL["ArticlesController<br/>::view(5)"]
        TBL["ArticlesTable<br/>(Model)"]
        ENT["Article Entity<br/>(Data)"]
        TPL["templates/Articles/<br/>view.php"]
    end

    subgraph DB["💾 Database"]
        TABLE["articles table"]
    end

    subgraph Response["📤 Response"]
        HTML["HTML Page"]
    end

    URL --> CTRL
    CTRL --> TBL
    TBL --> TABLE
    TABLE --> ENT
    ENT --> TPL
    TPL --> HTML

    style Request fill:#1a365d,color:#fff
    style MVC fill:#1a4731,color:#fff
    style DB fill:#744210,color:#fff
    style Response fill:#553c9a,color:#fff
    style URL fill:#2c5282,color:#fff
    style CTRL fill:#276749,color:#fff
    style TBL fill:#276749,color:#fff
    style ENT fill:#276749,color:#fff
    style TPL fill:#276749,color:#fff
    style TABLE fill:#975a16,color:#fff
    style HTML fill:#6b46c1,color:#fff
```

### Database

```sql
CREATE TABLE articles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    title VARCHAR(255),
    body TEXT,
    created DATETIME,
    modified DATETIME
);

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50),
    email VARCHAR(255)
);
```

### File Structure

```
src/
├── Controller/
│   └── ArticlesController.php    → class ArticlesController
├── Model/
│   ├── Table/
│   │   └── ArticlesTable.php     → class ArticlesTable
│   └── Entity/
│       └── Article.php           → class Article
templates/
└── Articles/
    ├── index.php                 → ArticlesController::index()
    ├── view.php                  → ArticlesController::view()
    └── add.php                   → ArticlesController::add()
```

### How It Works

| URL | Controller | Table | Entity | Template |
|-----|------------|-------|--------|----------|
| `/articles/view/5` | `ArticlesController::view()` | `ArticlesTable` | `Article` | `templates/Articles/view.php` |

**No configuration required!** CakePHP wires everything automatically through conventions.

```mermaid
sequenceDiagram
    participant Browser
    participant Router
    participant Controller
    participant Model
    participant Database
    participant View

    Browser->>Router: GET /articles/view/5
    Router->>Controller: ArticlesController::view(5)
    Controller->>Model: ArticlesTable->get(5)
    Model->>Database: SELECT * FROM articles WHERE id = 5
    Database-->>Model: Article data
    Model-->>Controller: Article Entity
    Controller->>View: Render view.php with Article
    View-->>Browser: HTML Response

    Note over Browser,View: All wired automatically by conventions!
```

> **Warning:** If junction tables have additional data columns, create a dedicated Table and Entity class for them.

---

## Next Steps

Now that you understand CakePHP's structure and conventions:

1. Continue with the [Content Management Tutorial](04-cms-tutorial.html) for a hands-on walkthrough
2. Learn about [Routes Configuration](https://book.cakephp.org/5.x/development/routing.html) for URL handling

---

<nav style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 6px; padding: 15px 20px; margin: 30px 0;">
  <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
    <a href="02-installation-guide.html" style="color: var(--link-color);">← Previous: Installation</a>
    <span style="color: var(--text-secondary);">📋 Page 3 of 4</span>
    <a href="04-cms-tutorial.html" style="color: var(--link-color);">Next: CMS Tutorial →</a>
  </div>
</nav>

---

**Released under the MIT License.**

**Copyright © Cake Software Foundation, Inc. All rights reserved.**
