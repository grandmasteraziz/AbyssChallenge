<?php

namespace App\Console\Commands;

use App\Models\Media;
use Illuminate\Console\Command;

class DeleteOldMediaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteoldmedia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete 30 days old records each hour';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $medias = Media::whereDate('created_at', '<=', now()->subDays(30))->delete();

        return Command::SUCCESS;
    }
}
