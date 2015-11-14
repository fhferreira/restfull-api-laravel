<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->command->comment('starting seeder products table');
        factory(\App\Product::class, 50)->create();
        $this->command->comment('50 registers created in products table');
    }
}
