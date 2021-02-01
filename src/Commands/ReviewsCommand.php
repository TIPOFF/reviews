<?php

namespace Tipoff\Reviews\Commands;

use Illuminate\Console\Command;

class ReviewsCommand extends Command
{
    public $signature = 'reviews';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
