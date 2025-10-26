<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DowngradeExpiredUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:downgrade-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically downgrade paid members whose subscription has expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired paid members...');

        // Find all paid members with expired subscriptions
        $expiredUsers = User::where('role', 'paid_member')
            ->whereNotNull('paid_expiration')
            ->where('paid_expiration', '<', now())
            ->get();

        if ($expiredUsers->isEmpty()) {
            $this->info('No expired paid members found.');
            return Command::SUCCESS;
        }

        $count = 0;

        foreach ($expiredUsers as $user) {
            // Downgrade to free member
            $user->update([
                'role' => 'free_member',
                'paid_expiration' => null,
            ]);

            $this->line("Downgraded user: {$user->name} ({$user->email})");
            $count++;
        }

        $this->info("Successfully downgraded {$count} expired paid member(s) to free tier.");

        return Command::SUCCESS;
    }
}
