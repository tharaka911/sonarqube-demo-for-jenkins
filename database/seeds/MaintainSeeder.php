<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Maintain;

class MaintainSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $maintain = [
            [
               'game_type'=>'dh_powerball',
               'type'=>'5min'
            ],
            [
                'game_type'=>'live_powerball',
                'type'=>'5min'
             ],
             [
                'game_type'=>'live_powerball',
                'type'=>'3min'
             ],
             [
                'game_type'=>'live_powerball_ladder',
                'type'=>'5min'
             ],
             [
                'game_type'=>'live_powerball_ladder',
                'type'=>'3min'
             ],
             [
                'game_type'=>'dh_speed_kino',
                'type'=>'5min'
             ],
             [
                'game_type'=>'n_powerball',
                'type'=>'5min'
             ],
             [
                'game_type'=>'n_powerball',
                'type'=>'3min'
             ],
             [
                'game_type'=>'n_powerball_ladder',
                'type'=>'5min'
             ],
             [
                'game_type'=>'n_powerball_ladder',
                'type'=>'3min'
             ],
             [
                'game_type'=>'all_games',
                'type'=>'all'
             ],
        ];

        foreach ($maintain as $key => $value) {
            Maintain::create($value);
        }
    }
}
