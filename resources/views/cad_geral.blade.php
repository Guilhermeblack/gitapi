

@extends('base/base')

@section('content')
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> --}}

<div class="container-fluid">
    <script type="text/javascript">

        // $(document).ready(function(){
            // fazer o ajax e enviar o valor do botao para o campo:
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

            $('#add_cli').click(function(){

                var valor = $('#add_cli').attr('value');
                // valor = valor;
                

                $('input#logado').val(valor);
            });
            
        // });

    </script>

    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div role="dialog" id='cad_cli' tabindex="-1" class="modal text-dark mx-auto justify-content-xl-start" style="background-color: rgba(207,199,199,0.13);height: 648px;width: 75%;padding: 7px;margin: 16px;margin-left: 0px;">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="height: 76px;width: 100%;">
                        <h4 class="modal-title">Cadastro Geral</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                    <div class="modal-body" style="width: 100%;margin: 3px;padding: 43px;">
                        <form class="user" method="POST" action="{{url('cad')}}">
                            {{ csrf_field() }}
                        {{-- <h2>{{$cli->id}}</h2> --}}
                            <input type="hidden" class="form-control form-control-user" id="logado" aria-describedby="User" name="logado" id="logado" value="{{$cli->id}}" />
                            <div class="form-group"><input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Nome" name="nome" /></div>
                            <div class="form-group"><input type="email" class="form-control form-control-user" id="exampleInputPassword" placeholder="Email" name="email" /></div>
                            <div class="form-group"><input type="text" class="form-control form-control-user" id="exampleInputPassword" placeholder="CPF/CNPJ" name="doc" /></div>
                            <div class="form-group"><input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Senha" name="senha" /></div>
                            <div class="form-group"><input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Confirme a senha" name="senha_rep" /></div>

                            <div class="form-group"><select class="form-control" name="tipo">
                                <optgroup label="Tipo Cadastro">
                                    <option value="2" >Funcionário</option>
                                    <option value="3" >Compras</option>
                                    <option value="4" >Fornecedor</option>
                                    <option value="5" >Geral</option>
                                </optgroup></select>
                            </div>
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
                {{-- <div class="col-md-6 text-nowrap">
                    <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label>Show <select class="form-control form-control-sm custom-select custom-select-sm"><option value="10" selected>10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select></label></div>
                </div>
                <div class="col-md-6">
                    <div class="text-md-right dataTables_filter" id="dataTable_filter"><label><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search" /></label></div>
                </div> --}}
            </div>
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF/CNPJ</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Data de Criação</th>
                            <th>Alterar/Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                    {{-- <h2>{{ $cadastros}}</h2> --}}
                    @if($cadastros)
                        @foreach($cadastros as $cad)
                        <div>

                            <tr>
                                
                                <td>{{ $cad->nome}}</td>
                                <td>{{ $cad->doc}}</td>
                                <td>{{ $cad->email}}</td>
                                <td>{{ $cad->tipo}}</td>
                                <td>{{ date('d-m-Y', strtotime($cad->created_at))}}</td>
                                <td style="padding-left:5%; ">
                                    {{-- gerar rotina de exclusao e alteração --}}
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
                            <th>CPF/CNPJ</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Data de Criação</th>
                            <th>Alterar/Excluir</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando 1 to 10 of 27</p>
                </div>
                <div class="col-md-6">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        <ul class="pagination">
                            <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                        </ul>
                    </nav>
                </div>
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
                    {{-- <h2>{{$cad->id}}</h2> --}}
                    <hr/>
                    <button class="btn btn-muted btn-block text-white d-lg-flex mx-auto justify-content-lg-center btn-user" type="button" data-dismiss="modal" style="background-color: rgb(220,65,65);width: 378px;padding-left: 22px;margin-left: 0px;">SAIR</button>
                    <hr />
                </form>
            </div>
        </div>
    </div>
</div>
<div role="dialog" id='alt_cli' tabindex="-1" class="modal text-dark mx-auto justify-content-xl-start" style="background-color: rgba(207,199,199,0.13);height: 648px;width: 75%;padding: 7px;margin: 16px;margin-left: 0px;">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header" style="height: 76px;width: 100%;">
                <h4 class="modal-title">Alterar cadastro</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
            <div class="modal-body" style="width: 100%;margin: 3px;padding: 43px;">
                <form class="user" method="post" action="{{url('cad')}}" id='alter_cli'>
                    {{ csrf_field() }}
                    <div id='form_alter'>

                    </div>
                    <div class="form-group"><input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Nova senha..." name="senha"  /></div>
                    <div class="form-group"><select class="form-control" name="tipo">
                        <optgroup label="Tipo Cadastro">
                            <option selected>Alterar tipo</option>
                            <option value="2" >Funcionário</option>
                            <option value="3" >Compras</option>
                            <option value="4" >Fornecedor</option>
                            <option value="5" >Geral</option>
                            
                        </optgroup></select>
                    </div>
                    <button class="btn btn-primary btn-block text-white mx-auto btn-user" type="submit">ALTERAR</button>
                    <hr/>
                    <button class="btn btn-muted btn-block text-white d-lg-flex mx-auto justify-content-lg-center btn-user" type="button" data-dismiss="modal" style="background-color: rgb(220,65,65);width: 378px;padding-left: 22px;margin-left: 0px;">SAIR</button>
                    <hr />
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
