<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\SlugComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\SlugComponent Test Case
 */
class SlugComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\SlugComponent
     */
    protected $Slug;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Slug = new SlugComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Slug);

        parent::tearDown();
    }
}
