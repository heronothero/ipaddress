<?php declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\IPInfo\IPAPIService;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * IPAPIService instance
     * @var IPAPIService
     */
    protected $IPAPIService;

    /**
     * Create a new controller instance
     * @param IPAPIService $IPAPIService
     */
    public function __construct(IPAPIService $IPAPIService)
    {
        $this->IPAPIService = $IPAPIService;
    }

    /**
     * Show registration form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showRegistrationForm(){
        return view('registration');
    }

    /**
     * Handle the registrration request
     * @param Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
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
        $this->IPAPIService->getIPInfo($request->ip());
        return redirect('/')->with('success', 'Регистрация прошла успешно!');
    }
}
