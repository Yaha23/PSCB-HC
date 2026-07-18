<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class PasswordOtpController extends Controller
{

public function form(){
return view('auth.forgot-otp');
}

public function send(Request $request)
{
$request->validate([
'email'=>'required|email'
]);

$code=rand(100000,999999);

DB::table('password_otps')->updateOrInsert(
['email'=>$request->email],
[
'code'=>$code,
'expires_at'=>now()->addMinutes(10),
'updated_at'=>now(),
'created_at'=>now()
]
);

Mail::raw("Tu código de recuperación es: $code", function($mail) use ($request){
$mail->to($request->email)
->subject('Código recuperación');
});

return back()->with(
'status',
'Código enviado al correo'
);
}

}
