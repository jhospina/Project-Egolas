<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //Model::unguard();
        // $this->call(UserTableSeeder::class);

        DB::table('users')->insert([
            'name' => "John",
            "lastname" => "Ospina",
            "role" => App\System\Models\User::ROLE_ADMIN,
            'email' => 'jhonospina150@gmail.com',
            'password' => bcrypt('contra123')
        ]);

        // Model::reguard();
    }

}
