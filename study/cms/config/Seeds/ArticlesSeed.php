<?php
declare(strict_types=1);
require_once ROOT . '/config/seed_config.php';

use Migrations\BaseSeed;
use Faker\Factory;
/**
 * Articles seed.
 */
class ArticlesSeed extends BaseSeed
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
        $usersArray = $this->fetchAll('select id from users;');
        $userIds = array_column($usersArray, 'id');
        $faker = Factory::create();

        for ($i = 0; $i < ARTICLE_COUNT; $i++) {

            $data = [
                [
                    'user_id' => $faker->randomElement($userIds),
                    'title' => $faker->realText(50),
                    'slug' => $faker->slug(),
                    'body' => $faker->realTextBetween(300, 500),
                    'published' => true,
                    'created' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                    'modified' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s')
                ]
            ];
            $table = $this->table('articles');
            $table->insert($data)->save();
        }

    }
}
