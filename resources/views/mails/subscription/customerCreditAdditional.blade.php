<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns=" www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Créditos Adicionais</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

</html>

<body style=" padding: 15px;">
    <h3>Olá, {{ $customer->name }}.</h3>
    <p>
        Obrigado por confiar na Camalle. Sua compra créditos na
        plataforma foi aprovado.
    </p>
    <hr/>
    <table style="width: 100%">
        <tr style="border: 1px solid #545454">
            <td>Créditos Adicionais</td>
            <td style="text-align:right">{{ $order->order_data->additionals_credits }}</td>
        </tr>
        <tr style="border: 1px solid #545454">
            <td>Forma de Pagamento</td>
            <td style="text-align:right">{{ $order->order_data->payment_method }}</td>
        </tr>
        <tr style="border: 1px solid #545454">
            <td>Total</td>
            <td style="text-align:right"> R$ {{ number_format($order->order_data->total_amount,2,",",".") }}</td>
        </tr>
    </table>
</body>
