<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables(['users', 'posts', 'comments']);

        $this->call(UsersTableSeeder::class);
        $this->call(PostTableSeeder::class);
        $this->call(CommentTableSeeder::class);
    }

    public function truncateTables(array $tables){
        // Desactivo temporalmente checkeo de tablas foráneas para evitar errores
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach($tables as $table){
            DB::table($table)->truncate();
        }

        // Activo checkeo de tablas foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
