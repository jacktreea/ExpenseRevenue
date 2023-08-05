<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected function resetPassword(Request $request)
    {
        var_dump($request->all());
        die();
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
die();
        $user = User::where('email', $request->email)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {

                $user->password = Hash::make($request->getPassword());

                $user->save();

                $response = ['message' => "success"];

                return response($response, 200);

            }else{
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        }else{

            $response = ["message" =>'User does not exist'];
            return response($response, 422);

        }

        event(new PasswordReset($user));
    }
    protected function sendResetResponse(Request $request, $response)
    {
        $response = ['message' => "Password reset successful"];
        return response($response, 200);
    }
    protected function sendResetFailedResponse(Request $request, $response)
    {
        $response = "Token Invalid";
        return response($response, 401);
    }
    protected $redirectTo = RouteServiceProvider::HOME;
}
