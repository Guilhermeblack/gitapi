<?php


namespace App\Http\Controllers;
use Illuminate\Routing\Redirector;
// use Illuminate\Routing\Redirect;
// use App\Http\Controllers\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;


//          CONTROLLER
class Painel extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        return view('index', [
            'cli'=> $user
        ]);
    }

    public function login(Request $request){

        // \/ pesquisa ja existente      first pega o primeiro registro
    $cliente= auth()->user();

        //   dd($cliente);
        //   TESTAR A INSERÇÃO SETANDO OS PARAMETROS

    return view('login', [
        'cli'=> $cliente
    ]);

}
}
