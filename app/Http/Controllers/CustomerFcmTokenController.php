<?php

namespace App\Http\Controllers;

use App\Models\CustomerFcmToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerFcmTokenController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'token'  => 'required|string',
            'device' => 'nullable|string|max:255',
        ]);

        $customerId = Auth::guard('customer')->id(); // <-- IMPORTANT
        $row = CustomerFcmToken::updateOrCreate(
            ['token' => $data['token']],
            [
                'customer_id' => $customerId,
                'device'      => $data['device'] ?? null,
                'last_used_at' => now(),
            ]
        );
        return response()->json(['ok' => true, 'id' => $row->id]);
    }
}
