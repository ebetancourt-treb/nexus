<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionManagementController extends Controller
{
    public function index(Request $request): View
    {
        $query = Subscription::with(['tenant', 'plan'])->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($request->input('expiring')) {
            $query->where('status', 'trialing')
                ->whereBetween('trial_ends_at', [now(), now()->addDays(7)]);
        }

        $subscriptions = $query->paginate(25)->withQueryString();
        $plans = Plan::orderBy('sort_order')->get();

        return view('superadmin.subscriptions.index', compact('subscriptions', 'plans'));
    }

    public function changePlan(Request $request, Subscription $subscription): RedirectResponse
    {
        $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        $newPlan = Plan::find($request->plan_id);
        $subscription->update([
            'plan_id' => $newPlan->id,
            'status' => 'active',
        ]);

        return back()->with('success', "Plan cambiado a {$newPlan->name} para {$subscription->tenant->company_name}.");
    }

    public function extendTrial(Subscription $subscription): RedirectResponse
    {
        if ($subscription->status !== 'trialing') {
            return back()->withErrors(['error' => 'Solo se puede extender trials activos.']);
        }

        $subscription->update([
            'trial_ends_at' => $subscription->trial_ends_at->addDays(7),
        ]);

        return back()->with('success', "Trial extendido 7 días para {$subscription->tenant->company_name}.");
    }
}
