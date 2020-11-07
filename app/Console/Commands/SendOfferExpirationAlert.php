<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\User;
use App\Notifications\ArtistStatusUpdate;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendOfferExpirationAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:offer-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email alert to artists about their upcoming offer expiration';

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
        $artists = \DB::table('artist_event')
            ->selectRaw("artist_event.email, events.name as event_name, artists.name")
            ->join('events', 'artist_event.event_id', '=', 'events.id')
            ->join('artists', 'artist_event.artist_id', '=', 'artists.id')
            ->where('artist_event.status', 7)
            ->where(
                \DB::raw('DATE(artist_event.offer_expiration_date)'),
                '=',
                Carbon::now()->addDays(2)->format('Y-m-d')
            )->get();

        foreach ($artists as $artist) {
            ((new User())->fill([
                'email' => $artist->email,
                'name' => $artist->name
            ]))->notify(
                new ArtistStatusUpdate(
                    'Your offer for event <b>' . $artist->event_name . '</b> is expiring in 2 days'
                )
            );
            echo "Email sent to {$artist->name} for {$artist->event_name}\n";
        }
        return 1;
    }
}
