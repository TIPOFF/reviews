<?php

namespace DrewRoberts\Reporting\Commands;

use Illuminate\Console\Command;

/**
 * Class TestCommand
 *
 * @package DrewRoberts\Reporting\Commands
 */
class TestCommand extends Command
{

    /**
     * @var string
     */
    public $signature = 'test-command';

    /**
     * @var string
     */
    public $description = 'My command';

    /**
     *
     */
    public function handle()
    {
        $this->comment('All done');
    }
}
