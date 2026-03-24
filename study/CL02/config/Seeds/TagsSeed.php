<?php
declare(strict_types=1);
require_once ROOT . '/config/seed_config.php';

use Faker\Factory;
use Migrations\BaseSeed;

/**
 * Tags seed.
 */
class TagsSeed extends BaseSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/migrations/4/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < TAG_COUNT; $i++) {

            $data = [
                'title' => $faker->unique()->realText(10),
                'created' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'modified' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            ];

            $table = $this->table('tags');
            $table->insert($data)->save();

        }

    }
}
