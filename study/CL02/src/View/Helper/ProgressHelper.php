<?php
namespace App\View\Helper;

use Cake\View\Helper;

class ProgressHelper extends Helper
{
    protected array $helpers = ['Html'];

    /**
     * Generates a styled status badge
     */
    public function statusBadge(string $status): string
    {
        $class = ($status === 'Completed') ? 'badge-success' : 'badge-warning';

        // Using the borrowed Html helper to create a span
        return $this->Html->tag('span', $status, ['class' => "badge $class"]);
    }
}