<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Group; // Add this import at the top of your controller

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function rolePermission($role){
        if (!in_array($role, ['admin'])) {
            abort(403, 'Access Denied');
        }
   }
    public function index()
    {
        //
        $this->rolePermission(Auth::user()->role);
        $payments = Payment::with(['customer', 'group'])->get();
        return view('admin.payments.index', compact('payments'));
    }
    public function create()
    {
        // $customers = Customer::all();
        $this->rolePermission(Auth::user()->role);
         $customers = Customer::with('group')->get();
        //  dd($customers);
        $groups = Group::all();
        return view('admin.payments.create', compact('customers', 'groups'));
    }

    public function store(Request $request)
    {
        $this->rolePermission(Auth::user()->role);
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'received_amount' => 'required|numeric',
            'payment_mode' => 'required',
            'payment_received_date' => 'required|date',
        ]);

        $customer = Customer::findOrFail($request->customer_id);
        $totalAmount = $customer->total_amount;
        $dueAmount = $totalAmount - $request->received_amount;

        Payment::create([
            'customer_id' => $request->customer_id,
            'received_amount' => $request->received_amount,
            'payment_mode' => $request->payment_mode,
            'payment_received_date' => $request->payment_received_date,
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Payment Recorded Successfully!');
    }

    public function edit($id)
    {
        $this->rolePermission(Auth::user()->role);
        $payment = Payment::with(['customer', 'group'])->findOrFail($id);
        $customers = Customer::all();
        $groups = Group::all();
        return view('admin.payments.edit', compact('payment', 'customers', 'groups'));
    }

    public function update(Request $request, $id)
    {
        $this->rolePermission(Auth::user()->role);
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'received_amount' => 'required|numeric',
            'payment_mode' => 'required',
            'payment_received_date' => 'required|date',
        ]);

        $payment = Payment::findOrFail($id);
        $customer = Customer::findOrFail($request->customer_id);
       
        $payment->update([
            'customer_id' => $request->customer_id,
            'received_amount' => $request->received_amount,
            'payment_mode' => $request->payment_mode,
            'payment_received_date' => $request->payment_received_date,
        ]);
        
        return redirect()->route('admin.payments.index')->with('success', 'Payment Updated Successfully!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Payment Deleted Successfully!');
    }
}
