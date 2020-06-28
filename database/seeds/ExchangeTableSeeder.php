<?php

use App\Exchange;
use Illuminate\Database\Seeder;

class ExchangeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Exchange::class, 30)->create();
    }
}