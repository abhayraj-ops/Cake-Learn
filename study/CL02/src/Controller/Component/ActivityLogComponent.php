<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\EventInterface;
use Cake\Log\Log;

class ActivityLogComponent extends Component
{
    private float $startTime;

    public function beforeFilter(EventInterface $event): void
    {
        $this->startTime = microtime(true);
        Log::info('Request Started: ' . $this->getController()->request->getRequestTarget());
    }

    public function startup(EventInterface $event): void
    {
        
    }
}
