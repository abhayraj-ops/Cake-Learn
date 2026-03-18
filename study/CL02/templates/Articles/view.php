<!-- ═══════════════════════════════════════════════════════════════
     templates/Articles/view.php
     Variables: $article (single array item)
════════════════════════════════════════════════════════════════ -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        <?= h($article['title']) ?>
    </title>
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
            max-width: 760px;
            margin: 0 auto;
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

        .id {
            font-size: 0.72rem;
            color: var(--muted);
            margin-bottom: 0.5rem;
        }

        h1 {
            font-family: 'Syne', sans-serif;
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 1.5rem;
            letter-spacing: -0.03em;
        }

        .body {
            font-size: 0.9rem;
            line-height: 1.8;
            color: var(--text);
            border-left: 2px solid var(--border);
            padding-left: 1.5rem;
        }

        .actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
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

        .btn-danger {
            border-color: #ff4d4d;
            color: #ff4d4d;
        }

        .btn-danger:hover {
            background: #ff4d4d;
            color: #fff;
        }
    </style>
</head>

<body>
    <a href="/articles" class="back">← Back to Articles</a>
    <div class="id">#
        <?= h($article['id']) ?>
    </div>
    <h1>
        <?= h($article['title']) ?>
    </h1>
    <div class="body">
        <?= h($article['body']) ?>
    </div>
    <div class="actions">
        <a href="/articles/edit/<?= $article['id'] ?>" class="btn">Edit</a>
        <form action="/articles/delete/<?= $article['id'] ?>" method="post">
            <?= $this->Form->hidden('_token', ['value' => $this->request->getAttribute('csrfToken')]) ?>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</body>

</html>