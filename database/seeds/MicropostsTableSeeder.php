<?php

use Illuminate\Database\Seeder;

class MicropostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('microposts')->insert([
            [
                'user_id' => 1,
                'content' => 'Hello world!',
            ],
            [
                'user_id' => 1,
                'content' => 'Thank you user2!',
            ],
            [
                'user_id' => 1,
                'content' => 'Good by.',
            ],
            [
                'user_id' => 2,
                'content' => 'Fist tweet.',
            ],
            [
                'user_id' => 2,
                'content' => 'Second tweet.',
            ],
            [
                'user_id' => 3,
                'content' => 'Test tweet.',
            ],
        ]);
    }
}
