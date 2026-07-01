<?php

namespace Danielthalmann\AuthUi\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:create-user {username} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $user = new User();
            $user->name = $this->argument('username');
            $user->email = $this->argument('email');
            $user->password = Hash::make($this->argument('password'));
            $user->save();
        } else {
            $user->password = Hash::make($this->argument('password'));
            $user->save();
        }

    }
}
