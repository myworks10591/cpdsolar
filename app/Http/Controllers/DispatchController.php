<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Group; // Add this import at the top of your controller
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Dispatch;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DispatchController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Dispatch::with(['customer'])
            ->orderBy('dispatch_date', 'desc');

        if ($user->role === 'operator') {
            $query->whereHas('customer', function ($q) use ($user) {
                $q->where('operator_id', $user->id);
            });
        } elseif ($user->role === 'group') {
            $query->whereHas('customer', function ($q) use ($user) {
                $q->where('group_id', $user->group_id);
            });
        }

        $dispatches = $query->get();

        return view('admin.dispatches.index', compact('dispatches'));
    }

    public function create()
    {
        
        $customers = Customer::select('customers.id', 'customers.name')
                            ->join('customer_statuses', 'customers.id', '=', 'customer_statuses.Customer_id')
                            ->where('customer_statuses.invoice_no', '!=', 'NA')
                            ->whereNotIn('customers.id', function ($query) {
                                $query->select('customer_id')->from('dispatches');
                            })
                            ->orderby('customers.name', 'asc')
                            ->get();
        $products = Product::all();
        return view('admin.dispatches.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'customer_id' => 'required',
            // 'product_name' => 'required',
            'dispatch_date' => 'required|date',
            'driver_name' => 'required',
            'van_number' => 'required',
            'driver_mobile' => 'required',
            'status' => 'required',
        ]);
        // dd($request->customer_id);
        $dispatch = Dispatch::create([
            'dispatch_number' => $this->generateDispatchNumber(),
            'customer_id' => $request->customer_id,
            // 'product_name' => $request->product_name,
            'dispatch_date' => $request->dispatch_date,
            'driver_name' => $request->driver_name,
            'van_number' => $request->van_number,
            'driver_mobile' => $request->driver_mobile,
            'status' => $request->status,
            'dispatched_by' => Auth::id(),
            'remarks' => $request->remarks,
        ]);


        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['product_name']);

            if ($product->stock < $productData['quantity']) {
                return redirect()->back()
                ->withInput()
                ->with('error', "Insufficient stock for product: {$product->name}");
            }

            // Subtract the stock
            $product->stock -= $productData['quantity'];
            $product->save();

            $dispatch->products()->create([
                'product_name' => $productData['product_name'],
                'quantity' => $productData['quantity'],
            ]);
        }

        

        return redirect()->route('admin.dispatches.index')->with('success', 'Dispatch created successfully.');
    }

    public function edit(Dispatch $dispatch)
{
    $dispatch = Dispatch::with('products')->findOrFail($dispatch->id);

    $customers = Customer::select('customers.id', 'customers.name')
        ->join('customer_statuses', 'customers.id', '=', 'customer_statuses.Customer_id')
        ->where('customer_statuses.invoice_no', '!=', 'NA')
        ->whereNotIn('customers.id', function ($query) use ($dispatch) {
            $query->select('customer_id')
                  ->from('dispatches')
                  ->where('customer_id', '!=', $dispatch->customer_id); // changed to != to exclude others
        })
        ->orderBy('customers.name', 'asc')
        ->get();

    $productsArr = Product::all();

    return view('admin.dispatches.edit', compact('dispatch', 'customers', 'productsArr'));
}


public function update(Request $request, Dispatch $dispatch)
{
    $request->validate([
        'customer_id' => 'required',
        'dispatch_date' => 'required|date',
        'driver_name' => 'required',
        'van_number' => 'required',
        'driver_mobile' => 'required',
        'status' => 'required',
    ]);

    try {
        // Update dispatch data
        $dispatch->update([
            'customer_id' => $request->customer_id,
            'dispatch_date' => $request->dispatch_date,
            'driver_name' => $request->driver_name,
            'van_number' => $request->van_number,
            'driver_mobile' => $request->driver_mobile,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        // Get IDs of products from form
        $submittedProductIds = collect($request->products)->pluck('id')->filter()->toArray();

        // Delete removed products
        $dispatch->products()->whereNotIn('id', $submittedProductIds)->delete();

        // Loop through submitted products
        foreach ($request->products as $productData) {
            $product = Product::find($productData['product_name']); // product_name holds product_id

            if (!$product) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Product not found.');
            }

            // Check stock availability
            if ($product->stock < $productData['quantity']) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Insufficient stock for product: {$product->name}");
            }

            // Deduct stock
            $product->stock -= $productData['quantity'];
            $product->save();

            if (isset($productData['id'])) {
                // Update existing dispatch product
                $existingProduct = $dispatch->products()->where('id', $productData['id'])->first();
                if ($existingProduct) {
                    $existingProduct->update([
                        'product_name' => $productData['product_name'],
                        'quantity' => $productData['quantity'],
                    ]);
                }
            } else {
                // Create new dispatch product
                $dispatch->products()->create([
                    'product_name' => $productData['product_name'],
                    'quantity' => $productData['quantity'],
                ]);
            }
        }

        return redirect()->route('admin.dispatches.index')->with('success', 'Dispatch updated successfully.');

    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', "Error on line " . $e->getLine() . ": " . $e->getMessage());
    }
}


    public function destroy(Dispatch $dispatch)
    {
        $dispatch->delete();
        return redirect()->route('admin.dispatches.index')->with('success', 'Dispatch deleted successfully.');
    }

    public function export()
    {
        return Excel::download(new DispatchesExport, 'dispatches.xlsx');
    }
    protected function generateDispatchNumber()
    {
        $prefix = 'CPD-';
        $latestId = Dispatch::max('id') + 1;
        return $prefix . str_pad($latestId, 5, '0', STR_PAD_LEFT);
    }
}