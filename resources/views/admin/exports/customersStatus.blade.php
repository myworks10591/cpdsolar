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
            <th>Material Dispatch Date (1st Lot)</th>
            <th>Material Dispatch Date (2nd Lot)</th>
            <th>Installer Name</th>
            <th>Installation Date</th>
            <th>DCR Certificate</th>
            <th>Installation Indent</th>
            <th>Meter Installation</th>
            <th>Meter Configuration</th>
            <th>Installation Submission Operator</th>
            <th>Subsidy Receive Status (1st)</th>
            <th>Subsidy Receive Status (2nd)</th>
            <th>Warranty Certificate Download</th>
            <th>Warranty Certificate Delivery Operator</th>
            <th>Warranty Certificate Delivery Date</th>
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
                <td>{{ $customer->material_dispatch_date_first }}</td>
                <td>{{ $customer->material_dispatch_date_second }}</td>
                <td>{{ $customer->installer_name }}</td>
                <td>{{ $customer->installation_date }}</td>
                <td>{{ $customer->dcr_certificate }}</td>
                <td>{{ $customer->installation_indent}}</td>
                <td>{{ $customer->meter_installation }}</td>
                <td>{{ $customer->meter_configuration }}</td>
                <td>{{ $customer->installation_submission_operator_name }}</td>
                <td>{{ $customer->subsidy_receive_status_first }}</td>
                <td>{{ $customer->subsidy_receive_status_second }}</td>
                <td>{{ $customer->warranty_certificate_download }}</td>
                <td>{{ $customer->warranty_certificate_delivery_operator_name }}</td>
                <td>{{ $customer->warranty_certificate_delivery_date }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
