<?php
namespace App\Http\Controllers;

use App\Models\CustomerStatus;
use App\Models\Customer;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerStatusController extends Controller
{

    public function rolePermission($role){
        if (!in_array($role, ['manager', 'admin'])) {
            abort(403, 'Access Denied');
        }
   }
    public function index()
    {

        $user = auth()->user(); // Get logged-in user

        $statuses = CustomerStatus::with(['customer', 'group'])
            ->when($user->role === 'group', function ($query) use ($user) {
                // Group users see only customers in their assigned group
                $query->whereHas('group', function ($q) use ($user) {
                    $q->where('id', $user->group_id);
                });
            })
            ->when($user->role === 'operator', function ($query) use ($user) {
                // Operators see only customers they registered
                $query->whereHas('customer', function ($q) use ($user) {
                    $q->where('operator_id', $user->id); // Ensure 'created_by' exists in customers table
                });
            })
            ->get();
        // $statuses = CustomerStatus::with(['customer', 'group'])->get();


        return view('admin.customer_statuses.index', compact('statuses'));
    }

    public function create()
    {
        $this->rolePermission(Auth::user()->role);
        $groups = Group::all();
        return view('admin.customer_statuses.create', compact('groups'));
    }

    public function store(Request $request)
    {
        
        $this->rolePermission(Auth::user()->role);
        $request->validate([
            'group_id' => 'required',
            'customer_id' => 'required',
            'invoice_no' => 'required|unique:customer_statuses',
            'installer_name' => 'required',
            'installation_submission_operator_name' => 'required',
        ]);

        CustomerStatus::create($request->all());

        return redirect()->route('admin.customer_statuses.index')->with('success', 'Customer status added successfully!');
    }

    public function edit(CustomerStatus $customerStatus)
    {
        $this->rolePermission(Auth::user()->role);
        $groups = Group::all();
        $customers = Customer::where('group_id', $customerStatus->group_id)->get(); // Fetch customers based on group_id
        return view('admin.customer_statuses.edit', compact('customerStatus', 'groups','customers'));
    }

    public function update(Request $request, CustomerStatus $customerStatus)
    {
        //dd($request->all());
        $this->rolePermission(Auth::user()->role);
        $request->validate([
            // 'group_id' => 'required',
            // 'customer_id' => 'required',
            // 'invoice_no' => 'required|unique:customer_statuses,invoice_no,' . $customerStatus->id,
            // 'installer_name' => 'required',
            // 'installation_submission_operator_name' => 'required',
        ]);
        $id =  $customerStatus->id;
        if($request->invoice_no != 'NA'){
            $exists = CustomerStatus::where('invoice_no', $request->invoice_no)
            ->where('id', '!=', $id) // Exclude current record
            ->exists();
            // $count = CustomerStatus::where('invoice_no', $request->invoice_no)->count();
            if ($exists) {
                return redirect()->back()->with('error', 'Invoice number already exists !');
            }
        }
        


        $customerStatus->update($request->all());

        return redirect()->route('admin.customer_statuses.index')->with('success', 'Customer status updated successfully!');
    }

    public function destroy(CustomerStatus $customerStatus)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }
        $customerStatus->delete();
        return redirect()->route('admin.customer_statuses.index')->with('success', 'Customer status deleted successfully!');
    }
    public function show($id)
    {
        $customerStatus = CustomerStatus::with(['customer', 'group'])->findOrFail($id);
        return view('admin.customer_statuses.view', compact('customerStatus'));
    }
    
    public function syncCustomers(Request $request)
    {
         if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }
        $customerId = $request->customer_id;
        $exists = CustomerStatus::where('customer_id', $customerId)->exists();

        if ($exists) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Customer status already exists.'
            ], 409);
        }
        $customer = Customer::findOrFail($customerId);
    
        CustomerStatus::create([
            'customer_id' => $customerId,
            'group_id' => $customer->group_id,
            'invoice_no' => "NA",
            'material_dispatch_date_first' => null,
            'material_dispatch_date_second' => null,
            'installer_name' => "NA",
            'installation_date' => null,
            'dcr_certificate' => 'No',
            'installation_indent' => 'No',
            'meter_installation' => 'No',
            'meter_configuration' => 'No',
            'installation_submission_operator_name' => "NA",
            'subsidy_receive_status_first' => 'No',
            'subsidy_receive_status_second' => 'No',
            'warranty_certificate_download' => 'No',
            'warranty_certificate_delivery_operator_name' => "NA",
            'warranty_certificate_delivery_date' => null,
        ]);
        return response()->json(['message' => 'Customer added successfully']);
    }
}



?>