<?php
/**
 * Element: stats_bar
 * Variables: $stats (array of ['label' => '', 'value' => ''])
 */
?>
<div class="stats-bar">
    <?php foreach ($stats as $stat): ?>
        <div class="stat-item">
            <span class="stat-value">
                <?= h($stat['value']) ?>
            </span>
            <span class="stat-label">
                <?= h($stat['label']) ?>
            </span>
        </div>
    <?php endforeach; ?>
</div>