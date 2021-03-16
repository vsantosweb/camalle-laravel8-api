<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h3>Confirmação de Cadastro</h3>
    <p>
        Olá, {{ $customer->name }}.
        Seu link para confirmação do cadastro na Camalle,

        Obrigado,
    </p>
    <hr/>
    <a target="_blank" href={{ $link }}>{{ $link }}</a>
</body>

</html>