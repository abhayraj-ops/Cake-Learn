<?php

$this->Html->css('style', ['block' => true]);


?>
<div class="dashboard-container">
    <h1>
        <?= $this->Html->tag('i', '', ['class' => 'icon-home']) ?> Project Dashboard
    </h1>

    <div class="card">
        <h3>Project Status</h3>
        <p>Current Phase:
            <?= $this->Progress->statusBadge('Completed') ?>
        </p>
    </div>

    <div class="actions">
        <?= $this->Link->makeEditButton('Update Project', ['action' => 'edit', 1]) ?>

        <a href="<?= $this->Url->build(['action' => 'settings']) ?>">View Settings</a>
    </div>

</div>