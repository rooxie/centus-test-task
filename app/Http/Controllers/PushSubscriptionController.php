<?php

namespace App\Http\Controllers;

use App\Http\Requests\PushSubscriptionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushSubscriptionController
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(PushSubscriptionRequest $request): JsonResponse
    {
        Auth::user()->updatePushSubscription(
            $request->input('subscription.endpoint'),
            $request->input('subscription.keys.p256dh'),
            $request->input('subscription.keys.auth')
        );

        return response()->json(['success' => true]);
    }
}
