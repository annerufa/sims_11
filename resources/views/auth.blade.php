<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script> -->
    {{-- <link rel="stylesheet" type="text/css" href="css/fa/css/all.css"> --}}
    <link rel="stylesheet" {{-- href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=person" /> --}} {{-- <link rel="stylesheet" href="css/auth.css" /> --}} <link rel="stylesheet"
        href="{{ asset('assets/css/simbolUser.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/simbol1.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/simbol2.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/fa/css/all.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}" />

    <title>Sign in & Sign up Form</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="{{ route('actionlogin') }}" method="POST" class="sign-in-form">
                    @csrf
                    <img src="{{ asset('assets/img/OV2.png') }}" style="margin-bottom: 45px;">
                    <h2 class="title">Masuk</h2>


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="input-field">
                        <span class="material-symbols-sharp span">
                            person
                        </span>
                        <input name="no_pegawai" type="number" placeholder="No Pegawai / NIP" />
                    </div>
                    <div class="input-field">
                        {{-- <i class="fas fa-lock"></i> --}}
                        <span class="material-symbols-sharp span">
                            lock
                        </span>
                        <input name="password" id="passwordInput" type="password" placeholder="Password" />
                        <span class="material-symbols-sharp span toggle-password" id="togglePassword">
                            visibility_off
                        </span>
                        {{-- <i class="fas fa-eye toggle-password" id="togglePassword"></i> --}}
                    </div>
                    <button type="submit" class="btn solid">Login</button>
                </form>
                <form action="/daftarakun" method="POST" class="sign-up-form">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <img src="{{ asset('assets/img/OV2.png') }}" style="margin-bottom: 35px;">
                    <h2 class="title">Buat Akun Baru</h2>
                    <div class="row">
                        <div class="input-field col-12">
                            <span class="material-symbols-sharp span">
                                person
                            </span>
                            <input name="nama" type="text" placeholder="Nama Lengkap"
                                value="{{ old('nama') }}" />
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col-6">
                            <span class="material-symbols-sharp span">
                                badge
                            </span>
                            <input name="no_pegawai" type="number" placeholder="No Pegawai/NIP"
                                value="{{ old('no_pegawai') }}" />
                        </div>
                        <div class="input-field col-6">
                            <span class="material-symbols-sharp span">
                                mail
                            </span>
                            <input name="email" type="text" placeholder="Email" value="{{ old('email') }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col-6">
                            <span class="material-symbols-sharp span">
                                assignment_ind
                            </span>
                            <select name="jabatan" name="jabatan" required>
                                <option id="opsi" value="">-- Pilih Jabatan / Posisi --</option dissable>
                                <option value="admin">ADMIN TATA USAHA</option>
                                {{-- <option value="adminSK">ADMIN SURAT KELUAR</option> --}}
                                <option value="WAKA KURIKULUM">WAKA KURIKULUM</option>
                                <option value="WAKA SARPRAS">WAKA SARPRAS</option>
                                <option value="WAKA KESISWAAN">WAKA KESISWAAN</option>
                                <option value="WAKA HUMAS">WAKA HUMAS</option>
                                <option value="ks">KEPALA SEKOLAH</option>
                            </select>
                        </div>
                        <div class="input-field col-6">
                            <span class="material-symbols-sharp span">
                                lock
                            </span>
                            <input name="password" type="password" placeholder="Password"
                                value="{{ old('password') }}" />
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn">Buat Akun</button>
                    <!-- <input type="submit" value="Buat Akun" /> -->
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Belum punya akun?</h3>
                    <p>
                        Silahkan buat akun untuk bisa mengakses layanan ini.
                    </p>
                    <button class="btn transparent" id="sign-up-btn">
                        Buat Akun
                    </button>
                </div>
                <img src="{{ asset('assets/img/register.svg') }}" style="width:80%" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Sudah punya akun?</h3>
                    <p>
                        Silahkan login menggunakan akun yang telah miliki.
                    </p>
                    <button class="btn transparent" id="sign-in-btn">
                        Login
                    </button>
                </div>
                <img src="{{ asset('assets/img/log.svg') }}" class="image" alt="" />
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('passwordInput');
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.textContent = this.textContent.trim() === 'visibility_off' ? 'visibility' : 'visibility_off';
        });
    </script>
    {{-- <script type="text/javascript">
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('passwordInput');
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.classList.toggle('fa-eye-slash');
        });
    </script> --}}
    <script type="text/javascript">
        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");

        sign_up_btn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });

        sign_in_btn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });
    </script>
</body>

</html>
