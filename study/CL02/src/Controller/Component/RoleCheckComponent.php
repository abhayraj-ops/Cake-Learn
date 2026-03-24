<?php
declare(strict_types=1);
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\EventInterface;
use Cake\Http\Exception\ForbiddenException;

class RoleCheckComponent extends Component
{
    protected array $_defaultConfig = [
        'adminActions' => ['delete', 'edit'],
        'sessionKey' => 'Auth.user',
        'roleField' => 'role',
        'redirectUrl' => '/',
    ];

    // runs before every action
    public function beforeFilter(EventInterface $event): void
    {
        $controller = $this->getController();
        $action = $controller->request->getParam('action');
        $adminActions = $this->getConfig('adminActions');

        if (!in_array($action, $adminActions)) {
            return; // not a protected action — allow through
        }

        $sessionKey = $this->getConfig('sessionKey');
        $roleField = $this->getConfig('roleField');
        $user = $controller->request->getSession()->read($sessionKey);

        if (!$user || $user[$roleField] !== 'admin') {
            $controller->Flash->error('Admins only.');
            $event->setResult(
                $controller->redirect($this->getConfig('redirectUrl'))
            );
        }
    }

    // call manually in any action
    public function requireRole(string $role): void
    {
        $controller = $this->getController();
        $sessionKey = $this->getConfig('sessionKey');
        $roleField = $this->getConfig('roleField');
        $user = $controller->request->getSession()->read($sessionKey);

        if (!$user || $user[$roleField] !== $role) {
            throw new ForbiddenException('You do not have permission.');
        }
    }

    public function isAdmin(): bool
    {
        $controller = $this->getController();
        $user = $controller->request->getSession()
            ->read($this->getConfig('sessionKey'));

        return isset($user[$this->getConfig('roleField')])
            && $user[$this->getConfig('roleField')] === 'admin';
    }
}