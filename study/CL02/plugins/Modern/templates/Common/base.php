<div class="page-wrap">
    <header class="page-header">
        <h1>
            <?= $this->fetch('pageHeading', 'Default Heading') ?>
        </h1>
    </header>
    <div class="page-body">
        <main class="page-main">
            <?= $this->fetch('content') ?>
        </main>
        <?php if ($this->fetch('sidebar') !== ''): ?>
            <aside class="page-sidebar">
                <?= $this->fetch('sidebar') ?>
            </aside>
        <?php endif; ?>
    </div>
</div>