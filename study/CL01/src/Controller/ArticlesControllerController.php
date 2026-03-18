<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

/**
 * ArticlesController Controller
 *
 */
class ArticlesControllerController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        return Response
    }

    /**
     * View method
     *
     * @param string|null $id Articles Controller id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $articlesController = $this->ArticlesController->get($id, contain: []);
        $this->set(compact('articlesController'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $articlesController = $this->ArticlesController->newEmptyEntity();
        if ($this->request->is('post')) {
            $articlesController = $this->ArticlesController->patchEntity($articlesController, $this->request->getData());
            if ($this->ArticlesController->save($articlesController)) {
                $this->Flash->success(__('The articles controller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The articles controller could not be saved. Please, try again.'));
        }
        $this->set(compact('articlesController'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Articles Controller id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $articlesController = $this->ArticlesController->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $articlesController = $this->ArticlesController->patchEntity($articlesController, $this->request->getData());
            if ($this->ArticlesController->save($articlesController)) {
                $this->Flash->success(__('The articles controller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The articles controller could not be saved. Please, try again.'));
        }
        $this->set(compact('articlesController'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Articles Controller id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $articlesController = $this->ArticlesController->get($id);
        if ($this->ArticlesController->delete($articlesController)) {
            $this->Flash->success(__('The articles controller has been deleted.'));
        } else {
            $this->Flash->error(__('The articles controller could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
