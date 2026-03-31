<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= h($this->fetch('title')) ?> — Modern</title>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>

<body class="theme-modern">

    <header class="modern-header">
        <span class="modern-logo">◆ Modern Theme Active</span>
        <?php if ($this->fetch('nav') !== ''): ?>
            <nav><?= $this->fetch('nav') ?></nav>
        <?php endif; ?>
    </header>

    <div class="modern-wrap">
        <?= $this->fetch('content') ?>
    </div>

    <?= $this->fetch('script') ?>
</body>

</html>