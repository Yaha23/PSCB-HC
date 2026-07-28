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

width:600px;

height:600px;

background:radial-gradient(circle,rgba(52,152,219,.12),transparent 60%);

top:-200px;

left:-200px;

}


body::after{

width:500px;

height:500px;

background:radial-gradient(circle,rgba(44,62,80,.10),transparent 60%);

bottom:-200px;

right:-200px;

}


/* CARD */

.box{

width:650px;

max-width:90%;

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

width:38%;

background:linear-gradient(135deg,#2c3e50,#1f2c38);

display:flex;

justify-content:center;

align-items:center;

flex-direction:column;

padding:30px;

color:white;

text-align:center;

}


.left img{

width:140px;

margin-bottom:15px;

}


.left h2{

font-size:15px;

font-weight:700;

}



/* DERECHA */

.right{

width:62%;

padding:35px 40px;

position:relative;

}



.back-top{

position:absolute;

top:25px;

right:30px;

}



.back-top a{

text-decoration:none;

font-size:13px;

font-weight:600;

color:#2c3e50;

transition:.3s;

}


.back-top a:hover{

color:#3498db;

}



.title{

text-align:center;

font-size:20px;

font-weight:700;

color:#1f2c38;

margin-top:15px;

margin-bottom:8px;

}



.subtitle{

text-align:center;

font-size:13px;

color:#6b7280;

margin-bottom:20px;

}



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

transition:.25s;

}


.input:focus{

border-bottom:2px solid #3498db;

}



.label{

font-size:13px;

font-weight:600;

color:#374151;

}



.error{

font-size:12px;

color:#e74c3c;

margin-top:4px;

}



/* BOTON */

.btn-area{

display:flex;

justify-content:center;

margin-top:15px;

}



.btn{

width:220px;

padding:10px;

border:none;

border-radius:10px;

background:#2c3e50;

color:white;

font-weight:600;

cursor:pointer;

transition:.3s;

}



.btn:hover{

background:#f4d279;

color:#2c3e50;

transform:translateY(-2px);

}



/* RESPONSIVE */

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

padding:30px 20px;

}


.back-top{

position:static;

text-align:right;

margin-bottom:10px;

}

}


</style>


<div class="box">


<!-- IZQUIERDA -->

<div class="left">

<img src="{{url('image/PSCB.png')}}" alt="logo">

<h2>
Puesto de Salud Cruz Blanca
</h2>

</div>



<!-- DERECHA -->

<div class="right">


<div class="back-top">

<a href="{{ route('login') }}">

← Login

</a>

</div>



<div class="title">

Crear cuenta

</div>


<div class="subtitle">

Registra un nuevo usuario del sistema

</div>



<form method="POST" action="{{ route('register') }}">

@csrf



<div class="group">

<label class="label">

Nombre

</label>


<input

id="name"

class="input"

type="text"

name="name"

value="{{ old('name') }}"

required

autofocus

autocomplete="name">


@error('name')

<div class="error">

{{ $message }}

</div>

@enderror


</div>




<div class="group">


<label class="label">

Correo electrónico

</label>


<input

id="email"

class="input"

type="email"

name="email"

value="{{ old('email') }}"

required

autocomplete="username">



@error('email')

<div class="error">

{{ $message }}

</div>

@enderror


</div>




<div class="group">


<label class="label">

Contraseña

</label>


<input

id="password"

class="input"

type="password"

name="password"

required

autocomplete="new-password">



@error('password')

<div class="error">

{{ $message }}

</div>

@enderror


</div>





<div class="group">


<label class="label">

Confirmar contraseña

</label>


<input

id="password_confirmation"

class="input"

type="password"

name="password_confirmation"

required

autocomplete="new-password">


@error('password_confirmation')

<div class="error">

{{ $message }}

</div>

@enderror


</div>




<div class="btn-area">


<button type="submit" class="btn">

Registrar

</button>


</div>



</form>


</div>


</div>


</x-guest-layout>