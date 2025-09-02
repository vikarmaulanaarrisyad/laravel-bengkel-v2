namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Login Ajax
    public function loginAjax(Request $request)
    {
        $request->validate([
            'auth' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah input berupa email atau username
        $fieldType = filter_var($request->auth, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $credentials = [$fieldType => $request->auth, 'password' => $request->password];

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return response()->json(['message' => 'Berhasil login']);
        }

        return response()->json(['message' => 'Email/Username atau password salah'], 422);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
