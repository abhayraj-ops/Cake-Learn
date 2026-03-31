<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($this->fetch('title')) ?></title>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>

<body>

    <?php if ($this->fetch('nav') !== ''): ?>
        <nav class="site-nav">
                <?= $this->fetch('nav') ?>
        </nav>
    <?php endif; ?>

    <div class="site-wrap">
        <?= $this->fetch('content') ?>
    </div>

    <?= $this->fetch('script') ?>
    <?= $this->fetch('scriptBottom') ?>

</body>

</html>