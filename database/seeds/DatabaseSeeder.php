<?php

use App\Category;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Category::truncate();
        Transaction::truncate();
        Product::truncate();

        DB::table('category_product')->truncate();

        factory(User::class,20)->create();
        factory(Category::class,10)->create();
        factory(Product::class,30)->create()->each(
            function ($product)
            {
                $categories = Category::all()->random(mt_rand(1,5))->pluck('id');
                $product->categories()->attach($categories);

            });

        factory(Transaction::class,30)->create();



        // $this->call(UserSeeder::class);
    }
}
