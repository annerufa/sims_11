<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
</head>
<body>
    <h1>Halaman Admin</h1>
    <!-- Tampilkan nama user -->
    <p>Welcome, {{ Auth::user()->nama }}!</p>
    <p>My, {{ Auth::user()->jabatan }}!</p>
    <br><hr>
    <!-- Di Blade -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>