<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class CustomersExport implements FromView
{
    public function view(): View
    {
        $user = Auth::user();
        $query = Customer::with(['user', 'group', 'payments'])
            ->select(
                'customers.*',
                'users.name as operator_name',
                'groups.name as group_name'
            )
            ->leftJoin('users', 'customers.operator_id', '=', 'users.id')
            ->leftJoin('groups', 'customers.group_id', '=', 'groups.id');

            if ($user->role === 'operator') {
                $query->where('customers.operator_id', $user->id);
            } elseif ($user->role === 'group') {
                $query->where('customers.group_id', $user->group_id);
            }
            
            $customers = $query->get();

        return view('admin.exports.customers', compact('customers'));
    }
}

?>