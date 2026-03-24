<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\RoleCheckComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\RoleCheckComponent Test Case
 */
class RoleCheckComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\RoleCheckComponent
     */
    protected $RoleCheck;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->RoleCheck = new RoleCheckComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RoleCheck);

        parent::tearDown();
    }
}
