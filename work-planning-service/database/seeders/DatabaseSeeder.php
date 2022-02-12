<?php

namespace Database\Seeders;

use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      // \App\Models\User::factory(10)->create();
        $this->loadShifts();
        //0-8
        $shift = Shift::getByInterval('0-8');
        User::createDefaultUser()->addShift($shift->id);
        $shift = Shift::getByInterval('16-24');
        // dd($shift->isCurrentShift());

    }

    function loadShifts(){
        $shifts = Shift::INTERVALS;
        foreach ($shifts as $interval=>$shift){
           Shift::addShift($interval);
        }
    }
}
