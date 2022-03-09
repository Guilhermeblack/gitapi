

@extends('base/base')



@section('content')

{{-- <script src="{{ URL::asset('js/const_tabela.js') }}"></script> --}}
<script src="https://immobilebusiness.com.br/admin/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ui-contextmenu/jquery.ui-contextmenu.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.fancytree/2.30.2/jquery.fancytree-all-deps.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link href="https://immobilebusiness.com.br/admin/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
<script src="https://immobilebusiness.com.br/admin/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ui-contextmenu/jquery.ui-contextmenu.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.fancytree/2.30.2/skin-win7/ui.fancytree.min.css" />
{{-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"> --}}

{{-- <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.fancytree/2.30.2/skin-win7/ui.fancytree.min.css" />

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>





<div class="container-fluid">



    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0" align='center'>{{$orca->titulo}}</h3>


    </div>
    <div class="card shadow">

        <div class="card-body">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="row float-right" align="right">
                        <div class="col-md-2 " >
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle btn-sm" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-left: 25px!important;" id="planilhas">Planilhas <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                  <li><a class="btn btn-success btn-sm border border-dark rounded" style="color:cornsilk" aria-pressed="true" href="{{ URL::asset('planilhas_mod/MODELO_ETAPA.xlsx') }}" ><b>Baixar Planilha Modelo</b></a></li>
                                  <li class="divider"></li>
                                  <li><a class="btn btn-success btn-sm border border-dark rounded" aria-pressed="true" style="color:cornsilk" href="#modal-message" data-toggle="modal" id="upload_planilha"><b>Subir Planilha Modelo</b></a></li>
                                </ul>
                                <p>
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-message" role="dialog" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Subir Planilha de Orçamento</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                            </div>
                            <form class="form-action" action="{{ url('/plan_etapa') }}" method="POST" enctype="multipart/form-data" id="envia_xlsx" >
                                {{csrf_field()}}
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="id_usr" value="{{$orca->usr_id}}" id="id_usr">
                                        <input type="hidden" name="id_orcamento_plan" value="{{$orca->id}}" id="id_orcamento_plan">
                                        <label for="exampleFormControlFile1"> Selecione seu arquivo .xlsx</label>
                                        <input type="hidden" name="MAX_FILE_SIZE" value="30000000" required="required">
                                        <input name="userfile" type="file" class="form-control-file" id="exampleFormControlFile1" required="required">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" id="cad_plan" name="cad_plan" value="Cadastrar" class="btn btn-success"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="panel-body table-wrapper-scroll-y my-custom-scrollbar" >
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs " role="tablist">
                            <li role="presentation" style="align-content: center; margin-left: 10%" class="active"><a href="#orc_material" type="button" aria-controls="orc_material" role="tab" data-toggle="tab" style="font-weight: bold;">Orçamento de Material</a></li>

                            <!-- <li role="presentation" style="align-content: center; margin-left: 30%"><a href="#orc_tarefa" aria-controls="orc_tarefa" type="button"  role="tab" data-toggle="tab" style="font-weight: bold;">Orçamento de Tarefas/Serviços</a></li> -->
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="orc_material">
                                <div class="row" align="center" id="div_input">

                                </div>
                                <table id="tree" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="alignCenter" style="width:3%; ">#</th>
                                            <th class="alignCenter" style="width:5%; ">ID</th>
                                            <th class="alignCenter" style="width:48%; ">Etapas</th>
                                            <th class="alignCenter" style="width:15px;">Valor Etapa</th>
                                        </tr>
                                    </thead>
                                    <tbody class="sortable" id="sortable">


                                        <!-- rotina para agregar sub itens -->
                                        {{-- <h2> {{$etapas}}</h2> --}}

                                        @if($etapas->count() > 0)
                                            @foreach ($etapas->sortBy('nivel') as $etap)
                                            {{-- <h2> {{$etap->titulo}}</h2> --}}

                                                <div>
                                                    <tr style='align-text:center; color: #17202A' name='{{$orca->id}}' class="lin" id="trneles">
                                                        <td  class='alignCenter drag'><i class="fas fa-arrows-alt"></i><input type="hidden" value="{{$etap->id}}" id="val_etapa"></td>
                                                        <td id='id_{{$etap->id}}' contentEditable="true" class="input nv" onclick='$(this).focus();' style='padding: 1px; margin:0 !important; align-content: center !important; height: 100% !important'>
                                                            {{$etap->nivel}}
                                                        </td>
                                                        <td id='tree' class="nome-etapa">  <b style="margin-bottom: 8px ">{{strtoupper($etap->titulo)}}</b><div style="align: center ;float: right; align-content: center; display:inline; width: 8%" class="child-tem bordered btn btn-danger justify-content-center " id="child-tem"><i  class="icon ion-android-cancel d-flex  text-white" style="padding-block-end: 5px;"></i></div></td>
                                                        <td class='valor' style="width:27%"><input name='total' value="{{$etap->valor}}" style='width: 78%; align: center' onblur="calc_total()" type='text' id='money_{{$etap->id}}'></td>
                                                    </tr>

                                                </div>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="modal" tabindex="-1" role="dialog" id='mod_message' >
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Ação inválida</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p>Provavelmente este índice já existe na tabela.</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-8">
                            <button class="btn btn-success btn-sm" id="salva_tabel">
                                @csrf
                                <span class="glyphicon glyphicon-floppy-disk" style="font-size: 10px;"></span>
                                Salvar Tabela
                            </button>
                            <button href="#modal5" data-toggle="modal" data-target="#modal5" class="btn btn-info btn-sm" id="nova_etapa">
                                <span class="glyphicon glyphicon-lock" style="font-size: 10px;"></span>
                                Adicioar Etapa
                            </button>
                            <div id="modal5" class="modal" role="dialog" style="background-color:transparent">
                                <div class="modal-dialog" >
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                    {{-- <form method="POST" > --}}
                                        <div class="modal-header">

                                            <h4 class="modal-title" style="text-transform: uppercase; text-align: left; font-weight: bold;">Etapa</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body" align="center">

                                            <h3>Insira uma nova etapa na tabela</h3>
                                            <p style="font-weight: bold;"></p>
                                            <input type="text" class="form-control form-control-user" style="text-transform: uppercase; font-weight:bold " id='etapa' name="etapa"  placeholder="Nome da Etapa..." />
                                            <input type="hidden" class="form-control form-control-user"  id='orc' name="orc" value="{{$orca->id}}" />
                                            <input type="hidden" class="form-control form-control-user"  id='ident' name="ident" value="{{$cli->id}}" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success btn-sm" id="add_etapa" name='add_etapa' >Adicionar</button>
                                            <button type="button" class="btn btn-defaut btn-sm" data-dismiss="modal">Cancelar</button>
                                        </div>
                                    {{-- </form> --}}
                                    </div>
                                </div>
                            </div>

                            <span class="glyphicon glyphicon-lock hidden" style="font-size: 25px; color: #343a40; padding-right: 15px;" id="orcamento_fechado"></span>


                            <!-- <button href="#modal-insumo" data-toggle="modal" data-target="#modal-insumo" class="btn btn-warning btn-md" id="add-insumo" style="margin-left:11%;">
                                <span class="glyphicon glyphicon-plus-sign" style="font-size: 10px;"></span>
                                Adicionar Item
                            </button> -->
                        </div>
                        {{-- <h2>{{$orca->id}}</h2> --}}
                        {{-- FAZER O AJAX PARA ENVIAR ISSO AQUI --}}
                        <div class="col-md-4" style="margin-right:0; padding-top:6px">
                            <a href="{{URL('/plan_etapa_ex/'.$orca->id )}}"> <button class="btn btn-danger btn-sm align-right" value="{{ $orca->id }}" id='export' style="background-color: #41863a; color: #FFF; border:none;" >Exportar Excel</button></a>

                            <a href="{{URL('/plan_etapa_pdf/'.$orca->id )}}"><button class="btn btn-danger btn-sm align-right" style="background-color: #41863a; color: #FFF; border:none;" >Exportar PDF</button></a>

                        </div>


                    </div>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-sm">
                </div>
                <div class="col-lg-6" >
                    <p>
                        <label><strong>Total</strong></label>
                        <input class="w3-input w3-border" aria-label="Large" aria-describedby="inputGroup-sizing-lg"  style=" font-weight:bold; height:92%; width:45%" id="total" type="text" disabled>
                    </p>
                </div>
                <div class="col-sm float-right">
                    @csrf

                    {{-- TERMINA ESSA EXCLUSÃO --}}
                    {{-- <button class="btn btn-danger btn-sm align-right" data-toggle="modal" data-target="#del_orc" value="{{ $orca->id }}" id='exc_orca' style="background-color: #ee4e5b; color: #FFF; border:none;" >Excluir Orçamento</button> --}}
                    <div role="dialog" id='del_orc' tabindex="-1" class="modal text-dark mx-auto justify-content-xl-start" style="background-color: rgba(207,199,199,0.13);height: 648px;width: 75%;padding: 7px;margin: 16px;margin-left: 0px;">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="height: 76px;width: 100%;">
                                    <h4 class="modal-title">Deletar Cadastro</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                                <div class="modal-body" style="width: 100%;margin: 3px;padding: 43px;">
                                    <form class="user" method="post" action="{{ URL('/orc') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" class="form-control form-control-user" id="orca_del" value="{{$orca->id}}" aria-describedby="User" name="orca_del"/>

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

    </div>

</div>

<script type="text/javascript" src="{{ asset('js/etapa.js') }}"></script>
<script type='text/javascript'>
    $(document).ready(function(){
        calc_total();
        $('.nv').on('mousedown', function(){

            let dale = $(this).text()
            dale= dale.replace(/\s/g, '');
            $(this).focus();
            // alert(dale);
            let tamanho = $(this).text().length;
            $(this).text('');
            $(this).text(dale);
            // console.log($(this));
            $(this).on('focus', function(){

                var range = document.createRange();
                var sel = window.getSelection();
                range.setStart($(this)[0], 1);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            });
            $(this).on('blur', function(){

                organiza_indice();
                // $('#salva_tabel').click();
            });


        })

    });
    function calc_total(){
        let val =0;
        let cham=0;
        $('#tree').find('tbody > tr').each(function(){
            cham = Math.abs($(this).find("td:eq(3)").find('input').val());
            if(cham >0){
                // console.log(cham);
                val += parseFloat(cham);
                // console.dir(val);
            }

        });

        $('#total').val(val);

    }
    function organiza_indice() {
        var nv = []; // pega  nivel

        var tab = $('#tree').find('tbody > tr');
        tab.each(function () {

            //linha atual
            var val_nv = $(this).find("td:eq(1)").text();
            // console.log(val_nv);
            if(val_nv != ''){
                val_split = val_nv.replace(/\s/g, '');
                if(val_split.indexOf('.') >-1){
                    val = Math.abs(val_split.split('.')[0]);
                }
                else{
                    val = Math.abs(val_split);
                }
            }


            //pego o anterior
            let anterior = $(this).prev().find("td:eq(1)").text();
            // console.log(anterior,' anterior');

            if(anterior){
                let ant_clean = anterior.replace(/\s/g, '');
                if(ant_clean.indexOf('.') >-1){
                    let ant = Math.abs(ant_clean.split('.')[0]);
                }else{
                    
                    let ant= Math.abs(ant_clean);
                }
            }else{ant =0, ant_clean= 0 }

            console.log(ant, ' clean and');

            //pego o proximo
            let proximo = $(this).next().find("td:eq(1)").text();
            if(proximo){
                prox_clean = proximo.replace(/\s/g, '');
                if(prox_clean.indexOf('.') >-1){
                    prox = Math.abs(prox_clean.split('.')[0]);
                }else{
                    
                    prox = Math.abs(prox_clean);
                }
            }else{prox =0, prox_clean=0 }

            console.log(prox, ' clean prox');
            console.log(Math.abs(val), ' oval');
            // console.log(ant);
            // TERMINAR A LOGICA DE ORGANIZAÇÃO DOS INDICES
            // organiza pelo primeiro numero do indice


            if(anterior!= ''){
                

                if(ant_clean == val_split){
                    $('#mod_message').modal('show');
                    setTimeout(function(){
                        $('#mod_message').modal('hide');
                        location.reload();
                    }, 3000);

                }

                if(ant > val && ant != 0){

                    $(this).after($(this).prev());


                    console.log('trocou anterior maior', val,'<',ant);
                    return organiza_indice();
                }
            }

            if(proximo!= ''){

                if(prox_clean == val_split){
                    $('#mod_message').modal('show');
                    setTimeout(function(){
                        $('#mod_message').modal('hide');
                        location.reload();
                    }, 3000);
                }

                if(prox < val && prox != 0){


                    $(this).before($(this).next());


                    console.log('trocou proximo menor ', val ,'>',prox);
                    return organiza_indice();

                }

            }


        });
    }

</script>
@endsection

