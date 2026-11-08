<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutoRejectReservasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservasi:auto-reject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tolak reservasi dengan status Menunggu lebih dari 15 menit.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $updated = DB::table('reservasi')
            ->where('status', 'Menunggu')
            ->where('created_at', '<', now()->subMinutes(15))
            ->update(['status' => 'Ditolak']);

        $this->info("Auto-reject completed: $updated reservasi updated.");

        return 0;
    }
}
