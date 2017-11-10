<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use \Milon\Barcode\DNS1D;

class BarraController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

     public function index(Request $request)
    {
        return view('barras.index');
    }

    public function create(Request $request)
    {
        $d = new DNS1D();
        $d->setStorPath(__DIR__."/cache/");
        //echo $d->getBarcodeHTML("2", "EAN13");
        return view('barras.lista')
            ->with('desde', $request->desde)
            ->with('hasta', $request->hasta)
            ->with('d', $d);
    }

}
