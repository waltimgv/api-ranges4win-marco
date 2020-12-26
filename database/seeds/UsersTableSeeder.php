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
        \App\User::query()->create([
            'name' => 'Administrador Padrão',
            'email' => 'admin@admin.com',
            'password' => bcrypt('TCi66PXOei'),
            'is_terms_use_accepted' => true,
            'role' => \App\Enums\Role::ADMIN,
            'email_verified_at' => \Carbon\Carbon::now()
        ]);
    }

}
