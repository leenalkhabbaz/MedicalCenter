<?php

namespace App\Console\Commands;

use App\Services\NotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
class SendNotification extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily notifications to users';

    /**
     * Execute the console command.
     */

     protected $notificationService;

     public function __construct(NotificationService $notificationService)
    {
        parent::__construct();

        $this->notificationService = $notificationService;
    }
    public function handle()
    {
        try {
            $this->notificationService->sendDailyNotifications();
            Log::info('Daily notifications sent successfully.');
        } catch (\Exception $e) {
            Log::error('Error sending daily notifications: ' . $e->getMessage());
        }

    }
}
