<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function runSample1()
    {      
        Model::unguard();
        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        //Clear the Database tables
        Product::truncate();
        //DB::table('products')->truncate();
        Category::truncate();
        //DB::table('categories')->truncate();

        //Call the seeders
        $this->call(CategoryTableSeeder::class);
        $this->call(ProductTableSeeder::class);

        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();
    }

    protected $tables = [
        'products',
        'categories',
    ];

    protected $seeders = [
        'CategoryTableSeeder',
        'ProductTableSeeder',
    ];

    public function run()
    {
        Eloquent::unguard();

        $this->cleanDatabase();

        foreach($this->seeders as $seedClass)
        {
          $this->call($seedClass);
        }
    }

    private function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach($this->tables as $table)
        {
          DB::table($table)->truncate();
          //DB::statement("TRUNCATE TABLE {$table}");
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
