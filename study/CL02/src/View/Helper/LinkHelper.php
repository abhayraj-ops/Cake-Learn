<?php
namespace App\View\Helper;

use Cake\View\Helper;

class LinkHelper extends Helper
{
    // This tells CakePHP to make the HtmlHelper available inside this class
    protected array $helpers = ['Html'];

    public function makeEditButton(string $title, array $url): string
    {
        // Now we can use $this->Html just like in a template!
        $link = $this->Html->link($title, $url, ['class' => 'btn btn-primary']);

        return '<div class="custom-wrapper">' . $link . '</div>';
    }
}