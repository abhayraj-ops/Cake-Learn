<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\View\JsonView;
use Cake\View\XmlView;

class HomesController extends AppController
{

    public function export(string $format = 'json'): void
    {
        $formats = [
            'json' => 'Json',
            'xml' => 'Xml',
        ];

        if (!isset($formats[$format])) {
            throw new \Cake\Http\Exception\NotFoundException('Unknown format');
        }

        $this->viewBuilder()->setClassName($formats[$format]);

        $articles = $this->Articles->find()->all();
        $this->set(compact('articles'));
        $this->viewBuilder()->setOption('serialize', ['articles']);
    }
    public function viewClasses(): array
    {
        return [JsonView::class, XmlView::class];
    }
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('CheckHttpCache');
    }

    public function home(): void
    {
        // $this->viewBuilder()
        //     ->setTheme('Modern');

        $viewConcepts = [
            'Templates',
            'Layouts',
            'Elements',
            'Helpers',
            'Cells',
        ];

        $this->set([
            'pageTitle' => 'CakePHP — View Layer Study',
            'pageSubtitle' => 'Topic 1 — View Basics',
        ]);

        $this->set(compact('viewConcepts'));
        $conceptCards = [
            ['title' => 'Templates', 'description' => 'Unique PHP file per controller action'],
            ['title' => 'Layouts', 'description' => 'Outer HTML shell wrapping every view'],
            ['title' => 'Helpers', 'description' => 'View layer utility classes'],
            ['title' => 'Cells', 'description' => 'Mini-controllers for UI components'],
        ];

        $stats = [
            ['label' => 'Templates', 'value' => count($viewConcepts)],
            ['label' => 'Articles', 'value' => $this->fetchTable('Articles')->find()->count()],
            ['label' => 'Elements', 'value' => 2],
        ];

        $this->set(compact('conceptCards', 'stats'));
        $this->viewBuilder()
            ->setClassName('View')
            ->setLayout('default');
    }
    public function apiHome(): void
    {
        $this->viewBuilder()->setClassName('Json');
        $stats = [
            'total' => (int) $this->fetchTable('Articles')->find()->count(),
            'published' => (int) $this->fetchTable('Articles')
                ->find()->where(['published' => 1])->count(),
        ];

        $this->set('stats', $stats);
        $this->viewBuilder()
            ->setOption('serialize', ['stats'])
            ->setOption('jsonOptions', JSON_PRETTY_PRINT);
    }

}
