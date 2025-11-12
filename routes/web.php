<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

use App\Models\User;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/setup', function() {

  $credentials = [
    'email'=> 'admin@gmail.com',
    'password'=> 'password'
  ];

  if (!Auth::attempt($credentials)) {

    $user = new App\Models\User();

    $user->name = 'admin';
    $user->email = $credentials['email'];
    $user->password = Hash::make($credentials['password']);
    $user->type = 'admin';
    $user->city = 'sohag';
    $user->state = 'egypt';
    $user->postal_code = '1234';


    $user->save();


    if (Auth::attempt($credentials)) {

      $user = Auth::user();

      $admin_token = $user->createToken('admin_token', ['create', 'update', 'delete']);
      $update_token = $user->createToken('update_token', ['create', 'update']);
      $basic_token = $user->createToken('basic_token', ['read']);

      return [
        'admin' => $admin_token->plainTextToken,
        'update' => $update_token->plainTextToken,
        'basic' => $basic_token->plainTextToken,
      ];
    }
  }


});


// {
//   "admin": "2|IiSqNUFqJlJF5AnstZ9Tb5rL7fEms6wxsZCDqqJp8650c618",
//   "update": "3|jesTTEFZ1hxmyw2Gkof2iMmfCUetZuqgweP7HOJz56e65ea0",
//   "basic": "4|i1tfLRguXXC8eDW0mw442XYYOgPBGTtLG2FLIXpl8cba480c"
// }
