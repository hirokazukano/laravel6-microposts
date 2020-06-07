<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('himituhimitu');
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'id' => $i,
                'name' => 'user' . $i,
                'email' => 'user' . $i . '@gmail.com',
                'password' => $password,
            ];
        }
        DB::table('users')->insert($data);
    }
}
