<?php

use Illuminate\Database\Seeder;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('favorites')->insert([
            [
               'user_id' => 1,
               'micropost_id' => 1,
            ],
            [
                'user_id' => 1,
                'micropost_id' => 2,
            ],
            [
                'user_id' => 1,
                'micropost_id' => 4,
            ],
            [
                'user_id' => 1,
                'micropost_id' => 6,
            ],
            [
                'user_id' => 2,
                'micropost_id' => 1,
            ],
        ]);
    }
}
