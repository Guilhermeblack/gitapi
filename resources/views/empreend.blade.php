

@extends('base/base')

@section('content')
<div class="container-fluid">

    <script type="text/javascript">

        $(document).ready(function(){

            if($('#tipo_emp option').val() == {{$emp->tipo}} ){
                console.log($('#tipo_emp option').val());
                $('option:selected',this);
            }

        });

        function monta_alt(value){
            // fazer o ajax e enviar o valor do botao para o campo:

            // let vlr = $('#monta_alt').val();
            console.log(value);
            // console.log(vlr);
            $.ajax({
                type:"POST",
                url:'/orc'+'?_token=' + '{{ csrf_token() }}',
                data: {alter:value},
                success: function(data){

                    data.forEach(fun => {
                        $('#responsavel').append('<option value="'+fun.id+'">'+fun.nome+'</option>');
                    });

                },

            });


        };

        function passa_val(val){

            $('#orca_del').val(val);

        };

    </script>

    <div class="d-sm-flex justify-content-between align-items-center mb-4">
    <h3 class="text-dark mb-0">Empreendimento @if($emp){{$emp->id}}@else {{'Detalhado'}}@endif</h3>@auth<a class="btn btn-primary btn-sm d-none d-sm-inline-block" id='c_emp' style="color: rgba(255,255,255,0.8);" role="button" data-toggle="modal" data-target="#cad_emp"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Novo Orçamento</a>@endauth
        <div role="dialog" id='cad_emp' tabindex="-1" class="modal text-dark mx-auto justify-content-xl-start show" style="background-color: rgba(207,199,199,0.13);height: 648px;width: 75%;padding: 7px;margin: 16px;margin-left: 0px;">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="height: 76px;width: 100%;">
                        <h4 class="modal-title">Criar Novo Orçamento</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                    <div class="modal-body" style="width: 100%;margin: 3px;padding: 43px;">
                        <form class="user" method="POST" action="{{url('orc')}}">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control form-control-user" id="new" aria-describedby="User" name="new" value="{{$cli->id}}" />
                            <input type="hidden" class="form-control form-control-user" id="emp" aria-describedby="User" name="emp" value="{{$emp->id}}" />

                            <div class="form-group"><input type="text" class="form-control form-control-user" id="exampleInputPassword" placeholder="Títilo do Orçamento" name="titulo" /></div>
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
            {{-- <form method='POST' action='{{url('#')}}'> --}}
                <div class="container">
                    <div class="row">

                        <div class="col-sm">
                        </div>

                        <div class="col-lg">
                            <u><h2><b>Titúlo: {{$emp->titulo}} </b></h2></u>

                        </div>

                        <div class="col-sm float-right"  >
                            <a class="btn btn-warning btn-sm-3 d-none d-sm-inline-block float-right" value='{{$emp->id}}' onclick="monta_alt({{$emp->id}})" id="monta_alt" role="button" data-toggle="modal" data-target="#alt_emp" name="monta_alt" style="margin-right: 6px; color: rgba(255,255,255,0.8);" ><i class="far fa-edit text-white"></i></a>
                            <a class="btn btn-danger btn-sm-3 d-none d-sm-inline-block float-right" style="margin-right: 4px" role="button" data-toggle="modal" data-target="#del_emp"  name="dele" style="color: rgba(255,255,255,0.8);" ><i class="icon ion-android-cancel text-white"></i></a>

                        </div>

                    </div>
                </div>
                <div role="dialog" id='del_emp' tabindex="-1" class="modal text-dark mx-auto justify-content-xl-start" style="background-color: rgba(207,199,199,0.13);height: 648px;width: 75%;padding: 7px;margin: 16px;margin-left: 0px;">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="height: 76px;width: 100%;">
                                <h4 class="modal-title">Deletar Empreendimento</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                            <div class="modal-body" style="width: 100%;margin: 3px;padding: 43px;">
                                <form class="user" method="post" action="/empreendimento/{{$emp->id}}">
                                    {{ csrf_field() }}

                                    <input type="hidden" class="form-control form-control-user" id="deletar" value="{{$emp->id}}" aria-describedby="User" name="deletar"/>
                                    <div class="form-group align-center" > <label><h3> Deseja mesmo deletar este empreendimento ?</h3></label></div>

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
                <div role="dialog" id='alt_emp' tabindex="-1" class="modal text-dark mx-auto justify-content-xl-start" style="background-color: rgba(207,199,199,0.13);height: 648px;width: 75%;padding: 7px;margin: 16px;margin-left: 0px;">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="height: 76px;width: 100%;">
                                <h4 class="modal-title">Alterar Empreendimento</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                            <div class="modal-body" style="width: 100%;margin: 3px;padding: 43px;">
                                <form class="user" method="post" action="/empreendimento/{{$emp->id}}" >
                                    {{ csrf_field() }}

                                    <input type="hidden" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="User" id='novo' name="altera_emp" @if($cli)value="{{$cli->id}}"@endif />
                                    {{--     condiçao para envias campo de identificaçao do cliente caso seja um cliente ao criar o empreendimento         --}}
                                    <input type="hidden" class="form-control form-control-user" id="exampleInputEmail" id='novo_cli' name="cliente" value='{{$emp->id}}' />
                                    <div class="form-group"><input type="text" class="form-control form-control-user" id="exampleInputPassword" id='titulo' name="titulo" value="{{$emp->titulo}}" placeholder="{{$emp->titulo}}" /></div>

                                    <div class="form-group"><textarea class="form-control form-control-user" rows="2" cols="20" id='obs' name="obs" value="{{$emp->obs}}" placeholder="{{$emp->obs}}" ></textarea></div>
                                    <div class="form-group"><select class="form-control" name="tipo">
                                        <optgroup label="Tipo Empreendimento">

                                            <option value="2" >Reforma</option>
                                            <option value="3" >Casa</option>
                                            <option value="4" >Prédio</option>
                                            <option value="5" >Conjunto de casas</option>
                                            <option value="6" >Barracão</option>
                                        </optgroup></select>
                                    </div>

                                    <div class="form-group"><select class="form-control " name="responsavel" id="responsavel">
                                        <optgroup label="Responsável">
                                            <h2>{{$func}}</h2>
                                            @foreach ($func as $fun)
                                                <option value='{{$fun->id}}'@if($emp->resp == $fun->id) selected @endif >{{$fun->nome}}</option>
                                            @endforeach

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
                <hr/>
                <div class="container" style="margin-top: 12px;">
                    <div class="row">
                    </div>
                    <div class="row">

                        <div class="col-sm 20%">
                            <h6><b>TIPO: {{$emp->tipoe}} </b></h6>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-sm">
                        </div>

                    </div>
                </div>
                <div class="container" style="margin-top: 12px;">
                    <div class="row">
                    </div>
                    <div class="row">

                        <div class="col-sm ">
                            <p><p>
                            <h6><b> RESPONSÁVEL:  {{$emp->nome}}  </b></h6>
                        </div>
                        <div class="col-sm">
                            <h6><b> OBSERVAÇÃO: </b></h6>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-sm ">
                        </div>
                        <div class="col-sm">
                            <b> {{$emp->obs}} </b>
                        </div>

                    </div>
                </div>


                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">

                </div>
                <div class="row" id='btn_md'>

                </div>
            {{-- </form> --}}
        </div>
        <hr/>
        <div class="row p-3">
            {{-- <h2>'                  {{$orcamento}}</h2> --}}
            @if($orcamento != [])
                @foreach($orcamento as $orc)
                <div class="col-sm-6" style="margin-top: 8px;">
                    <div class="card">
                    <div class="card-body" style="cursor:pointer;">
                        <div class="col-sm">

                        </div>
                        <div class="col-sm">
                            <a class="btn btn-danger btn-sm-3 d-none d-sm-inline-block float-right" onclick="passa_val({{$orc->id}})" id="delet_orc" style="margin-right: 4px" role="button" data-toggle="modal" data-target="#del_orc"  style="color: rgba(255,255,255,0.8);" ><i class="icon ion-android-cancel text-white"></i>
                            </a>
                        </div>
                        <div class="row" onclick="location.href = '/orcamento/{{$orc->id}}'">

                            <div class="col-lg ">
                                <p><h3 class="card-title" align='center'><b>{{$orc->titulo}}</b></h3>

                            </div>
                            <div style="width: 10%" class="col-sm">
                                {{-- <a class="btn btn-danger btn-sm-3 d-none d-sm-inline-block float-right" onclick="passa_val($orc->id)" id="delet_orc" style="margin-right: 4px" role="button" data-toggle="modal" data-target="#del_orc"  style="color: rgba(255,255,255,0.8);" ><i class="icon ion-android-cancel text-white"></i></a> --}}
                            </div>

                        </div>
                        <p class="card-text"> Valor Atual do Orçamento:  <b> R$ {{number_format($orc->total,2) ?? "0.00"}}</b></p>
                    </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-sm-6" style="margin-top: 8px;">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h2>{{$orcamento}}</h2>
                            <div class="col-sm ">
                                <p><h3 class="card-title" align='center'><b>{{'Sem Orçamentos '}}</b></h3>
                            </div>


                        </div>

                    </div>
                    </div>
                </div>
            @endif
        </div>
        <div role="dialog" id='del_orc' tabindex="-1" class="modal text-dark mx-auto justify-content-xl-start" style="background-color: rgba(207,199,199,0.13);height: 648px;width: 75%;padding: 7px;margin: 16px;margin-left: 0px;">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="height: 76px;width: 100%;">
                        <h4 class="modal-title">Deletar Empreendimento</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                    <div class="modal-body" style="width: 100%;margin: 3px;padding: 43px;">
                        <form class="user" method="post" action="{{ URL('/orc') }}">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control form-control-user" id="orca_del" value="{{$cli->id}}" aria-describedby="User" name="orca_del"/>

                            <input type="hidden" class="form-control form-control-user" id="deletar" value="{{$emp->id}}" aria-describedby="User" name="deletar"/>
                            <div class="form-group align-center" > <label><h3> Deseja mesmo deletar este orçamento ?</h3></label></div>

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
    </div>
</div>
@endsection
