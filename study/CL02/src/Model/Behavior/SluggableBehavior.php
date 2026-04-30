<?php
namespace App\Model\Behavior;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\Utility\Text;

class SluggableBehavior extends Behavior
{
    // Default config — can be overridden when attaching
    protected array $_defaultConfig = [
        'field' => 'title',      // read from this field
        'slug' => 'slug',       // write to this field
        'replacement' => '-',          // separator character
    ];

    // This runs automatically before every save!
    public function beforeSave(
        EventInterface $event,
        EntityInterface $entity,
        ArrayObject $options
    ): void {
        $config = $this->getConfig();
        $value = $entity->get($config['field']);
        $entity->set(
            $config['slug'],
            Text::slug($value, $config['replacement'])
        );
    }
}