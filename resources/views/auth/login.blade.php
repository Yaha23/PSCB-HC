<x-guest-layout>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#f4f7fb;
}


/* Fondo decorativo */
body::before,
body::after{
    content:"";
    position:fixed;
    border-radius:50%;
    z-index:0;
}

body::before{
    width:500px;
    height:500px;
    background:radial-gradient(circle,rgba(52,152,219,.12),transparent 65%);
    top:-150px;
    left:-150px;
}

body::after{
    width:400px;
    height:400px;
    background:radial-gradient(circle,rgba(44,62,80,.10),transparent 65%);
    bottom:-150px;
    right:-150px;
}


/* CARD PEQUEÑA */

.box{

    width:650px;
    max-width:90%;

    display:flex;

    background:white;

    border-radius:16px;

    overflow:hidden;

    box-shadow:0 15px 35px rgba(0,0,0,.12);

    position:relative;

    z-index:1;

}


/* PANEL IZQUIERDO */

.left{

    width:38%;

    background:linear-gradient(
        135deg,
        #2c3e50,
        #1f2c38
    );

    display:flex;

    justify-content:center;

    align-items:center;

    flex-direction:column;

    padding:25px;

    color:white;

    text-align:center;

}


.left img{

    width:130px;

    margin-bottom:15px;

}


.left h2{

    font-size:14px;

    font-weight:600;

}



/* PANEL DERECHO */

.right{

    width:62%;

    padding:35px 40px;

}



.title{

    text-align:center;

    font-size:20px;

    font-weight:700;

    color:#1f2c38;

    margin-bottom:20px;

}



/* INPUT */

.group{

    margin-bottom:12px;

}


.input{

    width:100%;

    padding:10px 12px;

    border:none;

    border-bottom:2px solid #e5e7eb;

    outline:none;

    font-size:13px;

    background:transparent;

}


.input:focus{

    border-color:#3498db;

}



.error{

    color:#e74c3c;

    font-size:11px;

    margin-top:4px;

}


/* PASSWORD */

.password-container{

    position:relative;

}


.toggle-password{

    position:absolute;

    right:10px;

    top:9px;

    cursor:pointer;

    color:#94a3b8;

}



/* BOTON */

.btn-area{

    display:flex;

    justify-content:center;

    margin-top:15px;

}



.btn{

    width:180px;

    padding:10px;

    border:none;

    border-radius:8px;

    background:#2c3e50;

    color:white;

    font-weight:600;

    cursor:pointer;

    transition:.3s;

}



.btn:hover{

    background:#f4d279;

    color:#2c3e50;

}



/* LINK */

.extra{

    text-align:center;

    margin-top:15px;

    font-size:12px;

}


.extra a{

    color:#2c3e50;

    text-decoration:none;

}



@media(max-width:700px){

.box{

    flex-direction:column;

}


.left,
.right{

    width:100%;

}


.left{

    padding:20px;

}


.left img{

    width:90px;

}


.right{

    padding:25px;

}

}

.status-message{
    color:#dc2626;          /* rojo */
    font-size:11px;         /* pequeño */
    text-align:center;
    margin-bottom:15px;
    font-weight:500;
    line-height:1.5;
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

        @if(session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="group">
                <input
                type="text"
                name="username"
                class="input"
                placeholder="Nombre de usuario"
                value="{{ old('username') }}"
                required>

                @error('username')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="group password-container">

                <input 
                    type="password" 
                    id="password"
                    name="password"
                    class="input"
                    placeholder="Contraseña"
                    required
                    value="{{ old('password') }}"
                >

                <span class="toggle-password" onclick="mostrarPassword()">
                    <i class="bi bi-eye-slash"></i>
                </span>

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

<script>

function mostrarPassword(){

    let password = document.getElementById("password");
    let icono = document.querySelector(".toggle-password i");

    if(password.type === "password"){

        password.type = "text";
        icono.classList.remove("bi-eye-slash");
        icono.classList.add("bi-eye");

    }else{

        password.type = "password";
        icono.classList.remove("bi-eye");
        icono.classList.add("bi-eye-slash");

    }

}

</script>

</x-guest-layout>