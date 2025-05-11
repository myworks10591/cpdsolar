<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Group; // Add this import at the top of your controller
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function index()
        {
            $user = Auth::user();

            // Base query
            $customerQuery = Customer::query();
            $customerQueryPending = Customer::query();
            $paymentQuery = Payment::query();
                
            // Apply role-based filtering
            switch ($user->role) {
                case 'operator':
                    $customerQuery->where('customers.operator_id', $user->id);
                    $paymentQuery->whereHas('customer', function ($q) use ($user) {
                        $q->where('customers.operator_id', $user->id);
                    });
                    break;

                case 'group':
                    $customerQuery->where('customers.group_id', $user->group_id);
                    $paymentQuery->whereHas('customer', function ($q) use ($user) {
                        $q->where('customers.group_id', $user->group_id);
                    });
                    break;

                // 'admin' and 'manager' see all data — no filters
            }

            $totalCustomers = $customerQuery->count();
            $totalReceived =  $paymentQuery->sum('received_amount');
            $totalAmount =    $customerQuery->join('customer_statuses', 'customers.id', '=', 'customer_statuses.customer_id')
                                        ->where('customer_statuses.invoice_no','!=', 'NA')->sum('total_amount');
            
            $pendingInstallationQuery = Customer::join('customer_statuses', 'customers.id', '=', 'customer_statuses.customer_id')
                                    ->where('customer_statuses.invoice_no', '!=', 'NA')
                                    ->where('customer_statuses.installer_name', 'NA');
                                                            
            $pendingNetMeteringQuery = Customer::join('customer_statuses', 'customers.id', '=', 'customer_statuses.customer_id')
                                    ->where('customer_statuses.invoice_no', '!=', 'NA')
                                    ->where('customer_statuses.meter_installation', 'No')
                                    ->where('customer_statuses.installer_name','!=', 'NA');
                                
            $pendingOnlineInstallationQuery = Customer::join('customer_statuses', 'customers.id', '=', 'customer_statuses.customer_id')
                                        ->where('customer_statuses.invoice_no', '!=', 'NA')
                                        ->where('customer_statuses.installation_submission_operator_name', 'NA')
                                        ->where('customer_statuses.meter_installation', 'Yes');
                                        
            // Apply role-based filter
            if ($user->role === 'operator') {
                $pendingInstallationQuery->where('customers.operator_id', $user->id);
                $pendingNetMeteringQuery->where('customers.operator_id', $user->id);
                $pendingOnlineInstallationQuery->where('customers.operator_id', $user->id);
            } elseif ($user->role === 'group') {
                $pendingInstallationQuery->where('customers.group_id', $user->group_id);
                $pendingNetMeteringQuery->where('customers.group_id', $user->group_id);
                $pendingOnlineInstallationQuery->where('customers.group_id', $user->group_id);
            }   

            $PendingInstallation = $pendingInstallationQuery->count();
            $PendingNetMetering = $pendingNetMeteringQuery->count();
            $pendingOnlineInstallation = $pendingOnlineInstallationQuery->count();

            // Total due: Sum of customer.total_amount - payments.sum(amount)
            $customers = $customerQuery->withSum('payments', 'received_amount')->get();
            $totalDue = $totalAmount -  $totalReceived;
            if (!in_array($user->role, ['manager','admin'])) {
                $totalReceived = 00000;
            }
            return view('home', compact('totalCustomers', 'totalReceived', 'totalDue','PendingInstallation','PendingNetMetering','pendingOnlineInstallation'));
         
        }

  
}
