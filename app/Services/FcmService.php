<?php

namespace App\Services;

use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\WebPushConfig;

class FcmService
{
    public function __construct(private Messaging $messaging) {}

    public function sendToTokens(array $tokens, string $title, string $body, array $data = [], ?string $clickAction = null): array
    {
        $icon  = $data['icon']  ?? url('/icon-192.png');
        $image = $data['image'] ?? null;

        // notification + webpush both
        $notification = Notification::create($title, $body, $icon);
        if ($clickAction) {
            $data['click_action'] = $clickAction; // SW uses this
        }

        $webPush = WebPushConfig::fromArray([
            'fcm_options' => [
                'link' => $clickAction ?? url('/'), // click fallback (if SW skip)
            ],
            'notification' => array_filter([
                'title' => $title,
                'body'  => $body,
                'icon'  => $icon,
                'image' => $image,
            ]),
        ]);

        $message = CloudMessage::new()
            ->withNotification($notification)
            ->withData($data)          // strings only
            ->withWebPushConfig($webPush);

        $report = $this->messaging->sendMulticast($message, $tokens);

        // (optional) invalid tokens clean
        foreach ($report->failures()->getItems() as $f) {
            $msg = $f->error()->getMessage();
            $tok = $f->target()->value();
            if (str_contains($msg, 'NotRegistered') || str_contains($msg, 'InvalidRegistration')) {
                \App\Models\CustomerFcmToken::where('token', $tok)->delete();
            }
        }

        return [
            'success' => $report->successes()->count(),
            'failure' => $report->failures()->count(),
        ];
    }
}
