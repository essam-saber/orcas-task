<?php

namespace App\Console\Commands;

use App\Services\UserService;
use Illuminate\Console\Command;

/**
 * Class FetchUsersCommand
 * @package App\Console\Commands
 */
class FetchUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the new users';

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
     * @param UserService $userService
     */
    public function handle(UserService $userService): void
    {
        $userService->storeUsers();
    }
}
