<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class AuthController extends Controller
{
    use PasswordValidationRules;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_name'=>'required',
            'password'=>'required|min:8',
        ]);

        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $credentials = [
                    $this->username() => $request->user_name,
                    'password' => $request->password,
                    'status' => config('constant.active'),
                ];
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Welcome Back. Login Successfully', route('dashboard'));
                } else {
                    throw new Exception('The provided credentials do not match our records.');
                }
            } catch (Exception $ex) {
                DB::rollBack();
                return ResponseTrait::AllResponse('error', Response::HTTP_NOT_ACCEPTABLE, 'The provided credentials do not match our records.');
            }
        }else{
            return ResponseTrait::ValidationResponse(array_values($validator->errors()->getMessages()), 'validation', Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * Check either username or email.
     * @return string
     */
    public function username()
    {
        $identity  = request()->get('user_name');
        $fieldName = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        request()->merge([$fieldName => $identity]);
        return $fieldName;
    }
}
