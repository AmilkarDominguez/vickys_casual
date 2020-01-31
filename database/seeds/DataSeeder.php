<?php

use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $table->enum('state', ['ACTIVO', 'INACTIVO','ELIMINADO'])->default('ACTIVO')->nullable();
        $table->string('name')->nullable();
        $table->string('gender')->nullable();
        $table->text('telephone')->nullable();
        $table->enum('rol', ['ADMIN', 'NORMAL'])->default('NORMAL')->nullable();
        $table->string('email')->unique()->nullable();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        */ 


        $admin = App\User::create([
            'email_verified_at' => now(),
            'remember_token' => str_random(10),
            'state' => 'ACTIVO',
            'name' => 'admin',
            'rol' => 'ADMIN',
            'email'=> 'admin@admin.com',
            'password' => bcrypt('bytemo852456'),    
        ]);
        $admin = App\User::create([
            'email_verified_at' => now(),
            'remember_token' => str_random(10),
            'state' => 'ACTIVO',
            'name' => 'admin',
            'rol' => 'ADMIN',
            'email'=> 'appconsulta@vickyscasual.com',
            'password' => bcrypt('cnslt.963Vc'),    
        ]);
        $user = App\User::create([
            'telephone' => '72954379',
            'password' => bcrypt('12345678'),
            'remember_token' => str_random(20),
            'rol' => 'NORMAL',
            'state' => 'ACTIVO',
        ]);
        $user = App\User::create([
            'telephone' => '75114379',
            'password' => bcrypt('12345678'),
            'remember_token' => str_random(20),
            'rol' => 'NORMAL',
            'state' => 'ACTIVO',
        ]);
    }
}
