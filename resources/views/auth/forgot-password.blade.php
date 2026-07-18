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
width:900px;
height:900px;
background:radial-gradient(circle,rgba(52,152,219,.12),transparent 60%);
top:-250px;
left:-250px;
}

body::after{
width:700px;
height:700px;
background:radial-gradient(circle,rgba(44,62,80,.10),transparent 60%);
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
box-shadow:0 20px 50px rgba(0,0,0,.12);
position:relative;
z-index:1;
}

/* IZQUIERDA */
.left{
width:40%;
background:linear-gradient(135deg,#2c3e50,#1f2c38);
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
position:relative;
}

/* LINK SUPERIOR */
.back-top{
position:absolute;
top:28px;
right:35px;
}

.back-top a{
display:flex;
align-items:center;
gap:6px;
text-decoration:none;
font-size:13px;
font-weight:600;
color:#2c3e50;
transition:.25s;
}

.back-top a:hover{
color:#3498db;
transform:translateX(-2px);
}

.back-icon{
font-size:15px;
line-height:1;
}

.title{
text-align:center;
font-size:20px;
font-weight:700;
color:#1f2c38;
margin-bottom:15px;
margin-top:20px;
}

.subtitle{
text-align:center;
font-size:14px;
color:#6b7280;
margin-bottom:30px;
line-height:1.6;
}

.group{
margin-bottom:18px;
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

.btn-area{
display:flex;
justify-content:center;
margin-top:18px;
}

.btn{
width:250px;
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
padding:35px 20px;
}

.back-top{
position:static;
display:flex;
justify-content:flex-end;
margin-bottom:10px;
}

.title{
font-size:18px;
margin-top:0;
}

.btn{
width:100%;
max-width:280px;
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

<div class="back-top">
<a href="{{ route('login') }}">
<span class="back-icon">←</span>
<span>Login</span>
</a>
</div>

<div class="title">
Recuperar contraseña
</div>

<div class="subtitle">
Ingresa tu correo electrónico para recibir
un enlace de recuperación seguro.
</div>

<x-auth-session-status class="mb-3"
:status="session('status')" />

<form method="POST"
action="{{ route('password.email') }}">
@csrf

<div class="group">

<input
type="email"
name="email"
value="{{ old('email') }}"
class="input"
placeholder="Correo electrónico"
required>

@error('email')
<div class="error">
{{ $message }}
</div>
@enderror

</div>

<div class="btn-area">
<button
type="submit"
class="btn"
onclick="this.disabled=true;this.innerText'Procesando solicitud...';this.form.submit();">
Enviar enlace
</button>
</div>

</form>

</div>
</div>

</x-guest-layout>