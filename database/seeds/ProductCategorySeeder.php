<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class ProductCategorySeeder extends Seeder {
    public function run()
    {
        DB::table('product_category')->delete();
        $category = app()->make('App\ProductCategory');
         $category->fill([
          'name' => aaa,
          'parent' => abc,
          'status' => ,
        $category->save();
    }
}