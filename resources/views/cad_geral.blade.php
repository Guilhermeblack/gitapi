

@extends('base/base')

@section('content')


<div class="container-fluid">
    <script type="text/javascript">


            function monta_alt(value){
                
                
                $('#form_alter').empty();
                $.ajax({
                    type: "POST",
                    url: 'cad'+'?_token=' + '{{ csrf_token() }}',
                    data: {'alter':value},
                    success: function(data){

                        // console.log(data[0].id);
                        $('#form_alter').empty();
                        let retorno='';

                        retorno += '<input type="hidden" class="form-control form-control-user" id="alterar" aria-describedby="User" value="'+data[0].id+'" name="alterar"/>'
                        retorno += '<div class="form-group"><input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp"  name="nome" value="'+data[0].nome+'" /></div>';
                        retorno += '<div class="form-group"><input type="email" class="form-control form-control-user" id="exampleInputPassword"  name="email" value="'+data[0].email+'" /></div>';
                        retorno += '<div class="form-group"><input type="text" class="form-control form-control-user" id="exampleInputPassword" placeholder="CPF/CNPJ" name="doc" value="'+data[0].doc+'"  /></div>';


                        
                        $('#form_alter').append(retorno);

                    //     alert('chama');

                    }
                    
                });
            };

            function monta_del(value){

                console.log(value);
                $('input#deletar').val(value);
            };

            function infoc(value){
                // alert(value);
                $('#umcli'+value).toggle();
                
            };



            $('.lin').mouseup(function(){

                // alert('uaiia');
                $(this).style.cursor = "pointer";
                
            });

            $('#add_cli').click(function(){

                var valor = $('#add_cli').attr('value');

                $('input#logado').val(valor);
            });
            


    </script>

    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div role="dialog" id='cad_cli' tabindex="-1" class="modal text-dark mx-auto justify-content-xl-start" style="background-color: rgba(207,199,199,0.13);height: 648px;width: 75%;padding: 7px;margin: 16px;margin-left: 0px;">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="height: 76px;width: 100%;">
                        <h4 class="modal-title">Consulta</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                    <div class="modal-body" style="width: 100%;margin: 3px;padding: 43px;">
                        <form class="user" method="POST" action="{{url('cad')}}">
                            {{ csrf_field() }}
                        {{-- <h2>{{$cli->id}}</h2> --}}
                            <input type="hidden" class="form-control form-control-user" id="logado" aria-describedby="User" name="logado" id="logado" value="{{$cli->id}}" />
                            <div class="form-group"><input type="text" class="form-control form-control-user" id="nome" aria-describedby="nomelHelp" placeholder="Nome" name="nome" /></div>
                            
                            <button class="btn btn-primary btn-block text-white mx-auto btn-user" type="submit">CADASTRAR</button>
                            <hr/>
                            <button class="btn btn-primary btn-block text-white d-lg-flex mx-auto justify-content-lg-center btn-user" type="button" data-dismiss="modal" style="background-color: rgb(220,65,65);width: 378px;padding-left: 22px;margin-left: 0px;">SAIR</button>
                            <hr />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <h3 class="text-dark mb-0">Clientes</h3>@auth<a class="btn btn-primary btn-sm d-none d-sm-inline-block" id="add_cli" name="add_cli" style="color: rgba(255,255,255,0.8);" role="button" data-toggle="modal" data-target="#cad_cli" value="{{$cli->id}}"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Novo Cadastro</a>@endauth
        
        </div>
        </div>
    </div>




    <div class="card shadow">
            
        <div class="card-body">
            <div class="row">

            </div>
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>login</th>
                            <th>Data de Criação</th>
                            <th>Alterar/Excluir</th>
                        </tr>
                    </thead>
                    <tbody>

                    @if($cadastros)
                        @foreach($cadastros as $cad)

                        <div>

                            <tr>
                                
                                <td  onmouseover="this.style.cursor = 'pointer';" onmouseout="this.style.cursor = 'auto';" onclick="infoc({{$cad->id}});">{{ $cad->name}}</td>
                                <td onmouseover="this.style.cursor = 'pointer';" onmouseout="this.style.cursor = 'auto';" onclick="infoc({{$cad->id}});">{{ $cad->login}}</td>
                                <td onmouseover="this.style.cursor = 'pointer';" onmouseout="this.style.cursor = 'auto';" onclick="infoc({{$cad->id}});">{{ date('d-m-Y', strtotime($cad->created_at))}}</td>
                                <td style="padding-left:5%; ">
                                    <!-- {{-- gerar rotina de exclusao e alteração --}} -->
                                <a class="btn btn-warning btn-sm d-none d-sm-inline-block" role="button" data-toggle="modal" data-target="#alt_cli" name="alt" id="{{$cad->id}}" onclick="monta_alt({{$cad->id}})" style="margin-right: 6px; color: rgba(255,255,255,0.8);" value="{{ $cad->id}}"><i class="far fa-edit text-white"></i></a>
                                <a class="btn btn-danger btn-sm d-none d-sm-inline-block" role="button" data-toggle="modal" data-target="#del_cli"  name="dele" id="{{$cad->id}}" onclick="monta_del({{$cad->id}})" style="color: rgba(255,255,255,0.8);" value="{{ $cad->id}}"><i class="icon ion-android-cancel text-white"></i></a>
                                    
                                </td>
                                
                            </tr>
                        </div>


                        
                      

                        @endforeach
                    @endif

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Data de Criação</th>
                            <th>Alterar/Excluir</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</div>
<div role="dialog" id='del_cli' tabindex="-1" class="modal text-dark mx-auto justify-content-xl-start" style="background-color: rgba(207,199,199,0.13);height: 648px;width: 75%;padding: 7px;margin: 16px;margin-left: 0px;">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header" style="height: 76px;width: 100%;">
                <h4 class="modal-title">Deletar Cadastro</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
            <div class="modal-body" style="width: 100%;margin: 3px;padding: 43px;">
                <form class="user" method="post" action="{{url('cad')}}">
                    {{ csrf_field() }}
                
                    <input type="hidden" class="form-control form-control-user" id="deletar" value="{{$cli->id}}" aria-describedby="User" name="deletar"/>
                    <div class="form-group align-center" > <label><h3> Deseja mesmo deletar este usuário ?</h3></label></div>
                    
                    <button class="btn btn-danger btn-block text-warning mx-auto btn-user" type="submit">DELETAR</button>
                    <hr/>
                    <button class="btn btn-muted btn-block text-white d-lg-flex mx-auto justify-content-lg-center btn-user" type="button" data-dismiss="modal" style="background-color: rgb(220,65,65);width: 378px;padding-left: 22px;margin-left: 0px;">SAIR</button>
                    <hr />
                </form>
            </div>
        </div>
    </div>
</div>

@if($cadastros)
@foreach($cadastros as $cad)
  <!-- CLIENTE -->
  <div role="dialog" id='umcli{{$cad->id}}'  tabindex="-1" class="modal  text-dark mx-2 " style="background-color: rgba(207,199,199,0.13);height: auto;width: 800px;padding: 7px;margin: 16px;">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content" style="width: 100%;">
                <div class="modal-header" style="width: 100%;">
                    <h4 class="modal-title">Dados Cadastro</h4><button type="button" onclick="infoc({{$cad->id}});" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body" style="width: 100%;margin: 3px;padding: 43px;">

                    
                        
                            <ul>
                                @foreach($cad as $c => $v)
                                    <li>{{$c}}: ____  {{$v}}</li>

                                    

                                    
                                @endforeach
                                    
                            </ul>
                            
    

                        


                        <button class="btn btn-muted btn-block text-white d-lg-flex mx-auto justify-content-lg-center btn-user" type="button" data-dismiss="modal" onclick="infoc({{$cad->id}});" style="background-color: rgb(220,65,65);width: 378px;padding-left: 22px;margin-left: 0px;">SAIR</button>
                        <hr />
                    
                </div>
            </div>
        </div>
    </div>

@endforeach
@endif
@endsection
