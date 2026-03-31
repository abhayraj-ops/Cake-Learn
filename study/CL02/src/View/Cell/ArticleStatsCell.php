<?php
declare(strict_types=1);
namespace App\View\Cell;

use Cake\View\Cell;

class ArticleStatsCell extends Cell
{
    public function display(): void
    {
        $total = $this->fetchTable('Articles')->find()->count();
        $published = $this->fetchTable('Articles')
            ->find()->where(['published' => 1])->count();
        $latest = $this->fetchTable('Articles')
            ->find()->orderBy(['created' => 'DESC'])->first();

        $this->set(compact('total', 'published', 'latest'));
    }
}