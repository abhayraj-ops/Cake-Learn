<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\ActivityLogComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\ActivityLogComponent Test Case
 */
class ActivityLogComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\ActivityLogComponent
     */
    protected $ActivityLog;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->ActivityLog = new ActivityLogComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ActivityLog);

        parent::tearDown();
    }
}
