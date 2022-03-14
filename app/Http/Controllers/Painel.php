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
use App\Cliente;
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

        $entidades = DB::table('clientes')
            ->join('users', 'clientes.usr_id', '=', 'users.id' )
            ->where('users.id', '=', $user->id)
            ->where('clientes.deleted_at',null)
            ->select('clientes.*')
            ->orderBy('name')
            ->get();

        return view('cad_geral', [

            'cli'=> $user,
            'cadastros'=>$entidades
        ]);

    }






    public function cad_geral(Request $request)
    {

        $cliente= auth()->user();

        
        // dd($cliente->id);
        //cadastros vinculados ao usuario
        if($cliente){

            $entidades = DB::table('clientes')
            ->join('users', 'clientes.usr_id', '=', 'users.id' )
            ->where('users.id', '=', $cliente->id)
            ->select('clientes.*')
            ->orderBy('name')
            ->get();

        }else
        {
            $entidades = '';
        }
                // dd($entidades[0]);
        // print_r($cliente->id); die();



        if ($request->isMethod('post')) {

            // dd($request);

            if($request->has('alter')){

                $var = $request->alter;
                // dd($var);
                $usr = DB::table('clientes')
                ->where('id', $var)->get();
                return $usr;

            }

            if($request->has('nome')){

                // dd($request);

                $url = "https://api.github.com/users/".$request->nome;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                // curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

                $dado =curl_exec($ch);
                
                curl_close($ch);

                $clie = new Cliente;
                // print_r($dado);
                // dd($clie);
                
                $lp = json_decode($dado,true);

                foreach( $lp as $d => $v){
                    if($d == 'id'){
                        $d = 'id_git';
                    }
                    
                    $clie->$d = $v;
                    if($clie->$d === null){
                        $clie->$d = '';
                    }
                    if(is_string($clie->$d)){
                        $clie->$d = utf8_encode($clie->$d);
                    }
                    
                }
                // dd(auth()->user()->id);
                $clie->usr_id = auth()->user()->id;
                if($clie->email === null){
                    $clie->email = $clie->login.'@git.com';
                }


                // dd($cliente);

                $clie->created_at = Carbon::now();




                $clie->save();


                $entidades = DB::table('clientes')
                ->join('users', 'clientes.usr_id', '=', 'users.id' )
                ->where('users.id', '=', $cliente->id)
                ->where('clientes.deleted_at', null)
                ->select('clientes.*')
                ->orderBy('name')
                ->get();

                
                // $entidades->senha = Crypt::decrypt($entidades->senha);

                return redirect()->route('cad', [

                    'cli'=>$cliente,
                    'cadastros'=> $entidades
                ]);


                

            }

            //rotina para deletar um usuario
            if($request->has('deletar')) {

                $client = $request->deletar;
                // dd($request);
                $usr = DB::table('clientes')
                ->where('id', $client)
                ->delete() ;

                $entidades = DB::table('clientes')
                ->join('users', 'clientes.usr_id', '=', 'users.id' )
                ->where('users.id', '=', $cliente->id)
                ->where('clientes.deleted_at',null)
                ->select('clientes.*')
                ->orderBy('name')
                ->get();

                return redirect()->route('cad', [

                    'cli'=>$cliente,
                    'cadastros'=> $entidades
                ]);

            }


                $email = $request->email;
                $nome = $request->nome;
                $senha = bcrypt($request->senha);
                $senha_rep= bcrypt($request->senha_rep);
                $usr= $request->logado;


                    //senha invalida
                    return redirect()->route('cad', [
                        'cli'=>$cliente,
                        'cadastros'=> $entidades
                    ])->withErrors('Cadastro invalido!');
                

        }else{

            $entidades = DB::table('clientes')
            ->join('users', 'clientes.usr_id', '=', 'users.id' )
            ->where('users.id', '=', $cliente->id)
            ->where('clientes.deleted_at',null)
            ->select('clientes.*')
            ->orderBy('name')
            ->get();

            // dd($entidades);


        }
                    
            



        

        //preencher os selects de cadastro de emp
        // $select_tipo =


        //   TESTAR A INSERÇÃO SETANDO OS PARAMETROS
        // dd($cliente);

        // print_r($cliente->id); die();
        return view('cad_geral', [

            'cli'=> $cliente,
            'cadastros'=>$entidades
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
