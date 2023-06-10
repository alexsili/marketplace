<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'user_type'    => ['required', 'string', 'max:10'],
            'company_name' => ['required_if:user_type,==,seller'],
            'company_cui'  => ['required_if:user_type,==,seller'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        if ($data['user_type'] == 'seller') {
            $company = Company::where('cui', $data['company_cui'])->first();
            if ($company == null) {
                $company   = Company::create([
                    'name' => $data['company_name'],
                    'cui'  => $data['company_cui'],
                ]);
                $companyId = $company->id;
            } else {
                $companyId = $company->id;
            }
        } else {
            $companyId = 0;
        }

        $user = User::create([
            'company_id' => $companyId,
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'user_type'  => $data['user_type'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
        ]);

        $user->save();
        return $user;

    }
}
