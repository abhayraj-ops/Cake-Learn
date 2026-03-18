<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class ArticlesController extends AppController
{
    private array $data = [
        ['id' => 1, 'title' => 'First Article', 'body' => 'Body of first article'],
        ['id' => 2, 'title' => 'Second Article', 'body' => 'Body of second article'],
        ['id' => 3, 'title' => 'Third Article', 'body' => 'Body of third article'],
    ];
    public function index(): void
    {
        $this->set([
            'articles' => $this->data,
            'total' => count($this->data),
            'page' => 'Articles Index',
        ]);

        $this->viewBuilder()
            ->addHelper('Html')
            ->addHelper('Url')
            ->setLayout('default');
    }

    public function view($id)
    {
        $article = null;
        foreach ($this->data as $key => $value) {
            if ($value['id'] == $id) {
                $article = $value;
                break;
            }
        }

        if ($article === null) {
            throw new NotFoundException('Article not found!!');
        }

        $this->set('article', $article);

    }

    public function edit($id)
    {
        $articleKey = null;
        $article = null;
        foreach ($this->data as $key => $value) {
            if ($value['id'] == $id) {
                $article = $value;
                $articleKey = $key;
                break;
            }
        }

        if ($article === null) {
            throw new NotFoundException('Article Not Found');
        }

        if ($this->request->is(['put', 'post'])) {
            $this->data[$articleKey] = $this->request->getData() + ['id' => $id];
            $this->Flash->success('Successfuly Updated');
            $this->redirect(['action' => 'index']);
            return;
        }

        $this->set(compact('article'));

        $this->viewBuilder()
            ->addHelper('Form')
            ->setLayout('default');
    }

    public function delete($id)
    {
        if ($this->request->is('delete')) {
            $this->data = array_filter(
                $this->data,
                fn($item) => $item['id'] !== $id
            );
            $this->Flash->success('Successfuly Deleted.');
            $this->redirect(['action' => 'index']);
        }
    }

    public function add()
    {
        $article = [];

        if ($this->request->is('post')) {

            $article = $this->request->getData();
            $article['id'] = count($this->data) + 1;
            $this->data[] = $article;

            $this->Flash->success('Article Created');
            $this->redirect(['action' => 'index']);

            return;

        }

        $this->set(compact('article'));

        $this->viewBuilder()
            ->addHelper('Form')
            ->setLayout('default');
    }

    public function search(): void
    {
        $query = $this->request->getData('query') ?? '';

        $results = array_filter(
            $this->data,
            fn($item) => str_contains(strtolower($item['title']), strtolower($query))
        );

        $this->set([
            'articles' => $results,
            'query' => $query,
            'count' => count($results),
        ]);
    }

    public function apiIndex()
    {
        $this->disableAutoRender();
        $this->response = $this->response
            ->withType('application/json')
            ->withStatus(200)
            ->withStringBody(json_encode($this->data));
    }

}