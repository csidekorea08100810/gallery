<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use Validator;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\ThrottlesLogins;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->middleware('guest', ['except' => ['logout', 'getLogout']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        if (isset($data['image'])) {
            $imageName = time() . '.' . $data['image']
                                 ->getClientOriginalExtension();
                
            // resizing an uploaded file
            Image::make(
                $data['image'])
                ->crop(
                    $data['image_w'], 
                    $data['image_h'], 
                    $data['image_x'], 
                    $data['image_y'])
                ->save('uploads/'.$imageName);

            $data['image'] = $imageName;
        } else {
            $data['image'] = '';
        }
        

        if ($validator->fails()) {
            return redirect('/auth/register')
                    ->withErrors($validator)
                    ->withInput();
        } else {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'image' => $data['image'],
                'intro' => $data['introduction'],
                'phone' => $data['p_num1'].$data['p_num2'].$data['p_num3'],
            ]);
        }
        
    }
}
