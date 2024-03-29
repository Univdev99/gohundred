<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;

class SubscriptionController extends Controller
{

    public function create(Request $request, Plan $plan)
    {
        $plan = Plan::findOrFail($request->get('plan'));

        $user = $request->user();
        $paymentMethod = $request->paymentMethod;


        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);
        $request->user()->newSubscription('main', $plan->stripe_plan)
            ->create($paymentMethod, [
                'email' => $user->email,
            ]);

        // session()->put(['code' => 'success', 'message' => "Your plan subscribed successfully!"]);
        // $user->active = 1;
        $user->payment_status = "Linked with Stripe";
        $user->save();

        if ($user->active == 1 ) {
            return redirect()->route('dashboard')->withSuccessMessage('Your plan subscribed successfully!');
        }
        return redirect()->route('trial');
    }

    public function trial(Request $request)
    {
        if(\Auth::user()->active == 0){
            return view('plans.wait', ["result" => "fail"]);
        }
        return view('plans.wait', ["result" => "success"]);
    }
}
