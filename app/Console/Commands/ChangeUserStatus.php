<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ChangeUserStatus extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:status {email} {status : active or inactive}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change user status to active or inactive';

    /**
     * Execute the console command.
     */
    public function handle() {
        $email = $this->argument('email');
        $status = $this->argument('status');

        if (!in_array($status, ['active', 'inactive'])) {
            $this->error('Status must be either "active" or "inactive"');
            return 1;
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found");
            return 1;
        }

        $oldStatus = $user->status;
        $user->update(['status' => $status]);

        $this->info("User {$user->name} ({$email}) status changed from {$oldStatus} to {$status}");

        return 0;
    }
}
