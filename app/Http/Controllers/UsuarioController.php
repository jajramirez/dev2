<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_USUA;

class UsuarioController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {

    	  $users = DB::table('SID_USUA')
            ->where('NOM_USUA', 'like', "%$request->name%")
            ->get();

        return view('usuarios.index')
       		->with('usuarios', $users);
    }
    

    public function create()
    {
        return view('usuarios.create');
    }   

    public function store(Request $request)
    {
        $max = $ccd = DB::table('SID_USUA')
            ->select(DB::raw('count(COD_USUA) as max'))
            ->get();
        $cod_usua = '0'. $max[0]->max + 1;

        $usuario = new SID_USUA($request->all());
        $usuario->COD_USUA = $cod_usua;
        if($usuario->IND_ESTA == "A")
        {
            $usuario->CON_USUA=str_replace(' ', '',bcrypt($request->CON_USUA));
        }
        else
        {
            $usuario->CON_USUA=bcrypt($request->CON_USUA). '  ';
        }
        $usuario->save();
        Flash::success("Se a creado correctamente el usuario");
        return redirect()->route('usuarios.index');

    }

    public function destroy($id)
    {
        $usuario = SID_USUA::find($id);
        $usuario->delete();
        Flash::success("Se ha eliminado correctamente");
        return redirect()->route('usuarios.index');

    }

    public function edit($id)
    {

        $usuario = SID_USUA::find($id);

        return view('usuarios.edit')
            ->with('usuario', $usuario);
    }


    public function update(Request $request, $id)
    {
        $usuario = SID_USUA::find($id);
        $usuario->fill($request->all());
        if($usuario->IND_ESTA == "A")
        {
            $usuario->CON_USUA=str_replace(' ', '', bcrypt($request->CON_USUA));
        }
        else
        {
            $usuario->CON_USUA=bcrypt($request->CON_USUA). '  ';
        }
        $usuario->save();
        
        Flash::warning("El usuario ".$request->NOM_USUA .", Se actualizó correctamente");
        return redirect()->route('usuarios.index');
    }      
}
