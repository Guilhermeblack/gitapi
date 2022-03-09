

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('value')
    }
});

$('.drag').on('mouseout', function(){
    $(this).siblings('td').css('background', 'transparent');
    $(this).css('background', 'transparent');
});
$('.drag').on('mouseover', function(){
    $(this).css('cursor', 'grab');
    $(this).css('background', '#DEB887');
    $(this).siblings('td').css('background', '#DEB887');
});
$('.drag').on('mousedown', function(){
    $(this).css('cursor', 'grabbing');
    $(this).css('background', '#D2691E');
    $(this).siblings('td').css('background', '#D2691E');
    $(this).on('mouseup', function(){
        $(this).css('cursor', 'grab');
        $(this).css('background', '#DEB887');
        $(this).siblings('td').css('background', '#DEB887');
    });
});

//   -=-=-=-=-=-=-=-==-=-===-=-=-=-=-=-=-=-=-=-=

var sub = 0;
$( ".sortable" ).sortable({
    stop : function( event, ui ) {
        // console.log('veio daqui', $(ui.item).parents('tr').find("td:eq(2)"));
        organiza_indice();
        calc_total()

    },
    handle: ".drag",
    items: ".lin",
}).disableSelection();


//   -=-=-=-=-=-=-=-==-=-===-=-=-=-=-=-=-=-=-=-=





$('#add_etapa').on('click',function(){
    // fazer o ajax e enviar o valor do botao para o campo:

    let nome = $('#etapa').val();
    let usr = $('#ident').val();
    let orc = $('#orc').val();

    // console.log(nome, usr);
    // console.log(vlr);
    let dat=0;

    // contar quantas linahs ja possui
    $('#tree').find('tbody > tr').each(function(){
        // se tiver ponto conto o ponto e separo nivel

        dat++;

    });

    $('#tree tbody').append("<tr style='color: #17202A' style='cursor:pointer;'><td id='checkbox' class='alignCenter drag'><i class='fas fa-arrows-alt'></i></td><td id='id' style='padding: 4px !important;'>"+(dat+1)+"</td><td id='tree'><b>"+nome.toUpperCase()+"</b></td><td class='alignCenter'><input name='total' style='width: 80%'' type='text' id='money'></td></tr>");

    $('#modal5').modal('hide');
    $('#etapa').val('');

    organiza_indice();
    calc_total()

});

//exclui etapa
$('#child-tem').on('click', function(){

    let token = $('[name= "_token"]').val();
    let etapa= $(this).closest('tr');
    let nome = etapa.children("td:eq(2)").text();
    let nv = etapa.children("td:eq(1)").text();

    let etapaid = etapa.children("td:eq(0)").attr('id');
    let orc = etapa.attr('name');

    nome = nome.replace(/\s/g, '');

    console.log(nome);
    nv = nv.replace(/\s/g, '');

    console.log(nv);
    console.log(etapaid);
    console.log(orc);

    $.ajax({
        type:"POST",
        url:'/etapa'+'?_token='+ token,
        data: {nome:nome, nv:nv, etapaid:etapaid, orc:orc},
        success: function(data){

            setTimeout(function(){
                // $('.lin').click();
                location.reload();
            }, 500);

        },
        error: function(data){
            alert('Erro ao salvar tabela -> '+data);
        }

    });

});




//       REFAZER O SALVA TABELA
$('#salva_tabel').on('click', function(){
    alert('tacagado');

    $('#tree').find('tbody > tr').each(function(){
    // let dele = $(this).val();

        //recursividade dos elementos filhos que tem sub-itens
        // let tutano = $(this).find("td:eq(2)").children('#child-tem');
        // console.log(tutano.children().length);



        let token = $('[name= "_token"]').val();

        let orca = $('#orc').val();
        let usr = $('#ident').val();

        let dala = $(this).find("td:eq(1)").text();
        dala = dala.replace(/\s/g, '');

        let dale = $(this).find("td:eq(2)").text();
        dale= dale.replace('|', '');
        dale = dale.replace(/\s/g, '');

        let dali = $(this).find("td:eq(3)").find('input').val();

        // console.log(token,' tkn');
        // console.log(orca,' usr');
        // console.log(dala,' nvl');
        // console.log(dale,' titul');
        // console.log(dali,' val');


        $.ajax({
            type:"POST",
            url:'/etapa'+'?_token='+ token,
            data: {nivel:dala,nome:dale, valor:dali, orca:orca, usr:usr},
            success: function(data){

                // $('#tree tbody').append("<tr style='color: #17202A' style='cursor:pointer;'><td id='checkbox' class='alignCenter'></td><td id='id' style='padding: 4px !important;'>"+(data.nivel)+"</td><td id='tree'><b>"+data.titulo+"</b></td><td class='alignCenter'><input name='total' style='width: 80%'' type='text' id='money'>"+data.valor+"</td></tr>");

                // message(' SALVO COM SUCESSO ');
                setTimeout(function(){
                    // $('.lin').click();
                    location.reload();
                }, 500);

            },
            error: function(data){
                alert('Erro ao salvar tabela -> '+data);
            }

        });

    // $(this).find('td').each(function(){

    // });
    });


});

function organiza_indice(){

    let nv = []
    // pega  nivel

    let tab = $('#tree').find('tbody');


    $('#tree').find('tbody > tr').each(function(){

        let val_nv = Math.abs($(this).find("td:eq(1)").text());
        // console.log(val_nv);
        nv[val_nv]= $(this).clone();
        console.log(nv[val_nv]);


    });

    // nv = nv.sort(nv)
    // console.log(nv[1.2]);

    // $('#tree').find('tbody').val(nv);
    //valido se tem filho
    // if(aux_element.children('#child-tem')[1] != null ){

    //     element.parent().last().find('#money').css('width','')
    //     let cont= element.siblings().last().find('.nv').text();

    //     if(!cont){
    //         cont = cont.split('.')[cont.length-1];
    //     }
    //     cont= parseFloat(cont)+1;
    //     // console.log(element.children('.child-tem').find('.nome-etapa').text());

    //     //defino o valor do nivel do nó atual
    //     let aux = element.parent().children('.nv').text();
    //     console.log(aux,' teve');
    //     element.children('.child-tem').find('.nv').text(aux+'.'+cont);

    //     // console.log(aux_element.children() );
    //     organiza_indice(aux_element.children('#child-tem').children('.lin').find("td:eq(2)"));

    // }else{

    //     let cont= element.siblings().last().find('.nv').text();

    //     // if(!cont){
    //     //     cont = cont.split('.')[cont.length-1];
    //     // }
    //     let aux = element.parent().children('.nv').text();

    //     //contar irmaos
    //     console.log(element.siblings().length);

    //     let numero_sub='';
    //     element.siblings().each(function(){
    //         console.log($(this).siblings().find('.nv').text(), ' vaaai fi');
    //         numero_sub = $(this).siblings().find('.nv').text();
    //     });
    //     // console.log(aux,' neeem tevu');
    //     element.children('.child-tem').find('.nv').text(aux+'.'+numero_sub);
    //     return console.log('nao tem mais filho');
    // }




}

function organiza_indice() {
    var nv = []; // pega  nivel

    var tab = $('#tree').find('tbody > tr');
    tab.each(function () {

        //linha atual
        var val_nv = $(this).find("td:eq(1)").text();
        val = val_nv.split('.')[0];
        val = Math.abs(val.replace(/\s/g, ''));

        //pego o anterior
        let anterior = $(this).prev().find("td:eq(1)").text();
        ant = anterior.split('.')[0];
        ant = Math.abs(ant.replace(/\s/g, ''));

        //pego o proximo
        let proximo = $(this).next().find("td:eq(1)").text();
        prox = proximo.split('.')[0];
        prox = Math.abs(prox.replace(/\s/g, ''));

        // TERMINAR A LOGICA DE ORGANIZAÇÃO DOS INDICES
        // organiza pelo primeiro numero do indice
        if(ant > val && ant != 0){
            $(this).after($(this).prev());

            console.log('trocou anterior maior', val,'<',ant);
            return organiza_indice();
        }
        if(prox < val && prox != 0){
            $(this).before($(this).next());
            console.log('trocou proximo menor ', val ,'>',prox);
            return organiza_indice();
        }
        if(ant == val){
            let nvar = $(this).find("td:eq(1)").text();
            nvar = nvar.replace(/\s/g, '');
            alert(nvar);
            $(this).text();
        }


    });
}

