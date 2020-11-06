<?php

use Illuminate\Database\Seeder;

class PerformanceLocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timezone = \App\Models\Timezone::select('id')->where('name', 'UTC')->first();
        \App\Models\PerformanceLocation::insert(
            [
                [
                    'name' => 'W Lodgepole St Dillon',
                    'location' => '201 W Lodgepole St Dillon CO 80435',
                    'timezone_id' => $timezone->id
                ],
                [
                    'name' => 'Copper Road',
                    'location' => '209 Copper Road Copper Mountain CO 80443',
                    'timezone_id' => $timezone->id
                ],
                [
                    'name' => 'Ave and Roslyn',
                    'location' => '29th Ave and Roslyn St Denver CO 80238',
                    'timezone_id' => $timezone->id
                ],
                [
                    'name' => 'Lake Street Avon',
                    'location' => '1 Lake Street Avon CO 81620',
                    'timezone_id' => $timezone->id
                ],
                [
                    'name' => 'Benchmark RD and Main Street Mall',
                    'location' => 'Benchmark RD and Main Street Mall Avon CO 81620',
                    'timezone_id' => $timezone->id
                ],
                [
                    'name' => 'River Run Road',
                    'location' => '91 River Run Road Keystone CO 80435',
                    'timezone_id' => $timezone->id
                ],
                [
                    'name' => 'Ida Belle Drive',
                    'location' => '0164 Ida Belle Drive Keystone, CO 80435',
                    'timezone_id' => $timezone->id
                ],
                [
                    'name' => 'Argentine Court',
                    'location' => 'Argentine Court Keystone, CO 80435',
                    'timezone_id' => $timezone->id
                ],
                [
                    'name' => 'Sweet Water Rd Lone',
                    'location' => '8300 1/2 Sweet Water Rd Lone Tree CO 80124',
                    'timezone_id' => $timezone->id
                ],
                [
                    'name' => 'Commons ST Lone Tree',
                    'location' => '10075 Commons ST Lone Tree CO 80124',
                    'timezone_id' => $timezone->id
                ],
                [
                    'name' => 'Schwab Way Lone Tree',
                    'location' => '9899 Schwab Way Lone Tree, CO 80124',
                    'timezone_id' => $timezone->id
                ]
            ]
        );
    }
}
