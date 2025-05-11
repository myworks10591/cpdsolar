<table>
    <thead>
        <tr>
            <th>Operator Name</th>
            <th>Group Name</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Total Amount</th>
            <th>Due Amount</th>
            <th>District</th>
            <th>Address</th>
            <th>Pincode</th>
            <th>Electricity Account ID</th>
            <th>Division Name</th>
            <th>KW</th>
            <th>Application Reference No</th>
            <th>Registration Date</th>
            <th>Jan Samarth /Cash/Ecofy</th>
            <th>Account Number</th>
            <th>Jan Samarth Bank Name</th>
            <th>Jan Samarth Bank Branch</th>
            <th>Jan Samarth IFSC Code</th>
            <th>Jan Samarth Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->operator_name }}</td>
                <td>{{ $customer->group_name }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->mobile_no }}</td>
                <td>{{ $customer->total_amount }}</td>
                <td>{{ $customer->total_amount - $customer->payments->sum('received_amount') }}</td>
                <td>{{ $customer->district }}</td>
                <td>{{ $customer->address }}</td>
                <td>{{ $customer->pincode }}</td>
                <td>{{ $customer->electric_account_id }}</td>
                <td>{{ $customer->division }}</td>
                <td>{{ $customer->kw }}</td>
                <td>{{ $customer->application_reference_no }}</td>
                <td>{{ $customer->registration_date }}</td>
                <td>{{ $customer->payment_mode }}</td>
                <td>{{ $customer->account_no }}</td>
                <td>{{ $customer->jan_samarth_bank_name }}</td>
                <td>{{ $customer->jan_samarth_bank_branch }}</td>
                <td>{{ $customer->jan_samarth_ifsc_code }}</td>
                <td>{{ $customer->jan_samarth_date }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
