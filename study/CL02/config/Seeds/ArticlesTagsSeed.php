<?php
declare(strict_types=1);
require_once ROOT . '/config/seed_config.php';

use Faker\Factory;
use Migrations\BaseSeed;

/**
 * ArticlesTags seed.
 */
class ArticlesTagsSeed extends BaseSeed
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

        $articleData = $this->fetchAll('select id from articles;');
        $articleIds = array_column($articleData, 'id');

        $tagData = $this->fetchAll('select id from tags;');
        $tagIds = array_column($tagData, 'id');

        shuffle($articleIds);

        $faker = Factory::create();

        for ($i = 0; $i < ARTICLE_COUNT; $i++) {

            $data = [
                'tag_id' => $faker->randomElement($tagIds),
                'article_id' => array_pop($articleIds),
                'created' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'modified' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s')
            ];

            $table = $this->table('articles_tags');
            $table->insert($data)->save();

        }

    }
}
