<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500&display=swap" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Noto Sans JP', sans-serif;
            font-size: 12px;
        }

        .email-table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
            font-size: 12px;
        }

        .email-table tr th {
            padding: 8px;
            text-align: left;
        }

        .email-table tr td {
            padding: 8px;
            text-align: left;
        }

        .email-table td,
        .email-table th {
            border: 1px solid black;
        }

        .email-table tr:last-child td,
        .email-table tr:last-child th {
            border: none;
        }
    </style>
</head>

<body>
    @php
        $redirect = base64_encode(env('APP_URL'));
        $request = base64_encode('cash_deposit');
    @endphp
    <a href="{{ env('MYHUB_URL') }}"> <img src="https://myhub.atp.ph/resource/style1/img/myhublogo.png"
            width="120" /> </a>
    <div class="body-content container">
        <br><br>
        {!! $content !!}
        <br><br>
        <table class="email-table">
            <tr>
                <td>Store</td>
                <td>{{ $clk[0]->LocationCode . ' ' . $clk[0]->Location }}</td>
            </tr>
            <tr>
                <td>Sales Date</td>
                <td>{{ $clk[0]->SalesDate }}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{ $clk[0]->Employee2 }}</td>
            </tr>
            <tr>
                <td>POS/CDR</td>
                <td>{{ number_format($clk[0]->CDR, 2) }}</td>
            </tr>
            <tr>
                <td>Cash on Hand</td>
                <td>{{ number_format($clk[0]->COH, 2) }}</td>
            </tr>
            <tr>
                <td>Discrepancy</td>
                <td>{{ number_format($clk[0]->COH - $clk[0]->CDR, 2) }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>{{ $clk[0]->Status }}</td>
            </tr>
            <tr>
                <td>Remarks</td>
                <td>{{ $clk[0]->Remarks }}</td>
            </tr>
            <tr>
                <td>Validated by</td>
                <td>{{ $clk[0]->ValidatedBy }}</td>
            </tr>
        </table>
        <br><br>
        Thank you.
    </div><br><br>

    Visit <a href="{{ env('MYHUB_URL') }}">MyHub : Cash Sales Deposit Audit</a> for more details.
</body>

</html>
