<!-- ═══════════════════════════════════════════════════════════════
     templates/Articles/add.php
     Variables: $article (empty array on GET, filled on validation fail)
════════════════════════════════════════════════════════════════ -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Article</title>
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
            max-width: 640px;
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

        h1 {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 2rem;
        }

        label {
            display: block;
            font-size: 0.72rem;
            color: var(--muted);
            margin-bottom: 0.4rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        input,
        textarea {
            width: 100%;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 0.75rem 1rem;
            font-family: 'DM Mono', monospace;
            font-size: 0.85rem;
            outline: none;
            margin-bottom: 1.5rem;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            border-color: var(--accent);
        }

        textarea {
            min-height: 160px;
        }

        .btn {
            display: inline-block;
            padding: 0.7rem 1.8rem;
            font-family: 'DM Mono', monospace;
            font-size: 0.85rem;
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
    </style>
</head>

<body>
    <?= $this->Flash->render() ?>
    <a href="/articles" class="back">← Back to Articles</a>
    <h1>New Article</h1>

    <?= $this->Form->create($article, ['url' => ['action' => 'add']]) ?>

    <label for="title">Title</label>
    <?= $this->Form->control('title', [
        'id' => 'title',
        'label' => false,
        'value' => $article->title ?? '',
    ]) ?>

    <label for="body">Body</label>
    <?= $this->Form->control('body', [
        'id' => 'body',
        'label' => false,
        'type' => 'textarea',
        'value' => $article->body ?? '',
    ]) ?>

    <?= $this->Form->button('Create Article', ['class' => 'btn']) ?>

    <?= $this->Form->end() ?>
</body>

</html>