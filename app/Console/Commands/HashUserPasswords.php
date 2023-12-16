<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class HashUserPasswords extends Command
{
    protected $signature = 'hash:user-passwords';
    protected $description = 'Hashes passwords for all users in the database';

    public function handle()
    {
        $this->info('Hashing user passwords...');

        // Fetch all users from the database
        $users = User::all();

        // Loop through each user and update the password
        foreach ($users as $user) {
            $user->password = bcrypt($user->password); // Replace with your actual attribute name
            $user->save();
        }

        $this->info('User passwords hashed successfully.');
    }
}
