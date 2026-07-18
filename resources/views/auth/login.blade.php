<x-guest-layout>

<style>
    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    body{
        min-height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        background: #f4f7fb;
        overflow-x:hidden;
    }

    body::before,
    body::after{
        content:"";
        position:fixed;
        border-radius:50%;
        z-index:0;
    }

    body::before{
        width:900px;
        height:900px;
        background: radial-gradient(circle, rgba(52,152,219,0.12), transparent 60%);
        top:-250px;
        left:-250px;
    }

    body::after{
        width:700px;
        height:700px;
        background: radial-gradient(circle, rgba(44,62,80,0.10), transparent 60%);
        bottom:-250px;
        right:-250px;
    }

    /* CARD */
    .box{
        width:850px;
        max-width:95%;
        display:flex;
        background:#fff;
        border-radius:18px;
        overflow:hidden;
        box-shadow:0 20px 50px rgba(0,0,0,0.12);
        position:relative;
        z-index:1;
    }

    /* IZQUIERDA */
    .left{
        width:40%;
        background: linear-gradient(135deg, #2c3e50, #1f2c38);
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
        color:#fff;
        padding:40px;
        text-align:center;
    }

    .left img{
        width:260px;
        max-width:100%;
        margin-bottom:10px;
    }

    .left h2{
        font-size:16px;
        font-weight:700;
    }

    /* DERECHA */
    .right{
        width:60%;
        padding:55px 50px;
    }

    .title{
        text-align:center;
        font-size:20px;
        font-weight:700;
        color:#1f2c38;
        margin-bottom:25px;
    }

    .group{
        margin-bottom:14px;
    }

    .input{
        width:100%;
        padding:12px 14px;
        border:none;
        border-bottom:2px solid #e5e7eb;
        outline:none;
        font-size:14px;
        background:transparent;
        transition:0.25s;
    }

    .input:focus{
        border-bottom:2px solid #3498db;
    }

    .error{
        font-size:12px;
        color:#e74c3c;
        margin-top:5px;
    }

    /* BOTÓN */
    .btn-area{
        display:flex;
        justify-content:center;
        margin-top:18px;
    }

    .btn{
        width:220px;
        padding:11px 28px;
        border:none;
        border-radius:10px;
        background:#2c3e50;
        color:#fff;
        font-weight:600;
        cursor:pointer;
        transition:0.25s;
    }

    .btn:hover{
        background:#f4d279;
        color:#2c3e50;
        transform:translateY(-2px);
    }

    /* EXTRA */
    .extra{
    display:flex;
    justify-content:center;
    font-size:12px;
    margin-top:18px;
    color:#4b5563;
}

    .extra a{
        text-decoration:none;
        color:#2c3e50;
        font-weight:500;
    }

    /* 🔥 RESPONSIVE REAL */
    @media(max-width:768px){

        body{
            padding:20px;
        }

        .box{
            flex-direction:column;
            border-radius:15px;
        }

        .left,
        .right{
            width:100%;
        }

        .left{
            padding:25px;
        }

        .left img{
            width:120px;
        }

        .right{
            padding:30px 20px;
        }

        .title{
            font-size:18px;
        }

        .btn{
            width:100%;   /*  botón full en móvil */
            max-width:260px;
        }

        .btn-area{
            justify-content:center;
        }

        .input{
            font-size:13px;
        }
    }

    @media(max-width:480px){

        .left h2{
            font-size:14px;
        }

        .title{
            font-size:17px;
        }

        .btn{
            font-size:14px;
        }
    }

</style>

<div class="box">

    <!-- IZQUIERDA -->
    <div class="left">
        <img src="{{url('image/PSCB.png')}}" alt="logo">
        <h2>Puesto de Salud Cruz Blanca</h2>
    </div>

    <!-- DERECHA -->
    <div class="right">

        <div class="title">Iniciar sesión</div>

        <x-auth-session-status class="mb-3" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="group">
                <input type="email" name="email"
                    class="input"
                    placeholder="Correo electrónico"
                    value="{{ old('email') }}"
                    required>

                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="group">
                <input type="password" name="password"
                    class="input"
                    placeholder="Contraseña"
                    required>

                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="btn-area">
                <button type="submit" class="btn">
                    Ingresar
                </button>
            </div>

            <div class="extra">
             

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="text-align: center">
                        ¿Olvidaste contraseña?
                    </a>
                @endif
            </div>

        </form>

    </div>

</div>

</x-guest-layout>