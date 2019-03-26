<?php

use Illuminate\Database\Seeder;

class SortTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('sorts')->insert([
            [
                'name' => '技术',
                'article_num' => 0
            ],
            [
                'name' => '书单',
                'article_num' => 0
            ],
            [
                'name' => '美食',
                'article_num' => 0
            ],
            [
                'name' => '随记',
                'article_num' => 0
            ]
        ]);
    }
}
