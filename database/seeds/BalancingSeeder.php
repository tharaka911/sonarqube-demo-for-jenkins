<?php

namespace Database\Seeders;

use App\Balancing;
use Illuminate\Database\Seeder;

class BalancingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $balancing = [
            [
               'balancing_type'=>'normal',
               'status'=>1,
               'stream_type'=>"3min",
            ],
            [
                'balancing_type'=>'combine',
                'status'=>0,
                'stream_type'=>"3min",
            ],
            [
                'balancing_type'=>'single',
                'status'=>0,
                'stream_type'=>"3min",
            ],
            [
                'balancing_type'=>'normal',
                'status'=>1,
                'stream_type'=>"5min",
             ],
             [
                 'balancing_type'=>'combine',
                 'status'=>0,
                 'stream_type'=>"5min",
             ],
             [
                 'balancing_type'=>'single',
                 'status'=>0,
                 'stream_type'=>"5min",
             ],
              [
                'balancing_type'=>'combine_unbalance',
                'status'=>0,
                'stream_type'=>"3min",
            ],
            [
                'balancing_type'=>'single_unbalance',
                'status'=>0,
                'stream_type'=>"3min",
            ],
            [
                'balancing_type'=>'combine_unbalance',
                'status'=>0,
                'stream_type'=>"5min",
            ],
            [
                'balancing_type'=>'single_unbalance',
                'status'=>0,
                'stream_type'=>"5min",
             ]
        ];

        foreach ($balancing as $key => $value) {
            Balancing::create($value);
        }
    }
}
