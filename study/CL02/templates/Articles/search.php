<!-- ═══════════════════════════════════════════════════════════════
     templates/Articles/search.php
     Variables: $articles (filtered array), $query (string), $count (int)
════════════════════════════════════════════════════════════════ -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
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
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Mono', monospace;
            min-height: 100vh;
            padding: 3rem 2rem;
        }

        .back {
            font-size: 0.78rem;
            color: var(--muted);
            text-decoration: none;
            display: inline-block;
            margin-bottom: 2rem;
        }

        .back:hover {
            color: var(--accent);
        }

        .header {
            margin-bottom: 2rem;
        }

        .header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--accent);
        }

        .header .meta {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 0.5rem;
        }

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
        }

        .btn:hover {
            background: var(--accent);
            color: var(--bg);
        }

        .result {
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 0;
        }

        .result .id {
            font-size: 0.7rem;
            color: var(--muted);
            margin-bottom: 0.3rem;
        }

        .result h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.4rem;
        }

        .result p {
            font-size: 0.82rem;
            color: var(--muted);
        }

        .result a {
            color: var(--accent);
            font-size: 0.78rem;
            text-decoration: none;
            margin-top: 0.5rem;
            display: inline-block;
        }

        .empty {
            text-align: center;
            padding: 4rem;
            color: var(--muted);
            font-size: 0.9rem;
            border: 1px dashed var(--border);
        }
    </style>
</head>

<body>
    <a href="/articles" class="back">← Back to Articles</a>
    <div class="header">
        <h1>Search Results</h1>
        <div class="meta">
            <?= $count ?> result
            <?= $count !== 1 ? 's' : '' ?> for "
            <?= h($query) ?>"
        </div>
    </div>

    <form class="search-bar" action="/articles/search" method="post">
        <input type="hidden" name="_csrfToken" value="<?= $this->request->getAttribute('csrfToken') ?>">
        <input type="text" name="query" value="<?= h($query) ?>" placeholder="Search again..." />
        <button type="submit" class="btn">Search</button>
    </form>

    <?php if (empty($articles)): ?>
        <div class="empty">No articles matched "
            <?= h($query) ?>"
        </div>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
            <div class="result">
                <div class="id">#
                    <?= h($article['id']) ?>
                </div>
                <h2>
                    <?= h($article['title']) ?>
                </h2>
                <p>
                    <?= h($article['body']) ?>
                </p>
                <a href="/articles/view/<?= $article['id'] ?>">Read →</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <p class="page-count">
        <?= $this->Paginator->counter('Page {{page}} of {{pages}}, showing {{current}} of {{count}} articles') ?>
    </p>
    <div class="pagination">
        <?= $this->Paginator->first('« First') ?>
        <?= $this->Paginator->prev('← Prev') ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next('Next →') ?>
        <?= $this->Paginator->last('Last »') ?>
    </div>
</body>

</html>