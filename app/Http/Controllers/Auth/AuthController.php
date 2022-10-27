<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CasosPruebas;
use App\Models\User;
use App\Models\Variable;
use Session;
use Hash;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){

            $user = Auth::user();

            $ola = Variable::where('variable', 'Ola')->first();

            if($user->rol == "administrador"){

                //$cps = CasosPruebas::all();
                $cps = DB::table('casos_prueba')
                    ->join('olas', 'casos_prueba.id', '=', 'olas.cp_id')
                    ->select('casos_prueba.*', 'olas.estado')
                    ->where('olas.num_ola', $ola->valor)
                    ->get();

            }else {

                //$cps = CasosPruebas::where('user_id', $user->id)->get();
                $cps = DB::table('casos_prueba')
                    ->join('olas', 'casos_prueba.id', '=', 'olas.cp_id')
                    ->select('casos_prueba.*', 'olas.estado')
                    ->where('casos_prueba.user_id', $user->id)
                    ->get();
            }
            
            return View('dashboard')
                ->with('cps', $cps);
        }
  
        return redirect("login")->withSuccess('Opps! No tiene acceso.');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

    public function userMetrics($id)
    {   

        //$user = auth('api')->user();

        //if($user->rol == "administrador"){

            //$desestimados = Ola::where([['estado', '=', 'desestimado']])->count();
            $desestimados = DB::table('olas')
                ->join('casos_prueba', 'casos_prueba.id', '=', 'olas.cp_id')
                ->select('olas.*')
                ->where([['olas.estado', '=', 'desestimado'],['casos_prueba.user_id', '=', $id]])
                ->count();
            //$fallidos = Ola::where([['estado', '=', 'fallido']])->count();
            $fallidos = DB::table('olas')
                ->join('casos_prueba', 'casos_prueba.id', '=', 'olas.cp_id')
                ->select('olas.*')
                ->where([['olas.estado', '=', 'fallido'],['casos_prueba.user_id', '=', $id]])
                ->count();
            //$exitosos = Ola::where([['estado', '=', 'exitoso']])->count();
            $exitosos = DB::table('olas')
                ->join('casos_prueba', 'casos_prueba.id', '=', 'olas.cp_id')
                ->select('olas.*')
                ->where([['olas.estado', '=', 'exitoso'],['casos_prueba.user_id', '=', $id]])
                ->count();
            //$pendientes = Ola::where([['estado', '=', 'pendiente']])->count();
            $pendientes = DB::table('olas')
                ->join('casos_prueba', 'casos_prueba.id', '=', 'olas.cp_id')
                ->select('olas.*')
                ->where([['olas.estado', '=', 'pendiente'],['casos_prueba.user_id', '=', $id]])
                ->count();
        //}

        $data =[
            'labels'  => ['Desestimados', 'Fallidos', 'Exitosos', 'No Ejecutados'],
            'datasets' => [
                [
                  'backgroundColor' => ['#013461', '#FF287A','#019500', 'silver'],
                  'data' => [$desestimados, $fallidos, $exitosos, $pendientes]
                ],
            ]
        ];

        return response()->json($data);
    }
}
