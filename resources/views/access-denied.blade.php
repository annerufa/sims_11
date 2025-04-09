<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Akses Ditolak!</h1>
        <p>{{ session('error') ?? 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Home</a>
</body>
</html>