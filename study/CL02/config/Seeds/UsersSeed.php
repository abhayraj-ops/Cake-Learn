<?php
declare(strict_types=1);
require_once ROOT . '/config/seed_config.php';
use Migrations\BaseSeed;
use Faker\Factory;

/**
 * Users seed.
 */
class UsersSeed extends BaseSeed
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
        for ($i = 0; $i < USER_COUNT; $i++) {
            $data = [
                [
                    'email' => $faker->unique()->safeEmail(),
                    'password' => (new \Authentication\PasswordHasher\DefaultPasswordHasher())->hash('password'),
                    'created' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                    'modified' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s')
                ]
            ];

            $table = $this->table('users');
            $table->insert($data)->save();
        }

    }
}
