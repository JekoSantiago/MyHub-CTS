<table>
	<tr>
		<td colspan="6" style="font-weight: 500; font-size: 14px; font-family: 'Calibri Light'; text-align: left;">COMPLIANCE REPORT</td>
	</tr>

	<tr>
		<td colspan="6">{{ $comp[0]->Store }}</td>
	</tr>
	<tr>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Calibri Light'; text-align: center;">DATE</td>
		<td style="font-weight: 500; font-size: 10px; font-family: 'Calibri Light'; text-align: center;">GRAVEYARD</td>
		<td style="font-weight: 500; font-size: 10px; font-family: 'Calibri Light'; text-align: center;">OPENING</td>
		<td style="font-weight: 500; font-size: 10px; font-family: 'Calibri Light'; text-align: center;">MIDSHIFT</td>
		<td style="font-weight: 500; font-size: 10px; font-family: 'Calibri Light'; text-align: center;">CLOSING</td>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Calibri Light'; text-align: center;">OVERALL</td>
    </tr>

    @foreach ( $comp as $c)
    <tr>
        <td style="font-weight: 500; font-size: 10px; font-family: 'Calibri Light'; text-align: center;">{{ $c->DateRange }}</td>
        <td style="font-weight: 500; font-size: 10px; font-family: @if($c->GY == 1)  'Wingdings' @else 'Calibri Light' @endif ; text-align: center;">{{ ($c->GY == 1 ) ? "=CHAR(252)" : (($c->GY == 0) ? "x" : "-") }}</td>
        <td style="font-weight: 500; font-size: 10px; font-family: @if($c->Opening > 0)  'Wingdings' @else 'Calibri Light' @endif ; text-align: center;">{{ ($c->Opening > 0 ) ? "=CHAR(252)" : "x"}}</td>
        <td style="font-weight: 500; font-size: 10px; font-family: @if($c->Mid > 0)  'Wingdings' @else 'Calibri Light' @endif ; text-align: center;">{{ ($c->Mid == 1 ) ? "=CHAR(252)" : (($c->Mid == 0) ? "x" : "-") }}</td>
        <td style="font-weight: 500; font-size: 10px; font-family: @if($c->Closing > 0)  'Wingdings' @else 'Calibri Light' @endif ; text-align: center;">{{ ($c->Closing > 0 ) ? "=CHAR(252)" : "x" }}</td>
        <td style="font-weight: 500; font-size: 10px; font-family: @if($c->OverAll > 0)  'Wingdings' @else 'Calibri Light' @endif ; text-align: center;">{{ ($c->OverAll > 0 ) ? "=CHAR(252)" : "x" }}</td>
    </tr>
    @endforeach

</table>

