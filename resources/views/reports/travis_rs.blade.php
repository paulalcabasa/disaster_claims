<table>
    <thead style="font-weight:bold;">
        <tr>
            <th width="30">Customer</th>
            <th width="100">Address</th>
            <th width="30">Unit Model</th>
            <th width="30">CS No.</th>
            <th width="30">Engine</th>
            <th width="30">VIN</th>
            <th width="30">Dealer Name</th>
            <th width="30">Delivery Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row->customer }}</td>
            <td>{{ $row->addr_line_1 . ' ' . $row->addr_line_2 . ' ' . $row->city . ' ' . $row->province }}</td>
            <td>{{ $row->model }}</td>
            <td>{{ $row->cs_no }}</td>
            <td>{{ $row->engine_no }}</td>
            <td>{{ $row->vin }}</td>
            <td>{{ $row->dealer }}</td>
            <td>{{ $row->delivery_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
