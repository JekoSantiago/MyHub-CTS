<table>
	<tr>
		<td colspan="6" style="font-weight: 500; font-size: 14px; font-family: 'Arial'; text-align: left;">TREASURY COMPLIANCE MONITORING</td>
	</tr>

	<tr>

        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">NO.</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">STORE CODE</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">STORE NAME</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">DPU FREQUENCY</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">SALES DATE</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">CTS TOTAL NET CASH COLLECTION</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">DPAS</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">VDS</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">DISCREPANCY</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">DPAS UPLOADED BY</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">DPAS UPLOADED DATE</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">VDS UPLOADED BY</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">VDS UPLOADED DATE</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Arial'; text-align: center;">REMARKS</td>



    </tr>

    @foreach ( $audit as $a)
    <tr>

        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;">{{ $a->RowNum }}</td>
        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;">{{ $a->LocationCode }}</td>
        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;">{{ $a->Location }}</td>
        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;">{{ $a->Sched }}</td>
        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;">{{ $a->SalesDate }}</td>
        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;">{{ number_format($a->NetCash, 2, '.', '') }}</td>
        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;">{{ number_format($a->DepositAmount, 2, '.', '') }}</td>
        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;">{{ number_format($a->VDA, 2, '.', '')  }}</td>
        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;">{{ number_format($a->Discrepancy, 2, '.', '') }}</td>
        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;">{{ $a->DPASby }}</td>
        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;">{{ $a->DPASdate }}</td>
        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;">{{ $a->VDAby }}</td>
        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;">{{ $a->VDAdate }}</td>
        <td style="font-weight: 350; font-size: 10px; font-family: 'Arial'; text-align: center;"></td>
    </tr>
    @endforeach

</table>

