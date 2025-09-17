<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerFcmToken;
use App\Services\FcmService;
use Illuminate\Http\Request;

class PushController extends Controller
{
    // GET form
    public function create()
    {
        return view('push-send');
    }

    // POST send (all or one)
    public function store(Request $request, FcmService $fcm)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:100',
            'body'        => 'required|string|max:500',
            'click'       => 'nullable|url',
            'customer_id' => 'nullable|integer|exists:customers,id',
            'icon'        => 'nullable|url',
            'image'       => 'nullable|url',
        ]);

        if (!empty($data['customer_id'])) {
            $tokens = Customer::with('fcmTokens')
                ->find($data['customer_id'])
                ?->fcmTokens->pluck('token')->all() ?? [];
        } else {
            $tokens = CustomerFcmToken::pluck('token')->all();
        }

        if (!$tokens) {
            return back()->with('error', 'No tokens found.');
        }

        $res = $fcm->sendToTokens(
            $tokens,
            $data['title'],
            $data['body'],
            [
                'icon'  => $data['icon']  ?? url('/icon-192.png'),
                'image' => $data['image'] ?? '',
            ],
            $data['click'] ?? url('/')
        );

        return back()->with('status', "Sent: {$res['success']} success / {$res['failure']} failed.");
    }
}
