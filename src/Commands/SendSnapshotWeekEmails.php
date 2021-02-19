<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Commands;

use Tipoff\Reviews\Mail\SnapshotWeek;
use Tipoff\Locations\Models\Market;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendSnapshotWeekEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:snapshotweek';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the weekly snapshots of our competitors reviews';

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
     * @return void
     */
    public function handle()
    {
        $markets = Market::where('corporate', 1)->where('id', '<>', 8)->get();
        foreach ($markets as $market) {
            Mail::send(new SnapshotWeek($market));
        }
    }
}
