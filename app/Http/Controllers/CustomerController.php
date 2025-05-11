<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Group; // Add this import at the top of your controller
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Modal;


class CustomerController extends Controller
{
    // Display list of customers
     public function rolePermission($role){
        if (!in_array($role, ['manager', 'admin','operator'])) {
            abort(403, 'Access Denied');
        }
   }
    public function index()
    {
          // Get modal numbers for the dropdown
        $user = Auth::user();
        if (in_array($user->role, ['manager', 'admin'])) {
            $customers = Customer::with(['group', 'user'])
                                    ->orderby('id','desc')
                                    ->get();
        } elseif ($user->role === 'operator') {
            $customers = Customer::with(['group', 'user'])
                ->where('operator_id', $user->id)
                ->orderby('id','desc')
                ->get();
                
        } elseif ($user->role === 'group') {
            $customers = Customer::with(['group', 'user'])
                ->where('group_id', $user->group_id)
                ->orderby('id','desc')
                ->get();
        } else {

            $customers = collect(); // Empty collection for unauthorized users
        }
         
         // Calculate due amount for each customer
         $customers = $customers->map(function ($customer) {
            $totalReceived = Payment::where('customer_id', $customer->id)->sum('received_amount');
            $customer->due_amount = $customer->total_amount - $totalReceived;
             if($customer->due_amount <= 0){
                $customer->due_amount = 0;
            }
            return $customer;
        });

        return view('admin.customers.index', compact('customers'));
    }

    // Show create customer form
    public function create()
    {
        $this->rolePermission(Auth::user()->role);
        $modalNumbers = Modal::getModalNumbers();
        $groups = Group::all();
        return view('admin.customers.create', compact('groups','modalNumbers'));
    }

    // Store new customer
    public function store(Request $request)
{
    $this->rolePermission(Auth::user()->role);
    $request->validate([
        'group_id' => 'required|exists:groups,id',
        'district' => 'required|string',
        'name' => 'required|string',
        'mobile_no' => 'required|string',
        'email' => 'nullable|email',
        'account_no' => 'required|string',
        'jan_samarth_bank_branch' => 'required|string',
        'jan_samarth_ifsc_code' => 'required|string',
        'division' => 'required|string',
        'electric_account_id' => 'required|string',
        'address' => 'required|string',
        'registration_date' => 'required|date',
        'application_reference_no' => 'required|string',
        'kw' => 'required|numeric',
        'payment_mode' => 'required|string',
        // 'jan_samarth_date' => 'required|date',
        // 'document_submission_date' => 'required|date',
        'jan_samarth_bank_name' => 'nullable|string|max:255',
        'pincode' => 'nullable|string|max:10',
        'remarks' => 'nullable|string',
    ]);
    $data = $request->all();
    
    $data['operator_id'] = Auth::id();
    if($request->electric_account_id != 'NA'){
        $exists = Customer::where('electric_account_id', $request->electric_account_id)
        ->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Electric account id already exists !');
        }
    }
    Customer::create($data);

    return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully.');
}
    // Show the customer edit form
    public function edit($id)
    
    {
        $this->rolePermission(Auth::user()->role);
        $groups = Group::all();  // Get all groups from the database
        $modalNumbers = Modal::getModalNumbers();  // Get modal numbers for the dropdown
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer', 'groups','modalNumbers'));
    }

    // Update customer details
    public function update(Request $request, Customer $customer)
    {
        $this->rolePermission(Auth::user()->role);
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'district' => 'required|string',
            'name' => 'required|string',
            'mobile_no' => 'required|string',
            'email' => 'nullable|email',
            'account_no' => 'required|string',
            'jan_samarth_bank_branch' => 'required|string',
            'jan_samarth_ifsc_code' => 'required|string',
            'division' => 'required|string',
            'electric_account_id' => 'required|string',
            'address' => 'required|string',
            'registration_date' => 'required|date',
            'application_reference_no' => 'required|string',
            'kw' => 'required|numeric',
            'payment_mode' => 'required|string',
            // 'jan_samarth_date' => 'required|date',
            // 'document_submission_date' => 'required|date',
            'jan_samarth_bank_name' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'remarks' => 'nullable|string',
        ]);
        $data = $request->all();
        if (!in_array(Auth::user()->role, ['manager', 'admin'])) {
            $data['operator_id'] = Auth::id();
            }
            $id =  $customer->id;
            if($request->electric_account_id != 'NA'){
                $exists = Customer::where('electric_account_id', $request->electric_account_id)
                ->where('id', '!=', $id) // Exclude current record
                ->exists();
                if ($exists) {
                    return redirect()->back()->with('error', 'Electric account id already exists !');
                }
            }
        $customer->update($data);
        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully.');
    }
    

    // Delete a customer
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers.index');
    }
    public function getCustomers($group_id)
    {
        $customers = Customer::where('group_id', $group_id)->get();
        
        return response()->json($customers);
    }

    public  function getInstallationPending() {
        
        $user = auth()->user();

            $customerQuery = Customer::with(['group', 'payments'])
                ->whereHas('payments')
                ->where(function($q) {
                    $q->where('customer_statuses.invoice_no','!=', 'NA')
                    ->Where('customer_statuses.installer_name', 'NA');
                })
                ->leftJoin('customer_statuses', 'customers.id', '=', 'customer_statuses.customer_id')
                ->select('customers.*','customer_statuses.id as custid','customer_statuses.installer_name','customer_statuses.installation_date','customer_statuses.material_dispatch_date_second','customer_statuses.material_dispatch_date_first','customer_statuses.invoice_no','customer_statuses.updated_at as cust_updated_at','customer_statuses.updates_remarks');

            // Apply role-based filter
            if ($user->role === 'operator') {
                 $customerQuery->where('customers.operator_id', $user->id);
            } elseif ($user->role === 'group') {
                $customerQuery->where('customers.group_id', $user->group_id);
            } 
            $customers = $customerQuery->withSum('payments as payments_sum_received_amount', 'received_amount')->get();
            return view('admin.customer_statuses.installationpending', compact('customers'));
            

    }
    public  function getNetMetringPending() {
        
        $user = auth()->user();

            $customerQuery = Customer::with(['group', 'payments'])
                ->whereHas('payments')
                ->where(function($q) {
                    $q->where('customer_statuses.invoice_no','!=', 'NA')
                      ->Where('customer_statuses.meter_installation', 'NO')
                      ->where('customer_statuses.installer_name','!=', 'NA');
                })
                ->leftJoin('customer_statuses', 'customers.id', '=', 'customer_statuses.customer_id')
                ->select('customers.*','customer_statuses.id as cust_id','customer_statuses.installer_name','customer_statuses.installation_date','customer_statuses.installation_indent','customer_statuses.meter_installation','customer_statuses.invoice_no','customer_statuses.updated_at as cust_updated_at','customer_statuses.updates_remarks');

            // Apply role-based filter
            if ($user->role === 'operator') {
                 $customerQuery->where('customers.operator_id', $user->id);
            } elseif ($user->role === 'group') {
                $customerQuery->where('customers.group_id', $user->group_id);
            } 
            $customers = $customerQuery->withSum('payments as payments_sum_received_amount', 'received_amount')->get();
            return view('admin.customer_statuses.netMeteringpending', compact('customers'));
            
    }

    public  function getOnlineInstallationPending() {
        
        $user = auth()->user();

            $customerQuery = Customer::with(['group', 'payments'])
                ->whereHas('payments')
                ->where(function($q) {
                    $q->where('customer_statuses.invoice_no','!=', 'NA')
                      ->Where('customer_statuses.installation_submission_operator_name', 'NA')
                      ->where('customer_statuses.meter_installation', '!=' ,'No');
                      
                })
                ->leftJoin('customer_statuses', 'customers.id', '=', 'customer_statuses.customer_id')
                ->select('customers.*','customer_statuses.*','customer_statuses.updated_at as cust_updated_at','customer_statuses.id as cust_id');

            // Apply role-based filter
            if ($user->role === 'operator') {
                 $customerQuery->where('customers.operator_id', $user->id);
            } elseif ($user->role === 'group') {
                $customerQuery->where('customers.group_id', $user->group_id);
            } 
            $customers = $customerQuery->withSum('payments as payments_sum_received_amount', 'received_amount')->get();
            return view('admin.customer_statuses.onlineinstallationpending', compact('customers'));
            
    }


    function getListOfDueCustomer()  {
                    
            $user = auth()->user();
            $customersWithInvoice = Customer::select( 'customer_statuses.*','customers.*','customer_statuses.id as cust_id')
                ->join('customer_statuses', 'customers.id', '=', 'customer_statuses.customer_id')
                ->where('customer_statuses.invoice_no', '!=', 'NA');
            // Apply role-based filters
            if ($user->role === 'operator') {
                $customersWithInvoice->where('customers.operator_id', $user->id);
            } elseif ($user->role === 'group') {
                $customersWithInvoice->where('customers.group_id', $user->group_id);
            }

            $customers = $customersWithInvoice->get();
            // Map to calculate due and then filter
            $customers = $customers->map(function ($customer) {

                $totalReceived = Payment::where('customer_id', $customer->cust_id)->sum('received_amount');
                $customer->due_amount = max(0, $customer->total_amount - $totalReceived);
                // echo $customer->id."===".$customer->name."==="."$totalReceived"."==".$customer->due_amount."==";
                return $customer;
            })->filter(function ($customer) {
                return $customer->due_amount > 0;
            })->values(); // reset keys

            return view('admin.customer_statuses.DueCustomerList', compact('customers'));
    }

    function getListOfPaymentReceivedCustomer() {
        
        $user = auth()->user();
            $customersWithInvoice = Customer::select( 'customer_statuses.*','customers.*')
                ->join('customer_statuses', 'customers.id', '=', 'customer_statuses.customer_id')
                ->where('customer_statuses.invoice_no', '!=', 'NA');
            // Apply role-based filters
            if ($user->role === 'operator') {
                $customersWithInvoice->where('customers.operator_id', $user->id);
            } elseif ($user->role === 'group') {
                $customersWithInvoice->where('customers.group_id', $user->group_id);
            }

            $customers = $customersWithInvoice->get();
            // Map to calculate due and then filter
            $customers = $customers->map(function ($customer) {

                $totalReceived = Payment::where('customer_id', $customer->id)->sum('received_amount');
                $customer->total_received = $totalReceived;
                return $customer;
            })->values(); // reset keys

            return view('admin.customer_statuses.CustomerListPaymentReceived', compact('customers'));

    }

    function getListOfPendingCustomer()  {
                    
        $user = auth()->user();
        
            $customersWithInvoice = Customer::leftJoin('payments', 'customers.id', '=', 'payments.customer_id')
                                    ->whereNull('payments.customer_id') // Assuming payments table has an `id` column
                                    ->select('customers.*');
        // Apply role-based filters
        if ($user->role === 'operator') {
            $customersWithInvoice->where('customers.operator_id', $user->id);
        } elseif ($user->role === 'group') {
            $customersWithInvoice->where('customers.group_id', $user->group_id);
        }

        $customers = $customersWithInvoice->get();
        // Map to calculate due and then filter
        $customers = $customers->map(function ($customer) {

            $totalReceived = Payment::where('customer_id', $customer->id)->sum('received_amount');
            // dd($totalReceived);
            $customer->due_amount = max(0, $customer->total_amount - $totalReceived);
            // echo $customer->id."===".$customer->name."==="."$totalReceived"."==".$customer->due_amount."==";
            return $customer;
        })->filter(function ($customer) {
            return $customer->due_amount > 0;
        })->values(); // reset keys

        
        return view('admin.customer_statuses.PendingCustomerList', compact('customers'));
}

public  function getSupsidyPendingFirst() {
        
    $user = auth()->user();

        $customerQuery = Customer::with(['group', 'payments'])
            ->whereHas('payments')
            ->where(function($q) {
                $q->where('customer_statuses.invoice_no','!=', 'NA')
                ->Where('customer_statuses.subsidy_receive_status_first', 'NO')
                ->where('customer_statuses.installation_submission_operator_name','!=', 'NA');
            })
            ->leftJoin('customer_statuses', 'customers.id', '=', 'customer_statuses.customer_id')
            ->select('customers.*','customer_statuses.id as custid','customer_statuses.updated_at as cust_updated_at','customer_statuses.updates_remarks');

        // Apply role-based filter
        if ($user->role === 'operator') {
             $customerQuery->where('customers.operator_id', $user->id);
        } elseif ($user->role === 'group') {
            $customerQuery->where('customers.group_id', $user->group_id);
        } 
        $customers = $customerQuery->withSum('payments as payments_sum_received_amount', 'received_amount')->get();
        return view('admin.customer_statuses.PendingCustomerFirstSubsudi', compact('customers'));
        
}

public  function getSupsidyPendingSecond() {
        
    $user = auth()->user();

        $customerQuery = Customer::with(['group', 'payments'])
            ->whereHas('payments')
            ->where(function($q) {
                $q->where('customer_statuses.invoice_no','!=', 'NA')
                  ->Where('customer_statuses.subsidy_receive_status_second', 'NO')
                  ->where('customer_statuses.installation_submission_operator_name','!=', 'NA');
            })
            ->leftJoin('customer_statuses', 'customers.id', '=', 'customer_statuses.customer_id')
            ->select('customers.*','customer_statuses.id as custid','customer_statuses.updated_at as cust_updated_at','customer_statuses.updates_remarks');

        // Apply role-based filter
        if ($user->role === 'operator') {
             $customerQuery->where('customers.operator_id', $user->id);
        } elseif ($user->role === 'group') {
            $customerQuery->where('customers.group_id', $user->group_id);
        } 
        $customers = $customerQuery->withSum('payments as payments_sum_received_amount', 'received_amount')->get();
        return view('admin.customer_statuses.PendingCustomerSecondSubsudi', compact('customers'));
        
}

public  function getSupsidyFirst() {
        
    $user = auth()->user();

        $customerQuery = Customer::with(['group', 'payments'])
            ->whereHas('payments')
            ->where(function($q) {
                $q->where('customer_statuses.invoice_no','!=', 'NA')
                ->Where('customer_statuses.subsidy_receive_status_first', 'Yes')
                ->where('customer_statuses.installation_submission_operator_name','!=', 'NA');
            })
            ->leftJoin('customer_statuses', 'customers.id', '=', 'customer_statuses.customer_id')
            ->select('customers.*','customer_statuses.*','customer_statuses.updated_at as cust_updated_at','customer_statuses.id as cust_id');

        // Apply role-based filter
        if ($user->role === 'operator') {
             $customerQuery->where('customers.operator_id', $user->id);
        } elseif ($user->role === 'group') {
            $customerQuery->where('customers.group_id', $user->group_id);
        } 
        $customers = $customerQuery->withSum('payments as payments_sum_received_amount', 'received_amount')->get();
        return view('admin.customer_statuses.CustomerFirstSubsudi', compact('customers'));
        
}

public  function getSupsidySecond() {
        
    $user = auth()->user();

        $customerQuery = Customer::with(['group', 'payments'])
            ->whereHas('payments')
            ->where(function($q) {
                $q->where('customer_statuses.invoice_no','!=', 'NA')
                ->Where('customer_statuses.subsidy_receive_status_second', 'Yes')
                ->where('customer_statuses.installation_submission_operator_name','!=', 'NA');
            })
            ->leftJoin('customer_statuses', 'customers.id', '=', 'customer_statuses.customer_id')
            ->select('customers.*','customer_statuses.*','customer_statuses.updated_at as cust_updated_at','customer_statuses.id as cust_id');

        // Apply role-based filter
        if ($user->role === 'operator') {
             $customerQuery->where('customers.operator_id', $user->id);
        } elseif ($user->role === 'group') {
            $customerQuery->where('customers.group_id', $user->group_id);
        } 
        $customers = $customerQuery->withSum('payments as payments_sum_received_amount', 'received_amount')->get();
        return view('admin.customer_statuses.CustomerSecondSubsudi', compact('customers'));
        
}

public  function getPendingAccountNumber() {
        
    $user = auth()->user();

        $customerQuery = Customer::with(['group'])
            ->where(function($q) {
                $q->WhereIn('account_no', ['NA', 'N/A', 'na']);
                // ->where('customer_statuses.installation_submission_operator_name','!=', 'NA');
            })
            ->select('customers.*');

        // Apply role-based filter
        if ($user->role === 'operator') {
             $customerQuery->where('customers.operator_id', $user->id);
        } elseif ($user->role === 'group') {
            $customerQuery->where('customers.group_id', $user->group_id);
        } 
        $customers = $customerQuery->get();
        return view('admin.customers.PendingAccountNumber', compact('customers'));
        
}

}