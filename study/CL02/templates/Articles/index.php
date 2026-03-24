<!-- templates/Articles/index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <link rel="icon" href="data:,">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Mono:wght@400;500&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Mono:wght@400;500&display=swap"></noscript>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--bg:#0d0d0d;--surface:#161616;--border:#2a2a2a;--accent:#c8f542;--text:#e8e8e8;--muted:#666;--danger:#ff4d4d}
        body{background:var(--bg);color:var(--text);font-family:'DM Mono',ui-monospace,monospace;min-height:100vh;padding:3rem 2rem}
        .header{display:flex;justify-content:space-between;align-items:flex-end;border-bottom:1px solid var(--border);padding-bottom:1.5rem;margin-bottom:2.5rem}
        .header h1{font-family:'Syne',system-ui,sans-serif;font-size:2.8rem;font-weight:800;letter-spacing:-.03em;color:var(--accent)}
        .header .meta{font-size:.75rem;color:var(--muted);text-align:right;display:flex;flex-direction:column;gap:.5rem;align-items:flex-end}
        .btn{display:inline-block;padding:.6rem 1.4rem;font-family:inherit;font-size:.8rem;text-decoration:none;border:1px solid var(--accent);color:var(--accent);background:transparent;cursor:pointer;letter-spacing:.05em}
        .btn:hover,.btn:focus-visible{background:var(--accent);color:var(--bg)}
        .btn-danger{border-color:var(--danger);color:var(--danger)}
        .btn-danger:hover,.btn-danger:focus-visible{background:var(--danger);color:#fff}
        .search-bar{display:flex;gap:.5rem;margin-bottom:2rem}
        .search-bar input{flex:1;background:var(--surface);border:1px solid var(--border);color:var(--text);padding:.6rem 1rem;font-family:inherit;font-size:.85rem;outline:none}
        .search-bar input:focus{border-color:var(--accent)}
        .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:1.5rem}
        .card{background:var(--surface);border:1px solid var(--border);padding:1.5rem;contain:layout style}
        .card:hover{border-color:var(--accent)}
        .card .id{font-size:.7rem;color:var(--muted);margin-bottom:.5rem}
        .card h2{font-family:'Syne',system-ui,sans-serif;font-size:1.2rem;font-weight:700;margin-bottom:.75rem;color:var(--text)}
        .card p{font-size:.82rem;color:var(--muted);line-height:1.6;margin-bottom:1.2rem;display:-webkit-box;-webkit-line-clamp:4;-webkit-box-orient:vertical;overflow:hidden}
        .card .actions{display:flex;gap:.5rem;flex-wrap:wrap;align-items:center}
        .card .actions form{margin:0;padding:0;display:inline-flex}
        .empty{text-align:center;padding:4rem;color:var(--muted);font-size:.9rem;border:1px dashed var(--border)}
        .flash-success{background:rgba(200,245,66,.08);border:1px solid var(--accent);color:var(--accent);padding:.75rem 1rem;font-size:.82rem;margin-bottom:1.5rem}
        .flash-error{background:rgba(255,77,77,.08);border:1px solid var(--danger);color:var(--danger);padding:.75rem 1rem;font-size:.82rem;margin-bottom:1.5rem}
        .page-count{font-size:.75rem;color:var(--muted);margin-top:2rem;margin-bottom:1rem}
        .pagination{display:flex;gap:.5rem;align-items:center;flex-wrap:wrap}
        .pagination a,.pagination span{padding:.4rem .8rem;border:1px solid var(--border);color:var(--accent);text-decoration:none;font-size:.78rem}
        .pagination a:hover{background:var(--accent);color:var(--bg)}
        .pagination .current{border-color:var(--accent);background:var(--accent);color:var(--bg)}
        .pagination .disabled{color:var(--muted);border-color:var(--border);pointer-events:none}
    </style>
</head>
<body>

    <?= $this->Flash->render() ?>

    <div class="header">
        <h1><?= h($page) ?></h1>
        <div class="meta">
            <span><?= $this->Paginator->counter('{{count}}') ?> articles</span>
            <a href="/articles/add" class="btn">+ New Article</a>
        </div>
    </div>

    <form class="search-bar" action="/articles/search" method="post">
        <?= $this->Form->hidden('_csrfToken', ['value' => $this->request->getAttribute('csrfToken')]) ?>
        <input type="text" name="query" placeholder="Search by title..." autocomplete="off">
        <button type="submit" class="btn">Search</button>
    </form>

    <?php if (empty($articles)): ?>

        <div class="empty">No articles yet. Create your first one.</div>

    <?php else: ?>

        <div class="grid">
            <?php foreach ($articles as $a): ?>
                <div class="card">
                    <div class="id">#<?= $a->id ?></div>
                    <h2><?= h($a->title) ?></h2>
                    <p><?= h($a->body) ?></p>
                    <div class="actions">
                        <a href="/articles/view/<?= $a->id ?>" class="btn">View</a>
                        <a href="/articles/edit/<?= $a->id ?>" class="btn">Edit</a>
                        <form action="/articles/delete/<?= $a->id ?>" method="post">
                            <?= $this->Form->hidden('_csrfToken', ['value' => $this->request->getAttribute('csrfToken')]) ?>
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Delete #<?= $a->id ?>?')">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

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