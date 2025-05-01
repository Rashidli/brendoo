<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;

class SubscriptionController extends Controller
{

    public function index()
    {

        $subscriptions = Subscription::query()->orderByDesc('id')->paginate(10);
        return view('admin.subscriptions.index', compact('subscriptions'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {

        $subscription->delete();
        return redirect()->route('subscriptions.index')->with('message', 'Subscription deleted successfully');

    }

}
