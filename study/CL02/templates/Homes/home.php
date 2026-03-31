<?php
$this->extend('/Common/base');
$this->assign('title', 'CakePHP Views Study');
$this->assign('pageHeading', h($pageTitle));

$this->Html->css('home', ['block' => true]);


$this->start('nav');
?>
<a href="/" class="nav-link active">Home</a>
<a href="/articles" class="nav-link">Articles</a>
<?php $this->end(); ?>
<?php
$this->start('sidebar');
?>
<ul class="sidebar-list">
    <?php foreach ($viewConcepts as $concepts): ?>
        <li><?= h($concepts) ?></li>
    <?php endforeach; ?>
</ul>

<?php $this->end(); ?>

<p><?= h($pageSubtitle) ?></p>

<?php if (!empty($viewConcepts)): ?>
    <p><?= count($viewConcepts) ?></p>
<?php else: ?>
    <p>No concepts loaded.</p>
<?php endif; ?>

<?= $this->element('stats_bar', ['stats' => $stats]) ?>

<!-- TOPIC 4 — render concept_card element in a loop -->
<div class="cards-grid">
    <?php foreach ($conceptCards as $index => $card): ?>
        <?= $this->element('concept_card', [
            'index' => str_pad($index + 1, 2, '0', STR_PAD_LEFT),
            'title' => $card['title'],
            'description' => $card['description'],
        ]) ?>
    <?php endforeach; ?>
</div>