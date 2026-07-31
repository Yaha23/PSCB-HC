<x-guest-layout>

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

body{
min-height:100vh;
display:flex;
align-items:center;
justify-content:center;
background:#f4f7fb;
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

/* CARD */
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

/* IZQUIERDA */
.left{
width:38%;
background:linear-gradient(135deg,#2c3e50,#1f2c38);
display:flex;
justify-content:center;
align-items:center;
flex-direction:column;
padding:25px;
color:white;
text-align:center;
}

.left img{
    width:190px;
    max-width:100%;
    margin-bottom:15px;
}

.left h2{
font-size:14px;
font-weight:600;
}

/* DERECHA */
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

.subtitle{
text-align:center;
font-size:13px;
color:#6b7280;
margin-bottom:18px;
line-height:1.6;
}

.group{
margin-bottom:16px;
}

.input{
width:100%;
padding:12px 14px;
border:none;
border-bottom:2px solid #e5e7eb;
outline:none;
font-size:14px;
background:transparent;
transition:.25s;
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
margin-top:22px;
}

.btn{
width:240px;
padding:11px 28px;
border:none;
border-radius:10px;
background:#2c3e50;
color:#fff;
font-weight:600;
cursor:pointer;
transition:.25s;
}

.btn:hover{
background:#f4d279;
color:#2c3e50;
transform:translateY(-2px);
}

/* LINK LOGIN */
.back-top{
display:flex;
justify-content:flex-end;
margin-bottom:10px;
}

.back-top a{
text-decoration:none;
font-size:13px;
font-weight:600;
color:#2c3e50;
transition:.25s;
}

.back-top a:hover{
color:#3498db;
}

/* RESPONSIVE */
@media(max-width:768px){

body{
padding:20px;
}

.box{
flex-direction:column;
border-radius:15px;
}

.left,.right{
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
width:100%;
max-width:260px;
}

.input{
font-size:13px;
}

.back-top{
justify-content:center;
margin-bottom:15px;
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
.password-container{
    position:relative;
}

.password-container .input{
    padding-right:45px;
}

.toggle-password{
    position:absolute;
    right:12px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    color:#94a3b8;
    font-size:18px;
    transition:.3s;
}

.toggle-password:hover{
    color:#2c3e50;
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



<div class="title">
Restablecer contraseña
</div>




<form method="POST" action="{{ route('password.store') }}">
@csrf

<input type="hidden"
name="token"
value="{{ $request->route('token') }}">


<div class="group">
<input
type="email"
name="email"
class="input"
placeholder="Correo electrónico"
value="{{ old('email', $request->email) }}"
required
autocomplete="username">

@error('email')
<div class="error">
{{ $message }}
</div>
@enderror
</div>


<div class="group">

    <div class="password-container">

        <input
        type="password"
        id="password"
        name="password"
        class="input"
        placeholder="Nueva contraseña"
        required
        autocomplete="new-password">

        <span class="toggle-password"
              onclick="togglePassword('password', this)">
            <i class="bi bi-eye-slash"></i>
        </span>

    </div>

    @error('password')
        <div class="error">
            {{ $message }}
        </div>
    @enderror

</div>


<div class="group">

    <div class="password-container">

        <input
        type="password"
        id="password_confirmation"
        name="password_confirmation"
        class="input"
        placeholder="Confirmar contraseña"
        required
        autocomplete="new-password">

        <span class="toggle-password"
              onclick="togglePassword('password_confirmation', this)">
            <i class="bi bi-eye-slash"></i>
        </span>

    </div>

    @error('password_confirmation')
        <div class="error">
            {{ $message }}
        </div>
    @enderror

</div>


<div class="btn-area">
<button type="submit" class="btn">
Restablecer
</button>
</div>

</form>

</div>

</div>

<script>

function togglePassword(inputId, elemento){

    const input = document.getElementById(inputId);
    const icono = elemento.querySelector("i");

    if(input.type === "password"){

        input.type = "text";
        icono.classList.remove("bi-eye-slash");
        icono.classList.add("bi-eye");

    }else{

        input.type = "password";
        icono.classList.remove("bi-eye");
        icono.classList.add("bi-eye-slash");

    }

}

</script>

</x-guest-layout>