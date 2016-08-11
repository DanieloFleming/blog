<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $dummyData = [];



        for ($i = 0; $i < 3; $i++) {

            array_push($dummyData, [
                'title' => $faker->text($maxNbChars = 50),
                'slug' => 'title-'. $i,
                'content' => '<p>' . $faker->paragraph . '</p>',
                'created_at' => $faker->dateTime($max = 'now'),
                'updated_at' => $faker->dateTime($max = 'now')
            ]);
        }

        DB::table('posts')->insert($dummyData);
    }
}
