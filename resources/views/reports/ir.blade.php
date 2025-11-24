<h4>Treasury Summary Report for CSDA</h4>
<h4></h4>
<table style="width: 100%;" class="table-striped">
    <thead>
        <tr style="background-color: #5B9BD5; color: #FFFFFF;">
            <th style="text-align: center; background-color: #5B9BD5; color: #FFFFFF;">No</th>
            <th style="text-align: center; background-color: #5B9BD5; color: #FFFFFF;">Store Code</th>
            <th style="text-align: center; background-color: #5B9BD5; color: #FFFFFF;">Store Name</th>
            <th style="text-align: center; background-color: #5B9BD5; color: #FFFFFF;">Sales Date</th>
            <th style="text-align: center; background-color: #5B9BD5; color: #FFFFFF;">Frequency <br> of Pick-up</th>
            <th style="text-align: center; background-color: #5B9BD5; color: #FFFFFF;">Cashier Name</th>
            <th style="text-align: center; background-color: #5B9BD5; color: #FFFFFF;">Shift</th>
            <th style="text-align: center; background-color: #5B9BD5; color: #FFFFFF;">POS</th>
            <th style="text-align: center; background-color: #5B9BD5; color: #FFFFFF;">CDR / Cash on Hand</th>
            <th style="text-align: center; background-color: #5B9BD5; color: #FFFFFF;">Discrepancy</th>
            <th style="text-align: center; background-color: #5B9BD5; color: #FFFFFF;">Status</th>
            <th style="text-align: center; background-color: #5B9BD5; color: #FFFFFF;">Treasury Remarks</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($grouped_details as $row)
            <tr>
                <td style="text-align: center;">{{ $row['RowNum'] }}</td>
                <td style="text-align: center;">{{ $row['LocationCode'] }}</td>
                <td style="text-align: center;">{{ $row['Location'] }}</td>
                <td style="text-align: center;">{{ $row['SalesDate'] }}</td>
                <td style="text-align: center;">{{ $row['Sched'] }}</td>
                <td style="text-align: left;">{{ $row['records'][0]->CashierName }}</td>
                <td style="text-align: center;">{{ $row['records'][0]->Shift }}</td>
                <td style="text-align: center;">{{ number_format($row['records'][0]->CDR, 2) }}</td>
                <td style="text-align: center;">{{ number_format($row['records'][0]->COH, 2) }}</td>
                <td
                    style="text-align: center; color: {{ $row['records'][0]->COH - $row['records'][0]->CDR > 0 ? 'blue' : 'red' }}">
                    {{ number_format($row['records'][0]->COH - $row['records'][0]->CDR, 2) }}</td>
                <td style="text-align: center;">{{ $row['records'][0]->Status }}</td>
                <td style="text-align: center;">{{ $row['records'][0]->Remarks }}</td>
            </tr>
            @foreach ($row['records'] as $key => $r)
                @if ($key > 0)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: left;">{{ $r->CashierName }}</td>
                        <td style="text-align: center;">{{ $r->Shift }}</td>
                        <td style="text-align: center;">{{ number_format($r->CDR, 2) }}</td>
                        <td style="text-align: center;">{{ number_format($r->COH, 2) }}</td>
                        <td style="text-align: center; color: {{ $r->COH - $r->CDR > 0 ? 'blue' : 'red' }}">
                            {{ number_format($r->COH - $r->CDR, 2) }}</td>
                        <td style="text-align: center;">{{ $r->Status }}</td>
                        <td style="text-align: center;">{{ $r->Remarks }}</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right; font-weight: bold;">TOTAL</td>
                <td style="text-align: center; font-weight: bold;">{{ number_format($row['CTS'], 2) }}</td>
                <td style="text-align: center; font-weight: bold;">{{ number_format($row['TotalCDR'], 2) }}
                </td>
                <td style="text-align: center; font-weight: bold;">{{ number_format($row['TotalCOH'], 2) }}
                </td>
                <td
                    style="text-align: center; font-weight: bold;">
                    {{ number_format($row['TotalDiscrepancy'], 2) }}</td>

                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
