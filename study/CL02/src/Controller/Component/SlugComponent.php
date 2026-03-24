<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

class SlugComponent extends Component
{
    protected array $_defaultConfig = [
        'separator'  => '-',
        'lowercase'  => true,
        'maxLength'  => 191,
    ];

    public function generate(string $text): string
    {
        $separator = $this->getConfig('separator');

        $slug = preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
        $slug = preg_replace('/\s+/', $separator, trim($slug));

        if ($this->getConfig('lowercase')) {
            $slug = strtolower($slug);
        }

        return substr($slug, 0, $this->getConfig('maxLength'));
    }
}

