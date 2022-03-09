

@extends('base/base')

@section('content')
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> --}}
<div class="container-fluid">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/pizza.css') }}" rel="stylesheet"> --}}
    <!-- Scripts -->
    <script src="{{ asset('js/insumo.js')}}"></script>


    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Insumos </h3>
    </div>
    <div class="card shadow">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="row p-3">
                    <input type="hidden" id='tkn_' value="{{ csrf_token() }}">
                    <div class="col-md-4 " >


                        <select class="selectpicker show-tick form-control" data-width="auto" id="select_emp">
                            {{-- <optgroup label="Empreendimento"> --}}
                                <option selected disabled><b> Empreendimentos</b></option>
                                @foreach ($empreendimento as $emp)
                                    <option value='{{$emp->id}}' data-tokens='{{$emp->titulo}}' >{{$emp->titulo}}</option>
                                @endforeach
                            {{-- </optgroup> --}}
                        </select>

                    </div>
                    <div class="col-md-4">
                        <select class="selectpicker show-tick form-control" data-live-search="true" data-width="auto" id='select_orc'>
                            <option selected disabled><b> Orçamentos</b></option>
                        </select>

                    </div>


                    <div class="col-md-2">

                    </div>
                    <div class="col-md-2 float-right" align='right'>
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle btn-sm" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-left: 25px!important;" id="planilhas">Planilhas <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                              <li><a class="btn btn-success btn-sm border border-dark rounded" style="color:cornsilk" aria-pressed="true" href="{{ URL::asset('planilhas_mod/modelo_insumo.xlsx') }}" ><b>Baixar Planilha Modelo</b></a></li>
                              <li class="divider"></li>
                              <li><a class="btn btn-success btn-sm border border-dark rounded" aria-pressed="true" style="color:cornsilk" href="#up_plan" data-toggle="modal" id="upload_planilha"><b>Subir Planilha Modelo</b></a></li>
                            </ul>
                            <p>
                            <p>
                        </div>
                    </div>
                </div>
            </div>
        <div class="modal" tabindex="-1" role="dialog" id="up_plan">
            <div class="modal-dialog" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Subir Planilha de Insumos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                    </div>
                    <form class="form-action" action="{{ url('/plan_etapa_insumo') }}" method="POST" enctype="multipart/form-data" id="envia_xlsx" >
                        {{csrf_field()}}
                        <div class="modal-body">
                            <div class="form-group">
                                {{-- <input type="hidden" name="id_usr" value="{{$cli->usr_id}}" id="id_usr"> --}}
                                <input type="hidden" name="usr_id" value="{{$cli->id}}" id="usr_id">
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
        <div class="row p-3">
            <div class="col" id="tab_etp">

            </div>
            <div class="col" >
                @foreach ($insumos as $ins)
                    <div>
                        <ul style='color: #17202A' style='cursor:pointer; align-text:center' class="lin" id="trneles">
                            <li>{{$ins->codigo}}</li>
                            <li>{{$ins->descricao}}</li>
                            <li>{{$ins->medida}}</li>
                            <li>{{$ins->preco}}</li>
                        </ul>

                    </div>
                @endforeach
            <div>
        </div>
        <div class="row">

        </div>
    </div>
</div>
@endsection
