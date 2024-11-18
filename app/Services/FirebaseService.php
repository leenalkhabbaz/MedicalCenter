<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class FirebaseService
{

    protected $messaging;

    public function __construct()
    {

        $serviceAccountPath = storage_path('');

        $factory = (new Factory)->withServiceAccount($serviceAccountPath);

        $this->messaging = $factory->createMessaging();
    }



    public function sendNotification($tokens, $title, $body)
    {
        // Create a message for multicast
        $message = CloudMessage::new()
            ->withNotification(['title' => $title, 'body' => $body,]);

        // Send multicast message
        $report = $this->messaging->sendMulticast($message, $tokens);
        Log::info('tokens:', [$tokens]);
        // Return the report for further processing or logging
        return $report;
    }



    public function sendTestNotification($token)
    {
        $title = 'Test Notification';
        $body = 'This is a test notification to confirm your setup is working!';
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(['title' => $title, 'body' => $body]);

        try {
            $this->messaging->send($message);
            return 'Notification sent successfully!';
        } catch (\Exception $e) {
            return 'Error sending notification: ' . $e->getMessage();
        }
    }
}
