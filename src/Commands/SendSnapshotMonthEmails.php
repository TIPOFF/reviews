<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Tipoff\Locations\Models\Market;
use Tipoff\Reviews\Mail\SnapshotMonth;

class SendSnapshotMonthEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:snapshotmonth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the monthly snapshots of our competitors reviews';

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
        $markets = Market::where('corporate', 1)->get();
        foreach ($markets as $market) {
            Mail::send(new SnapshotMonth($market));
        }
    }
}
