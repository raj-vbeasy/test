<?php

use Illuminate\Database\Seeder;

class TimezonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timezones = [];
        foreach (timezone_identifiers_list() as $timezone) {
            $timezones[] = ['name' => $timezone];
        }
        \App\Models\Timezone::insert($timezones);
    }
}
