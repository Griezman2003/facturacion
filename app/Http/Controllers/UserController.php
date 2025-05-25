<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use PhpCfdi\Credentials\Credential;
use App\Notifications\NewUserRegistered;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Cookie;



class UserController extends Controller
{
    /**
     * texto de informativo de inicio para facturacion empresa
     *
     * @return void
     */
    public function login(){
        if (!session()->has('mensaje_mostrado')) {
            session()->flash('info', '
            Esta sección está destinada exclusivamente para empresas. Para continuar, asegúrate de contar con un RFC válido y que tus datos fiscales estén en regla, conforme a lo establecido en el Artículo 27 del Código Fiscal de la Federación (CFF) y el Artículo 29 del Reglamento del CFF.
            El uso indebido de información fiscal puede derivar en sanciones conforme a la legislación vigente. Si no cumples con estos requisitos, regresa a la página anterior.
            ');
            session(['mensaje_mostrado' => true]);
        }
        
        return view('page.login');
    }

    /**
     * Metodo que verifica la cuenta del usuario
     *
     * @param User $user
     * @return void
     */
    public function verificarCuenta(User $user)
    {
        if (!$user->usuarioFacturama || !$user->passwordFacturama) {
            return response()->json(['assigned' => false], 200);
        }
        return response()->json(['assigned' => true], 200);
    }
    

/**
 * Metodo que redirige al usuario
 *
 * @param User $user
 * @return void
 */
    public function esperar(User $user)
    {
        if (!$user) {
            return redirect()->route('user.login')->with('mensajeError', 'Usuario no encontrado. Por favor, inicia sesión.');
        }
        return view('espera.pantallaEspera');
    }

  
    public function nosotros(){
        return view('page.nosotros');
    }
    /**
    * metodo para iniciar sesion
    *
    * @param Request $request
    * @return void
    */
    public function iniciarSesion(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:255',
            'password' => 'required|string',
        ],
        [
            'usuario.required' => 'El campo usuario es obligatorio.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ]);
    
        $user = User::where('nombre_usuario', $request->usuario)->first();
        if (!$user) {
            return back()->withErrors([
                'usuario' => 'El usuario no existe.',
            ])->with('alert', ['mensaje', 'El usuario no existe']);
        }
        Auth::login($user);
        if ($user && Hash::check($request->password, $user->password)) {
            if (empty($user->usuarioFacturama) || empty($user->passwordFacturama)) {
                return redirect()->route('esperando', $user->id);
            }
            
            if ($user->rol === 'admin') {
                config(['session.cookie' => env('SESSION_COOKIE_ADMIN')]); 
                Auth::guard('admin')->login($user);
            } else {
                config(['session.cookie' => env('SESSION_COOKIE')]); 
                Auth::guard('web')->login($user); 
            }
    
            return $user->rol === 'admin' ? redirect()->route('admin') : redirect()->route('dashboard.index', $user);
        }
        return back()->withErrors([
            'usuario' => 'Las credenciales proporcionadas no son correctas.',
            'password' => 'Las credenciales proporcionadas no son correctas.',
        ])->onlyInput('usuario');
    }
    

            public function register(){
                return view('page.registro');
            }
            
            /**
            * metodo para registrar un usuario y guardarlo en la base de datos
            *
            * @param Request $request
            * @return void
            */
            public function registro(Request $request)
            {
                $validated = $request->validate([
                    'nombre_usuario' => ['required', 'string', 'max:255'],
                    'email' => ['required','email','max:255','regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/','unique:users,email'],
                    'ConfirmarEmail' => ['required', 'same:email'],
                    'password' => ['required', 'string'],
                ], [
                    'nombre_usuario.required' => 'El campo nombre de usuario es obligatorio.',
                    'email.required' => 'El campo correo es obligatorio para obtener su registro.',
                    'email.email' => 'El campo correo debe ser una dirección de correo válida.',
                    'email.regex' => 'El campo correo debe tener un formato válido con un dominio.',
                    'email.unique' => 'El correo ya está registrado.',
                    'ConfirmarEmail.required' => 'Debe confirmar su correo electrónico.',
                    'ConfirmarEmail.same' => 'Los correos electrónicos no coinciden.',
                    'password.required' => 'El campo contraseña es obligatorio.',
                    'password.confirmed' => 'Las contraseñas no coinciden.',
                ]);
                $user = User::create([
                    'nombre_usuario' => $validated['nombre_usuario'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                ]);
                $admin = User::where('rol', true)->first(); 
                Notification::send($admin, new NewUserRegistered($user));
                
                return redirect()->route('user.login')->with('mensaje', 'Usuario registrado exitosamente.');
            }
            
            /**
            * metodo para determinar si es una persona fisica o moral
            *
            * @param [type] $rfc
            * @return void
            */
            
            
            /**
            * metodo para cerrar la sesion
            *
            * @return void
            */
            public function salir(){
                Auth::logout();
                $cookie = config('session.cookie');
                return redirect()->route('home')->withCookie(Cookie::forget($cookie));
            }
            
            
            public function regimenFiscal(){
                $json = storage_path('../json/RegimenFiscal.json');
                $contenido_json = file_get_contents($json);
                $array_json = json_decode($contenido_json, true);
                return $array_json;
            }
            
            public function estado(){
                $json = storage_path('../json/Estados.json');
                $contenido_json = file_get_contents($json);
                $array_json = json_decode($contenido_json, true);
                return $array_json;
            }
            
            public function show(){
                $perfil = Auth::user()->perfil; 
                $regimenFiscal = $this->regimenFiscal();
                $estado = $this->estado();
                return view('page.perfil', compact('regimenFiscal', 'estado', 'perfil'));
            }
            
            /**
            *metodo de guardar datos perfil y se uso la libreria credential para transformar los certificados a .pem 
            *
            * @param Request $request
            * @return void
            */
            public function guardar(Request $request)
            {
                $user = auth()->user();
                
                if ($user->perfil) {
                    return redirect()->back()->with('mensajeError', 'Ya tienes un perfil creado. No puedes crear otro.');
                }
                $validated = $request->validate([
                    'tipo_persona' => 'required|in:moral,fisica',
                    'nombre_fiscal' => 'required|string|max:255',
                    'email' => 'required|email|unique:perfil,email',
                    'telefono' => 'required|string|max:15',
                    'tamano_empresa' => 'required|in:micro,pequena,mediana,grande',
                    'regimen_fiscal' => 'required|integer',
                    'ocupacion' => 'required|string|max:255',
                    'nombre_comercial' => 'required|string|max:255',
                    'codigo_postal' => 'required|string|max:10',
                    'calle' => 'required|string|max:255',
                    'numero_exterior' => 'required|string|max:50',
                    'num_interior' => 'required|string|max:50',
                    'colonia' => 'required|string|max:255',
                    'municipio' => 'required|string|max:255',
                    'estado' => 'required|string|max:255',
                    'pais' => 'required|string|max:255',
                    'rfc' => 'required|string|max:13',
                ]);
                // if ($request->hasFile('key_file')) {
                //     $keyFile = $request->file('key_file');
                //     $keyExtension = $keyFile->getClientOriginalExtension();
                
                //     if ($keyExtension !== 'key') {
                //         return back()->withErrors(['key_file' => 'El archivo debe tener la extensión .key']);
                //     }
                
                //     $keyContent = file_get_contents($keyFile->getPathname());
                // }
                // if ($request->hasFile('cer_file')) {
                //     $cerFile = $request->file('cer_file');
                //     $cerExtension = $cerFile->getClientOriginalExtension();
                
                //     if ($cerExtension !== 'cer') {
                //         return back()->withErrors(['cer_file' => 'El archivo debe tener la extensión .cer']);
                //     }
                
                //     $cerContent = file_get_contents($cerFile->getPathname());
                
                // try {
                //     $credential = Credential::create($cerContent, $keyContent, $validated['key_password']);
                //     $validated['key_file'] = $credential->privateKey()->pem();
                //     $validated['cer_file'] = $credential->certificate()->pem();
                // } catch (\Exception $e) {
                //     return back()->withErrors(['key_file' => 'No se pudo procesar la llave privada o el certificado. Verifica los archivos y la contraseña.']);
                // }
                $validated['user_id'] = Auth::id();
                Perfil::create($validated);
                return redirect()->route('dashboard.index')->with(['mensaje' => 'Perfil creado y guardado correctamente']);
            }
            
            
            
            
            //  Enviar código de 5 dígitos al correo
            public function sendResetCode(Request $request)
            {
                
                $email = $request->email ?? session('email');
                
                $request->validate([
                    'email' => 'required|email|exists:users,email',
                ]);
                
                $code = mt_rand(10000, 99999);
                
                DB::table('password_reset_tokens')->updateOrInsert(
                    ['email' => $email],
                    ['token' => $code, 'created_at' => Carbon::now()]
                );
                
                Mail::send('emails.reset_code', ['code' => $code], function ($message) use ($email) {
                    $message->to($email)->subject('Código de recuperación de contraseña');
                });
                
                \Log::info("Código enviado a {$email}: {$code}");
                
                session(['email' => $email]);
                
                return redirect()->route('password.reset.view');
            }
            
            
            
            // Mostrar la vista para ingresar el código
            public function showVerifyCodeForm(Request $request)
            {
                return view('empresa.passwords.verify_code')->with('email', session('email'));
            }
            
            // Verificar si el código ingresado es correcto
            public function verifyResetCode(Request $request)
            {
                $request->validate([
                    'email' => 'required|email|exists:users,email',
                    'code' => 'required|digits:5',
                ]);
                
                $record = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->where('token', $request->code)
                ->first();
                
                if (!$record) {
                    return back()->withErrors(['code' => 'El código ingresado es incorrecto o ha expirado.'])
                    ->withInput();
                }
                
                session(['verified' => true, 'email' => $request->email]);
                
                return redirect()->route('password.reset.view');
            }
            
            // Mostrar la vista de restablecer contraseña
            public function showResetPasswordForm()
            {
                return view('empresa.reset')->with('email', session('email'));
            }
            
            // Restablecer la contraseña desde el modal
            public function resetPassword(Request $request)
            {
                $request->validate([
                    'email' => 'required|email|exists:users,email',
                    'password' => 'required|confirmed|min:8',
                ]);
                
                $user = User::where('email', $request->email)->first();
                $user->update(['password' => Hash::make($request->password)]);
                
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();
                
                session()->forget(['email', 'verified']);
                
                return redirect()->route('user.login')->with('status', 'Contraseña restablecida correctamente.');
            }
            
            public function destroy(Request $request)
            {
                try {
                    $perfil = Auth::user()->perfil; 
                    
                    if (!$perfil) {
                        return redirect('/')->with('error', 'No se encontró un perfil para eliminar.');
                    }
                    
                    $perfil->delete();
                    
                    return redirect()->route('/')->with('success', 'Tu perfil ha sido eliminado correctamente.');
                } catch (\Exception $e) {
                    return redirect('/')->with('error', 'Error al eliminar el perfil: ' . $e->getMessage());
                }
            }
            
            public function eliminarUsuario($id)
            {
                $user = User::findOrFail($id);
                
                if (!$user) {
                    return redirect()->route('home')->with('error', 'No hay usuario autenticado.');
                }
                
                if ($user->perfil) {
                    $user->perfil->delete(); 
                }
                
                if ($user->empresa) {
                    $user->empresa->delete();  
                }
                $user->delete();
                return redirect()->route('home');
            }
        }