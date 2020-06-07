<?php

use Illuminate\Database\Seeder;

class UserFollowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_follow')->insert([
            [
                'user_id' => 1,
                'follow_id' => 2,
            ],
            [
                'user_id' => 1,
                'follow_id' => 3,
            ],
            [
                'user_id' => 1,
                'follow_id' => 5,
            ],
            [
                'user_id' => 2,
                'follow_id' => 1,
            ],
            [
                'user_id' => 2,
                'follow_id' => 3,
            ],
            [
                'user_id' => 3,
                'follow_id' => 1,
            ],
            [
                'user_id' => 5,
                'follow_id' => 1,
            ],
        ]);
    }
}
