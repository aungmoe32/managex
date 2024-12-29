<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class InitializeUserStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initialize-user-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $stats = [
                'favourites' => $user->favourites()->count()
            ];
            Redis::hmset("user:{$user->id}:stats", $stats);
        }
    }
}
