<head>
    <title>{{ ($title ?? 'Print') . ' | ' . env('APP_NAME') }}</title>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
</head>
<div class="text-right">
    {{ date("Y-m-d H:i:s") }}
</div>
<table>
	<tr>
		<td colspan="12" style="font-weight: 500; font-size: 17px; font-family: 'Calibri Light'; text-align: left;">CASHIER TALLY SHEET</td>
    </tr>
	<tr>
		<td colspan="12">CTS # {{ $cts }}</td>
	</tr>
    <tr>
		<td colspan="4"> {{ $info[0]->Store }}</td>
    </tr>
    @if($info[0]->Shift != "X")
    <tr>
        <td colspan="4">SHIFT : {{ $info[0]->Shift }}</td>
    </tr>
    @endif
	<style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
          overflow:hidden;padding:2px 2px;word-break:normal;}
        .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
          font-weight:normal;overflow:hidden;padding:2px 2px;word-break:normal;}
        .tg .tg-xj58{border-color:#000000;font-size:x-small;font-weight:bold;text-align:center;vertical-align:middle}
        .tg .tg-4w8t{border-color:#000000;font-size:x-small;text-align:right;font-weight:bold;text-align:center;vertical-align:middle}
        .tg .tg-z3f5{border-color:#000000;font-size:x-small;text-align:center;vertical-align:middle}
        .tg .tg-dhix{border-color:inherit;font-size:x-small;text-align:left;vertical-align:middle}
        </style>
        <table class="tg" style="undefined;table-layout: fixed; width: 960px">
        <thead>
          <tr>
            <th class="tg-xj58" rowspan="3"><br><br>CASH</th>
            <th class="tg-xj58" colspan="8">CONSOLIDATED CASH SALES COLLECTION AS OF {{ strtoupper(date('F d, Y')) }}</th>
            <th class="tg-xj58" colspan="2" rowspan="2">END OF SHIFT</th>
            <th class="tg-xj58" colspan="2" rowspan="2">OVERALL TOTAL</th>
          </tr>
          <tr>
            <th class="tg-xj58" colspan="2">1ST PICK-UP</th>
            <th class="tg-xj58" colspan="2">2ND PICK-UP</th>
            <th class="tg-xj58" colspan="2">3RD PICK-UP</th>
            <th class="tg-xj58" colspan="2">4TH PICK-UP</th>
          </tr>
          <tr>
            <th class="tg-z3f5">QTY</th>
            <th class="tg-z3f5">AMOUNT</th>
            <th class="tg-z3f5">QTY</th>
            <th class="tg-z3f5">AMOUNT</th>
            <th class="tg-z3f5">QTY</th>
            <th class="tg-z3f5">AMOUNT</th>
            <th class="tg-z3f5">QTY</th>
            <th class="tg-z3f5">AMOUNT</th>
            <th class="tg-z3f5">QTY</th>
            <th class="tg-z3f5">AMOUNT</th>
            <th class="tg-z3f5">QTY</th>
            <th class="tg-z3f5">AMOUNT</th>
          </tr>
        </thead>
        <tbody>
        @php

        @endphp
        @endphp
        @foreach ($tally as $t)
        <tr>
            <td class="tg-dhix" style="text-align: right">@if($t->DenomOption_ID == 13) <span style="float: left;"> Bills </span> @elseif ($t->DenomOption_ID == 7) <span style="float: left;"> Coins </span> @endif {{  number_format($t->Amount, 2, '.', ',')  }} </td>
            <td class="tg-dhix" style="text-align: center; width: 5%">{{ ($t->P1_Qty > 0) ? $t->P1_Qty : '-' }}</td>
            <td class="tg-dhix" style="text-align: right">{{ ($t->P1_Amount > 0) ? number_format($t->P1_Amount, 2, '.', ',') : '-' }}</td>
            <td class="tg-dhix" style="text-align: center; width: 5%">{{ ($t->P2_Qty > 0) ?  $t->P2_Qty : '-' }}</td>
            <td class="tg-dhix" style="text-align: right">{{ ($t->P2_Amount > 0) ? number_format($t->P2_Amount, 2, '.', ',') : '-' }}</td>
            <td class="tg-dhix" style="text-align: center; width: 5%">{{ ($t->P3_Qty > 0) ? $t->P3_Qty : '-' }}</td>
            <td class="tg-dhix" style="text-align: right">{{ ($t->P3_Amount > 0) ? number_format($t->P3_Amount, 2, '.', ',') : '-' }}</td>
            <td class="tg-dhix" style="text-align: center; width: 5%">{{ ($t->P4_Qty > 0) ? $t->P4_Qty : '-' }}</td>
            <td class="tg-dhix" style="text-align: right">{{ ($t->P4_Amount > 0) ? number_format($t->P4_Amount, 2, '.', ',') : '-' }}</td>
            <td class="tg-dhix" style="text-align: center; width: 5%">{{ ($t->P5_Qty > 0) ? $t->P5_Qty : '-' }}</td>
            <td class="tg-dhix" style="text-align: right">{{ ($t->P5_Amount > 0) ? number_format($t->P5_Amount, 2, '.', ',') : '-' }}</td>
            <td class="tg-dhix" style="text-align: center; width: 5%">{{ $t->P1_Qty + $t->P2_Qty + $t->P3_Qty + $t->P4_Qty + $t->P5_Qty}}</td>
            <td class="tg-dhix" style="text-align: right">{{ number_format(($t->P1_Amount + $t->P2_Amount + $t->P3_Amount + $t->P4_Amount + $t->P5_Amount), 2, '.', ',')}}</td>
          </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th class="tg-xj58">TOTAL CASH:</th>
                <th class="tg-xj58"></th>
                <th class="tg-xj58" style="text-align: right">{{ number_format($p1tot, 2, '.', ',') }}</th>
                <th class="tg-xj58"></th>
                <th class="tg-xj58" style="text-align: right">{{ number_format($p2tot, 2, '.', ',') }}</th>
                <th class="tg-xj58"></th>
                <th class="tg-xj58" style="text-align: right">{{ number_format($p3tot, 2, '.', ',') }}</th>
                <th class="tg-xj58"></th>
                <th class="tg-xj58" style="text-align: right">{{ number_format($p4tot, 2, '.', ',') }}</th>
                <th class="tg-xj58"></th>
                <th class="tg-xj58" style="text-align: right">{{ number_format($p5tot , 2, '.', ',')}}</th>
                <th class="tg-xj58"></th>
                <th class="tg-xj58" style="text-align: right">{{ number_format($totcash, 2, '.', ',') }}</th>
            </tr>
            <tr>
                <th colspan="11" class="tg-dhix" >LESS: LOOSE CHANGE FUND</th>
                <th colspan="2" class="tg-4w8t" style="text-align: right">{{ number_format($tally[0]->LCF, 2, '.', ',') }}</th>
            </tr>
            <tr>
                <th colspan="11" class="tg-dhix">TOTAL CASH SALES DURING THE DAY</th>
                <th colspan="2"  class="tg-4w8t" style="text-align: right">{{ number_format((float)$totcash - $tally[0]->LCF , 2, '.', ',') }}</th>
            </tr>
            <tr>
                <th colspan="11" class="tg-dhix">LESS: CHECK ENCASHMENT</th>
                <th colspan="2"  class="tg-4w8t" style="text-align: right">{{ number_format($tally[0]->LCC , 2, '.', ',')  }}</th>
            </tr>
            <tr>
                <th colspan="11" class="tg-dhix">NET CASH COLLECTION DURING THE DAY</th>
                <th colspan="2"  class="tg-4w8t" style="text-align: right">{{ number_format((float)$totcash - $tally[0]->LCF - $tally[0]->LCC  , 2, '.', ',') }}</th>
            </tr>
        </tfoot>
        </table>
</table>

<div class="row">
    <div class="col-4 text-center my-0">
        <div class="row pt-0">
            <h5>PREPARED BY:</h5>
        </div>
        <div class="row pt-0">
            <h5><u>{{ $name }}</u></h5>
        </div>
        <div class="row pt-0">
            <h5>{{ $position }}</h5>
        </div>
    </div>
</div>

