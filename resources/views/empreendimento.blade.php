

@extends('base/base')

@section('content')
<div class="container-fluid">

        <script type="text/javascript">

            $(document).ready(function(){
                // fazer o ajax e enviar o valor do botao para o campo:

                $('#c_emp').click(function(){

                    $.ajax({
                        type: "GET",
                        url: 'emp'+'?_token=' + '{{ csrf_token() }}',
                        data: {select:'select'},
                        success: function(data){

                            // completar o request para pegar os tipo e jogar no select
                            let retorno='';

                            retorno += '<input type="hidden" class="form-control form-control-user" id="alterar" aria-describedby="User" value="'+data[0].id+'" name="alterar"/>'
                            retorno += '<div class="form-group"><input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp"  name="nome" value="'+data[0].nome+'" /></div>';
                            retorno += '<div class="form-group"><input type="email" class="form-control form-control-user" id="exampleInputPassword"  name="email" value="'+data[0].email+'" /></div>';
                            retorno += '<div class="form-group"><input type="text" class="form-control form-control-user" id="exampleInputPassword" placeholder="CPF/CNPJ" name="doc" value="'+data[0].doc+'"  /></div>';



                            $('#form_alter').append(retorno);

                        //     alert('chama');

                        }

                    });

                });

            });

        </script>

    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Empreendimentos</h3>@auth<a class="btn btn-primary btn-sm d-none d-sm-inline-block" id='c_emp' style="color: rgba(255,255,255,0.8);" role="button" data-toggle="modal" data-target="#cad_emp"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Novo Empreendimento</a>@endauth
        <div role="dialog" id='cad_emp' tabindex="-1" class="modal text-dark mx-auto justify-content-xl-start show" style="background-color: rgba(207,199,199,0.13);height: 648px;width: 75%;padding: 7px;margin: 16px;margin-left: 0px;">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="height: 76px;width: 100%;">
                        <h4 class="modal-title">Criar Novo empreendimento</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                    <div class="modal-body" style="width: 100%;margin: 3px;padding: 43px;">
                        <form class="user" method="POST" action="{{url('emp')}}">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="User" id='novo' name="novo" @if($cli)value="{{$cli->id}}"@endif />
                            {{--     condiçao para envias campo de identificaçao do cliente caso seja um cliente ao criar o empreendimento         --}}
                            {{-- <input type="hidden" class="form-control form-control-user" id="exampleInputEmail" id='novo_cli' name="cliente" value="1" /> --}}
                            <div class="form-group"><input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="NomeHelp" placeholder="Título empreendimento" name="titulo" /></div>
                            <div class="form-group"><textarea class="form-control form-control-user" rows="2" cols="20" id="obs" placeholder="Observação" name="obs" ></textarea></div>
                            <div class="form-group"><select class="form-control" name="tipo">
                                <optgroup label="Escolha Tipo empreendimento">
                                    <option value="-1" selected disabled>Tipo</option>
                                    <option value="2" >Reforma</option>
                                    <option value="3" >Casa</option>
                                    <option value="4" >Prédio</option>
                                    <option value="5" >Conjunto de casas</option>
                                    <option value="6" >Barracão</option>

                                </optgroup></select>
                            </div>
                            <div class="form-group"><select class="form-control" name="responsavel">
                                <optgroup label="Escolha Responsável">
                                    <option value="-1" selected disabled>Responsável</option>
                                    @foreach ($entidades as $key => $ent)
                                        @if($ent->tipo == 'Funcionário')
                                            <option value="{{$ent->id}}" > {{$ent->nome}}</option>

                                        @endif
                                    @endforeach
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
        </div>
        </div>
    </div>




    <div class="card shadow">

        <div class="card-body">
            <div class="row">
                {{-- {{$valores[1]}} --}}
                {{-- @foreach($valores[3] as $val) {{$val}} @endforeach --}}
            </div>
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                    <thead>
                        <tr>
                            <th> ID </th>
                            <th>Título</th>
                            <th>Responsável</th>
                            <th>Tipo</th>
                            <th>Data de Criação</th>
                            <th>Valor em Orçamentos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empreendimentos as $key => $em)

                            <tr onclick="location.href = 'empreendimento/{{$em->id}}'" style="cursor:pointer;">
                                <td>{{$em->id}}</td>
                                <td>{{ $em->titulo}}</td>
                                <td>@foreach ($entidades as $key => $ent)@if($ent->id == $em->resp) {{ $ent->nome}} @endif @endforeach</td>
                                <td>{{ $em->tipoe }}</td>
                                <td>{{ date('d-m-Y', strtotime($em->created_at))}}</td>
                            <td> R$ @foreach ($valores as $key => $val) @if($val->id == $em->id) {{ $val->total ?? "0.00"}}  @endif @endforeach </td>

                            </tr>

                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th> </th>
                            <th>{{'VALOR TOTAL'}}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{{$empreendimentos[0]->total}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
