<!-- templates/Articles/index.php -->
<!-- Variables available: $articles (array), $total (int), $page (string) -->
<!-- Set via: $this->set(['articles' => ..., 'total' => ..., 'page' => ...]) -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Mono:wght@400;500&display=swap');

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #0d0d0d;
            --surface: #161616;
            --border: #2a2a2a;
            --accent: #c8f542;
            --text: #e8e8e8;
            --muted: #666;
            --danger: #ff4d4d;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Mono', monospace;
            min-height: 100vh;
            padding: 3rem 2rem;
        }

        /* ── Header ── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-bottom: 1px solid var(--border);
            padding-bottom: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 2.8rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--accent);
        }

        .header .meta {
            font-size: 0.75rem;
            color: var(--muted);
            text-align: right;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-end;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-block;
            padding: 0.6rem 1.4rem;
            font-family: 'DM Mono', monospace;
            font-size: 0.8rem;
            text-decoration: none;
            border: 1px solid var(--accent);
            color: var(--accent);
            background: transparent;
            cursor: pointer;
            transition: all 0.15s;
            letter-spacing: 0.05em;
        }

        .btn:hover {
            background: var(--accent);
            color: var(--bg);
        }

        .btn-danger {
            border-color: var(--danger);
            color: var(--danger);
        }

        .btn-danger:hover {
            background: var(--danger);
            color: #fff;
        }

        /* ── Search ── */
        .search-bar {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .search-bar input {
            flex: 1;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 0.6rem 1rem;
            font-family: 'DM Mono', monospace;
            font-size: 0.85rem;
            outline: none;
        }

        .search-bar input:focus {
            border-color: var(--accent);
        }

        /* ── Grid ── */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        /* ── Card ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 1.5rem;
            transition: border-color 0.15s;
        }

        .card:hover {
            border-color: var(--accent);
        }

        .card .id {
            font-size: 0.7rem;
            color: var(--muted);
            margin-bottom: 0.5rem;
        }

        .card h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text);
        }

        .card p {
            font-size: 0.82rem;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 1.2rem;
        }

        .card .actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        /* ── Empty state ── */
        .empty {
            text-align: center;
            padding: 4rem;
            color: var(--muted);
            font-size: 0.9rem;
            border: 1px dashed var(--border);
        }

        /* ── Flash messages ── */
        .flash-success {
            background: rgba(200, 245, 66, 0.08);
            border: 1px solid var(--accent);
            color: var(--accent);
            padding: 0.75rem 1rem;
            font-size: 0.82rem;
            margin-bottom: 1.5rem;
        }

        .flash-error {
            background: rgba(255, 77, 77, 0.08);
            border: 1px solid var(--danger);
            color: var(--danger);
            padding: 0.75rem 1rem;
            font-size: 0.82rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>

    <!-- Flash messages from controller -->
    <?= $this->Flash->render() ?>

    <!-- Header — uses $page and $total passed via set([...]) -->
    <div class="header">
        <h1>
            <?= h($page) ?>
        </h1>
        <div class="meta">
            <span>
                <?= $total ?> article
                <?= $total !== 1 ? 's' : '' ?>
            </span>
            <a href="/articles/add" class="btn">+ New Article</a>
        </div>
    </div>

    <!-- Search form — submits to search() action -->
    <form class="search-bar" action="/articles/search" method="post">
        <input type="hidden" name="_csrfToken" value="<?= $this->request->getAttribute('csrfToken') ?>">
        <input type="text" name="query" placeholder="Search by title..." />
        <button type="submit" class="btn">Search</button>
    </form>

    <!-- Articles grid — uses $articles passed via set([...]) -->
    <?php if (empty($articles)): ?>

        <div class="empty">No articles yet. Create your first one.</div>

    <?php else: ?>

        <div class="grid">
            <?php foreach ($articles as $article): ?>
                <div class="card">

                    <div class="id">#
                        <?= h($article['id']) ?>
                    </div>
                    <h2>
                        <?= h($article['title']) ?>
                    </h2>
                    <p>
                        <?= h($article['body']) ?>
                    </p>

                    <div class="actions">
                        <a href="/articles/view/<?= h($article['id']) ?>" class="btn">View</a>
                        <a href="/articles/edit/<?= h($article['id']) ?>" class="btn">Edit</a>

                        <!-- Delete uses POST form — never a plain link/GET -->
                        <form action="/articles/delete/<?= h($article['id']) ?>" method="post">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</body>

</html>