<?php

use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stores = \App\Store::all();
        
        foreach($stores AS $store)
        {
            $store->products()->save(factory(\App\Product::class)->make());
        }
    }
}
