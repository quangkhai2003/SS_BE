<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
//use App\Services\JwtService;

class UserService
{

    // protected $jwtService;

    // Method to create a new user
    public function create(array $data)
    {
        return [User::create([
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]),
        $mesage = 'Register success'
        ];
    }

    // Method to login a user
    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return "Email or password is incorrect";
        }
        return $user;
    }

    // Method to find a user by ID
    public function find($id)
    {
        return User::findOrFail($id);
    }

    // Method to update a user's information
    public function update($id, array $data)
    {
        $user = User::findOrFail($id);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return $user;
    }

    // Method to delete a user by ID
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return true;
    }
}