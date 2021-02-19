<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Tipoff\Reviews\Mail\SnapshotTop;

class SendSnapshotTopEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:snapshottop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the weekly Top 25 snapshots of our competitors reviews';

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
        Mail::send(new SnapshotTop());
    }
}
