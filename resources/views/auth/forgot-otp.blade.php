<x-guest-layout>

<h2>Recuperar con código OTP</h2>

<form method="POST" action="{{ route('password.otp.send') }}">
@csrf

<input
type="email"
name="email"
placeholder="Correo"
required>

<button type="submit">
Enviar código
</button>

</form>

<a href="{{ route('login') }}">
Volver al login
</a>

</x-guest-layout>