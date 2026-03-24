<!-- templates/Articles/view.php -->
<!-- Variables: $article (Article entity) -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= h($article->title) ?></title>
    <link rel="icon" href="data:,">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Mono:wght@400;500&display=swap"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Mono:wght@400;500&display=swap">
    </noscript>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        :root {
            --bg: #0d0d0d;
            --surface: #161616;
            --border: #2a2a2a;
            --accent: #c8f542;
            --text: #e8e8e8;
            --muted: #666;
            --danger: #ff4d4d
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Mono', ui-monospace, monospace;
            min-height: 100vh;
            padding: 3rem 2rem;
            max-width: 760px;
            margin: 0 auto
        }

        .back {
            font-size: .78rem;
            color: var(--muted);
            text-decoration: none;
            display: inline-block;
            margin-bottom: 2rem
        }

        .back:hover {
            color: var(--accent)
        }

        .id {
            font-size: .72rem;
            color: var(--muted);
            margin-bottom: .5rem
        }

        h1 {
            font-family: 'Syne', system-ui, sans-serif;
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 1.5rem;
            letter-spacing: -.03em
        }

        .body {
            font-size: .9rem;
            line-height: 1.8;
            color: var(--text);
            border-left: 2px solid var(--border);
            padding-left: 1.5rem
        }

        .meta {
            font-size: .72rem;
            color: var(--muted);
            margin-top: 1.5rem
        }

        .actions {
            display: flex;
            gap: .75rem;
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
            align-items: center
        }

        .actions form {
            margin: 0;
            padding: 0;
            display: inline-flex
        }

        .btn {
            display: inline-block;
            padding: .6rem 1.4rem;
            font-family: inherit;
            font-size: .8rem;
            text-decoration: none;
            border: 1px solid var(--accent);
            color: var(--accent);
            background: transparent;
            cursor: pointer;
            letter-spacing: .05em
        }

        .btn:hover,
        .btn:focus-visible {
            background: var(--accent);
            color: var(--bg)
        }

        .btn-danger {
            border-color: var(--danger);
            color: var(--danger)
        }

        .btn-danger:hover,
        .btn-danger:focus-visible {
            background: var(--danger);
            color: #fff
        }
    </style>
</head>

<body>

    <a href="/articles" class="back">← Back to Articles</a>

    <div class="id">#<?= $article->id ?></div>
    <h1><?= h($article->title) ?></h1>

    <div class="body">
        <p><?= h($article->body) ?></p>
    </div>

    <?php if (!empty($article->created)): ?>
        <div class="meta"><?= h($article->created) ?></div>
    <?php endif; ?>

    <div class="actions">
        <a href="/articles/edit/<?= $article->id ?>" class="btn">Edit</a>
        <form action="/articles/delete/<?= $article->id ?>" method="post">
            <?= $this->Form->hidden('_csrfToken', ['value' => $this->request->getAttribute('csrfToken')]) ?>
            <button type="submit" class="btn btn-danger"
                onclick="return confirm('Delete #<?= $article->id ?>?')">Delete</button>
        </form>
    </div>

</body>

</html>