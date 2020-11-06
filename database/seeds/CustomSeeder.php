<?php

use Illuminate\Database\Seeder;

class CustomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = File::allFiles('/var/www/html/vbeasy/peak-mike/new db/GigSaladData/Data');
        $insertArr = [];
        foreach ($files as $file) {
            $content = json_decode($file->getContents(), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                foreach ($content as $key => $item) {
                    if ($item) {
                        if (is_array($item)) {
                            $content[$key] = json_encode($item);
                        }
                    } else {
                        $content[$key] = null;
                    }
                }
                array_push($insertArr, $content);
            }
        }
        foreach (array_chunk($insertArr, 1000) as $item) {
            DB::connection('eventAlliance')
                ->table('gig_salad_artists')
                ->insert($item);
        }
    }
}
