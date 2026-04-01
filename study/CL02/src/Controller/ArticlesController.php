<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Exception\FormProtectionException;

class ArticlesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent(
            'FormProtection',
            [
                'unlockedActions' => ['search', 'apiIndex', 'delete']
            ]
        );
        $this->loadComponent('CheckHttpCache');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->FormProtection->setConfig(
            'validateFailureCallback',
            function (FormProtectionException $exception) {
                $this->Flash->error('Form Security Check Failed');
                return $this->redirect(['action' => 'index']);
            }
        );
    }

    public function index()
    {
        $articles = $this->paginate(
            $this->Articles->find()
                ->select(['id', 'title', 'body'])
                ->orderBy(['Articles.id' => 'ASC']),
            ['limit' => 10]
        );
        $latest = $this->Articles->find()
            ->orderBy(['modified' => 'DESC'])
            ->first();

        if ($latest) {
            $response = $this->response
                ->withEtag(md5($latest->modified . $latest->id))
                ->withModified($latest->modified)
                ->withCache('-1 minute', '+1 hour');

            if ($response->isNotModified($this->request)) {
                return $response;
            }

            $this->response = $response;
        }

        $this->set(['articles' => $articles, 'page' => 'Articles Index']);

        $this->viewBuilder()
            ->setLayout('default')
            ->addHelper('Paginator')
            ->setLayout('ajax');
    }

    public function view($id)
    {
        $article = $this->Articles->get($id);

        $etag = md5($article->modified->toUnixString() . $article->id);

        $this->response = $this->response
            ->withEtag(trim($etag, '"'))
            ->withModified($article->modified)
            ->withCache('-1 minute', '+1 hour');

        $this->set('article', $article);
        $this->viewBuilder()
            ->addHelper('Html')
            ->setLayout('default');
    }

    public function add()
    {
        $article = $this->Articles->newEmptyEntity();

        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            $article->user_id = 1;
            $article->slug = strtolower(str_replace(' ', '-', $article->title ?? ''));
            $article->published = 1;

            if ($this->Articles->save($article)) {
                $this->Flash->success("Data Saved Successfully");
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Could not save. Check errors.');
            return;
        }

        $this->set(compact('article'));
        $this->viewBuilder()
            ->addHelper('Html')
            ->addHelper('Form')
            ->setLayout('default');
    }

    public function edit(int $id)
    {
        $article = $this->Articles->get($id);

        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->getData());
            $article->slug = strtolower(str_replace([' ', "'", '"'], ['-', '', ''], $article->title ?? ''));

            if ($this->Articles->save($article)) {
                $this->Flash->success('Article updated.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Could not update.');
        }

        $this->set(compact('article'));
        $this->viewBuilder()
            ->addHelper('Html')
            ->addHelper('Form')
            ->setLayout('default');
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);

        if ($this->Articles->delete($article)) {
            $this->Flash->success('Article Deleted Successfully');
        } else {
            $this->Flash->error('Could not delete.');
        }
        $this->redirect(['action' => 'index']);
    }

    public function search(): void
    {
        $query = $this->request->getData('query') ?? '';

        $articles = $this->paginate(
            $this->Articles->find()
                ->where(['Articles.title LIKE' => '%' . $query . '%'])
                ->orderBy(['Articles.id' => 'ASC']),
            ['limit' => 10]   // ← same pattern as index(), no $this->paginate
        );

        $this->set([
            'articles' => $articles,
            'query' => $query,
            'page' => 'Search: ' . h($query),
        ]);

        $this->viewBuilder()
            ->addHelper('Paginator')
            ->setLayout('ajax');
    }

    public function apiIndex()
    {
        $this->disableAutoRender();
        $this->response = $this->response
            ->withType('application/json')
            ->withStatus(200)
            ->withStringBody(json_encode($this->Articles->find()->all()->toArray()));
    }
}