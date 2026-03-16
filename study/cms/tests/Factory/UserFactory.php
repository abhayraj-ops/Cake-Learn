<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * UserFactory
 *
 * @method \App\Model\Entity\User getEntity()
 * @method array<\App\Model\Entity\User> getEntities()
 * @method \App\Model\Entity\User|array<\App\Model\Entity\User> persist()
 * @method static \App\Model\Entity\User get(mixed $primaryKey, array $options = [])
 */
class UserFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Users';
    }

    /**
     * Defines the factory's default values. This is useful for
     * not nullable fields. You may use methods of the present factory here too.
     *
     * @return void
     */
    protected function setDefaultTemplate(): void
    {
        $this->setDefaultData(function (Generator $faker) {
            return [
                'email' => $faker->email(),
                'password' => $faker->text(255),
                'created' => $faker->datetime(),
                'modified' => $faker->datetime(),
            ];
        });
    }
}
