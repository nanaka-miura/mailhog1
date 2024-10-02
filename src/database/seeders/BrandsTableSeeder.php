<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'ZARA'
        ];
        DB::table('brands')->insert($param);
        $param = [
            'name' => 'ユニクロ'
        ];
        DB::table('brands')->insert($param);
        $param = [
            'name' => 'GU'
        ];
        DB::table('brands')->insert($param);
        $param = [
            'name' => 'ユナイテッドアローズ'
        ];
        DB::table('brands')->insert($param);
        $param = [
            'name' => 'トゥモローランド'
        ];
        DB::table('brands')->insert($param);
    }
}
