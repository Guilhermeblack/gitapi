/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/etapa.js":
/*!*******************************!*\
  !*** ./resources/js/etapa.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('value')
    }
    });
    $('.drag').on('mouseout', function () {
    $(this).siblings('td').css('background', 'transparent');
    $(this).css('background', 'transparent');
    });
    $('.drag').on('mouseover', function () {
    $(this).css('cursor', 'grab');
    $(this).css('background', '#DEB887');
    $(this).siblings('td').css('background', '#DEB887');
    });
    $('.drag').on('mousedown', function () {
    $(this).css('cursor', 'grabbing');
    $(this).css('background', '#D2691E');
    $(this).siblings('td').css('background', '#D2691E');
    $(this).on('mouseup', function () {
        $(this).css('cursor', 'grab');
        $(this).css('background', '#DEB887');
        $(this).siblings('td').css('background', '#DEB887');
    });
    }); //   -=-=-=-=-=-=-=-==-=-===-=-=-=-=-=-=-=-=-=-=

    var sub = 0;
    $(".sortable").sortable({
    stop: function stop(event, ui) {
        // console.log('veio daqui', $(ui.item).parents('tr').find("td:eq(2)"));
        organiza_indice();
        calc_total();
    },
    handle: ".drag",
    items: ".lin"
    }).disableSelection(); //   -=-=-=-=-=-=-=-==-=-===-=-=-=-=-=-=-=-=-=-=

    //adiciona etapa
    $('#add_etapa').on('click', function () {
        // fazer o ajax e enviar o valor do botao para o campo:
        var nome = $('#etapa').val();
        var usr = $('#ident').val();
        var orc = $('#orc').val(); // console.log(nome, usr);
        // console.log(vlr);

        var dat = 0; // contar quantas linahs ja possui

        let nvl = $('#tree').find('tbody > tr:last').children('.nv').text();
            nvl = nvl.split('.')[0];
            nvl = Math.abs(nvl.replace(/\s/g, ''));
            console.log(nvl);

        $('#tree tbody').append("<tr style='color: #17202A' style='cursor:pointer;'><td id='checkbox' contenteditable class='alignCenter drag'><i class='fas fa-arrows-alt'></i></td><td id='id' style='padding: 4px !important;'>" + (nvl + 1) + "</td><td id='tree'><b>" + nome.toUpperCase() + "</b><div style='align: center ;float: right; display:inline; width: 10%' class='child-tem  bordered btn btn-danger' id='child-tem'><i  class='icon ion-android-cancel text-white'></i></div></td><td class='alignCenter'><input name='total' style='width: 80%'' type='text' id='money'></td></tr>");
        $('#modal5').modal('hide');
        $('#etapa').val('');
        // $('#salva_tabel').click();

    });

    //exclui etapa
    $('.child-tem').on('click', function () {
        var token = $('[name= "_token"]').val();
        var etapa = $(this).closest('tr');

        var nome = etapa.children("td:eq(2)").text();
        var nv = etapa.children("td:eq(1)").text();
        var etapaid = etapa.children("td:eq(0)").find('#val_etapa').val();
        var orc = etapa.attr('name');
        nome = nome.replace(/\s/g, '');
        //   console.log(nome);
        nv = nv.replace(/\s/g, '');
        //   console.log(nv);
        //   console.log(etapaid);
        //   console.log(orc);
        $.ajax({
            type: "POST",
            url: '/etapa' + '?_token=' + token,
            data: {
                nome: nome,
                nv: nv,
                etapaid: etapaid,
                orc: orc
            },
            success: function success(data) {

                // alert(data);
                // $('#salva_tabel')[0].click();
                setTimeout(function () {
                    // $('.lin').click();
                    location.reload();
                }, 500);

            },
            error: function error(data) {
            alert('Erro ao excluir tabela -> ' + data);
            }
        });
    }); //       REFAZER O SALVA TABELA

    //salva tabela
    $('#salva_tabel').on('click', function () {
        // alert('aqui');
        $('#tree').find('tbody > tr').each(function () {
            // let dele = $(this).val();
            //recursividade dos elementos filhos que tem sub-itens
            // let tutano = $(this).find("td:eq(2)").children('#child-tem');
            // console.log(tutano.children().length);
            var token = $('[name= "_token"]').val();
            var orca = $('#orc').val();
            var usr = $('#ident').val();
            var etap = $(this).find("#val_etapa").val();
            var dala = $(this).find("td:eq(1)").text();
            dala = dala.replace(/\s/g, '');
            var dale = $(this).find("td:eq(2)").text();
            // dale = dale.replace('|', '');
            dale = dale.replace(/\s/g, '');
            var dali = $(this).find("td:eq(3)").find('input').val(); // console.log(token,' tkn');
            // console.log(orca,' usr');
            console.log(dala,' nvl');
            // console.log(dale,' titul');
            console.log(etap,'  eeetap');
            // console.log(dali,' val');

            $.ajax({
            type: "POST",
            url: '/etapa' + '?_token=' + token,
            data: {
                etapa:etap,
                nivel: dala,
                nome: dale,
                valor: dali,
                orca: orca,
                usr: usr
            },
            success: function success(data) {
                // $('#tree tbody').append("<tr style='color: #17202A' style='cursor:pointer;'><td id='checkbox' class='alignCenter'></td><td id='id' style='padding: 4px !important;'>"+(data.nivel)+"</td><td id='tree'><b>"+data.titulo+"</b></td><td class='alignCenter'><input name='total' style='width: 80%'' type='text' id='money'>"+data.valor+"</td></tr>");
                // message(' SALVO COM SUCESSO ');
                setTimeout(function () {
                // $('.lin').click();
                location.reload();
                }, 500);
            },
            error: function error(data) {
                alert('Erro ao salvar tabela -> ' + data);
            }
            });
        });
    });





/***/ }),

/***/ 1:
/*!*************************************!*\
  !*** multi ./resources/js/etapa.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\construmobile\resources\js\etapa.js */"./resources/js/etapa.js");


/***/ })

/******/ });
