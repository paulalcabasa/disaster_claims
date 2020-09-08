
<table>
    <thead style="font-weight:bold;">
        <tr>
            <th width="30">CS No.</th>
            <th width="30">VIN</th>
            <th width="30">Engine</th>
            <th width="30">Dealer Name</th>
            <th width="30">Invoice Date</th>
            <th width="30">Pullout Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row->cs_number }}</td>
            <td>{{ $row->vin }}</td>
            <td>{{ $row->engine_no }}</td>
            <td>{{ $row->account_name }}</td>
            <td>{{ $row->invoice_date }}</td>
            <td>{{ $row->pullout_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
