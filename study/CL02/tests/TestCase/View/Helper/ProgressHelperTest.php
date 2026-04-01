<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\ProgressHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\ProgressHelper Test Case
 */
class ProgressHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\ProgressHelper
     */
    protected $Progress;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Progress = new ProgressHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Progress);

        parent::tearDown();
    }
}
