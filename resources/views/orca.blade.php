

@extends('base/base')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Orçamentos Geral </h3>
    </div>
    <div class="card shadow">
        <div class="row p-3">
            @foreach($orcamento as $orc)
            <div class="col-sm-6" style="margin-top: 8px;">
                <div class="card">
                <div class="card-body"  onclick="location.href = '/orcamento/{{$orc->id}}'" style="cursor:pointer;">
                    <div class="row">

                        <div class="col-sm ">
                            <p><b><u><h2 class="card-title" align='center'>{{$orc->titulo}}</h2></u></b>
                        </div>
                        <div class="col-sm">
                            <a class="btn btn-danger btn-sm-3 d-none d-sm-inline-block float-right" style="margin-right: 4px" role="button"  style="color: rgba(255,255,255,0.8);" ><i class="icon ion-android-cancel text-white"></i></a>
                        </div>

                    </div>
                    <h4><p class="card-text">Valor atual do Orçamento:<br> <b> R$ {{number_format($orc->total,2) ?? "0.00"}}</b></p></h4>
                  </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
