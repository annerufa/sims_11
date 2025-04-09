
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <p>{{ session('error') ?? session('error')}}</p>
    <h1>Login</h1>
    <form action="{{ route('actionlogin') }}" method="POST">
        @csrf
        <input name="no_pegawai" type="number">
        <input name="password" type="password">
        <button type="submit">Login</button>
    </form>
    <br><br>
    <h1>REgister</h1>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <input name="nama" type="text" placeholder="Nama" >
        <input name="jabatan" type="text" placeholder="jabatan" >
        <input name="email" type="text" placeholder="email" >
        <input name="no_pegawai" type="number" placeholder="No pegawai" >
        <input name="password" type="password">
        <button type="submit">Buat Akun</button>
    </form>
    @error('no_pegawai')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</body>
</html>