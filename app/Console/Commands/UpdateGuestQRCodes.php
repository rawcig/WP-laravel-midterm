<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateGuestQRCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guests:update-qr-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update QR codes for all guests to unique ones';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $guests = \App\Models\Guest::all();
        
        $this->info('Updating QR codes for ' . $guests->count() . ' guests...');
        
        $bar = $this->output->createProgressBar($guests->count());
        $bar->start();
        
        foreach ($guests as $guest) {
            $qrData = 'EVENT-' . $guest->event_id . '-GUEST-' . $guest->id . '-' . time();
            $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($qrData);
            $guest->update(['qr_code' => $qrCodeUrl]);
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('QR codes updated successfully!');
    }
}
