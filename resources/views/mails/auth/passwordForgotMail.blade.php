<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h3>Redefinir Senha</h3>
    <p>
        Olá, {{ $customer->name }}.
        Vamos redefinir sua senha para que você continue acessando nosssa plataforma.
    </p>
    <hr/>
    <a target="_blank" href={{ $link }}>{{ $link }}</a>
</body>

</html>