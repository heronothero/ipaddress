<?php declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\IPInfo\IPAPIService;
use App\Models\User;

class RegisterController extends Controller
{
    protected $IPAPIService;
    public function __construct(IPAPIService $IPAPIService)
    {
        $this->IPAPIService = $IPAPIService;
    }
    public function showRegistrationForm(){
        return view('auth.register');
    }
    public function register(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'ip' => $request->ip(),
        ]);
        $ipDetails = $this->IPAPIService->getIPInfo($request->ip());
        return redirect('/')->with('success', 'Регистрация прошла успешно!');
    }
}
