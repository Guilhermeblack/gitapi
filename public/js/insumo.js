

//preencher select ao selecionar empreendimento
$(document).on('change','#select_emp', function(){

    let tkn = $('#tkn_').val();
    let emp = this.value;
    $('#select_orc').find('option').detach();
    $('#tab_etp').empty();
    $('#select_orc').append('<option selected disabled><b> Orçamentos</b></option>');
    $.ajax({
        type:"POST",
        url:'/insumos'+'?_token=' + tkn,
        data: {emp:emp},
        success: function(data){


            // console.log(data);
            data.forEach(orc => {
                $('#select_orc').append('<option value="'+orc.id+'">'+orc.titulo+'</option>');
            });

        },
        error: function(data){
            alert('Erro ao listar orçamentos');
        }

    });

});


//açao ao selecionar o orçamento
$(document).on('change','#select_orc', function(){

    let tkn = $('#tkn_').val();
    let orc = this.value;
    $('#tab_etp').empty();
    $.ajax({
        type:"POST",
        url:'/insumos'+'?_token=' + tkn,
        data: {orc:orc},
        success: function(data){


            console.log(data);
            $('#tab_etp').append('<table ><thead class="table"><tr><th >NÍVEL</th><th > ETAPA</th><th >VALOR</th></tr></thead><tbody class="table">');
            data.forEach(etp => {

                $('#tab_etp').append('<tr id-etp="'+etp.id+'" class="table m-2" ><th scope="row">'+etp.nivel+'</th><td>'+etp.titulo+'</td><td>'+etp.valor+'</td>  </tr>');

            });
            $('#tab_etp').append('</tbody></table>');

        },
        error: function(data){
            alert('Erro ao recuperar etapas');
        }

    });

});
