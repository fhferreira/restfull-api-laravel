<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $this->command->comment('starting seeder categories table');
       factory(App\Category::class, 10)->create();
       $this->command->comment('10 registers created in category table');
    }
}
