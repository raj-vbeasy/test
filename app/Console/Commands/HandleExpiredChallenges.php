<?php

namespace App\Console\Commands;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;

class HandleExpiredChallenges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'challenges:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle Expired Challenges';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = Carbon::now()->format('Y-m-d H:i:s');
        $events = Event::whereChallengeExpired(0)->whereNotNull('challenge')->whereRaw(
            "STR_TO_DATE(JSON_EXTRACT(challenge, '$.end_at'), '\"%Y-%m-%d %H:%i:%s\"') < '{$currentDate}'"
        )->with('artists')->has('artists')->get();

        foreach ($events as $event) {
            foreach ($event->artists as $artist) {
                // first hold position
                if ($artist->pivot->status === 12 && $artist->pivot->hold_position === 2) {
                    $event->artists()->updateExistingPivot($artist->id, ['type' => 'historical']);
                } else if (in_array($artist->pivot->hold_position, [3, 4, 5, 6])) {
                    $event->artists()->updateExistingPivot($artist->id, ['hold_position' => $artist->pivot->hold_position - 1]);
                }
            }
            $event->fill(['challenge_expired' => 1])->save();
        }
        return 1;
    }
}
