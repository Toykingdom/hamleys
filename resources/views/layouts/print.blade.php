<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <style>
            @media print {
                tr { height: 29px; }
                td { font-size: 20px; }
                td.padding{padding-left:10pt;}
            }
        </style>
        <script type="text/javascript">
            window.onload = function() {
                window.print();
            }
        </script>
    </head>
    <body class='body'>
        <table>
            <tr >
                <td width=10pt></td>
                <td height=100pt></td>
                <td width=180pt></td>
            </tr>
            <tr>
                <td width=10pt></td>
                <td height=20pt></td>
                <td> </td>
            </tr>
            <tr >
                <td width=10pt></td>
                <td ></td>
                <td></td>
            </tr>
            <tr >
                <td width=10pt></td>
                <td width=150pt style="padding-left:10px">{{ $name }}</td>
                <td nowrap>{{ strtoupper($code)  }}</td>
            </tr>
        </table>
    </body>
</html>
