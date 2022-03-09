function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
      if ((new Date().getTime() - start) > milliseconds){
        break;
      }
    }
  }
  
  function table(source, tabela) {
      var glyph_opts = {
           preset: "bootstrap3",
           map: {
           }
         };
      
  
      $(tabela).fancytree({
  
          types: {
              "file": {
                  "icon": "glyphicon"
              },
              "folder": {
                  "icon": "glyphicon"
              }
          },
  
          icon: function(event, data) {
              // data.typeInfo contains tree.types[node.type] (or {} if not found)
              // Here we will return the specific icon for that type, or `undefined` if
              // not type info is defined (in this case a default icon is displayed).
              return data.typeInfo.icon;
          },
  
          glyph: glyph_opts,
          checkbox: true,
          titlesTabbable: true, // Add all node titles to TAB chain
  
          extensions: ["edit", "table", "gridnav", "filter"],
          quicksearch: true,
  
          filter: {
              counter: false, // No counter badges
              mode: "hide",  // "dimm": Grayout unmatched nodes, "hide": remove unmatched nodes
              autoExpand: true,
              nodata: true, 
          },
  
          source: {url : source},
  
          table: {
              checkboxColumnIdx: 0, // render the checkboxes into the this column index (default: nodeColumnIdx)
              indentation: 16, // indent every node level by 16px
              nodeColumnIdx: 2 // render node expander, icon, and title to this column (default: #0)
          },
          gridnav: {
              autofocusInput: false, // Focus first embedded input if node gets activated
              handleCursorKeys: true // Allow UP/DOWN in inputs to move to prev/next node
          },
          edit: {
              triggerStart: [''],
  
              close: function(event, data) {
                  if (data.save && data.isNew) {
                      /* Quick-enter: add new nodes until we hit [enter] on an empty title
                      $("#tree").trigger("nodeCommand", {
                          cmd: "addSibling"
                      });
                      */
                  }
  
                  let tree = $(tabela).fancytree("getTree");
                  let fn = tree.getActiveNode();
  
                  fn.render(true);
              },
          },
  
          createNode: function(event, data) {
              var node = data.node,
                  $tdList = $(node.tr).find(">td");
  
              // Span the remaining columns if it's a folder.
              // We can do this in createNode instead of renderColumns, because
              // the `isFolder` status is unlikely to change later
              if (node.hasChildren()) {
                  $tdList.eq(2)
                      .prop("colspan", 4)
                      .nextAll("#no_input").remove();
  
                  //Altero o icone do no se o elemento nao estiver cadastrado na tabela insumo/Plano de contas
                  //console.log(node.data);
  
                  if(node.data.tabela == 3 || node.data.tabela == null){
                      $tdList.eq(2).find("> span.fancytree-node > span.fancytree-custom-icon").addClass("erro").addClass("glyphicon-folder-open");
                  }else{
                      $tdList.eq(2).find("> span.fancytree-node > span.fancytree-custom-icon").addClass("glyphicon-folder-open");
                  }
              }else{
                  //Altero o icone do no se o elemento nao estiver cadastrado na tabela insumo/Plano de contas
                  if(node.data.tabela == 3 || node.data.tabela == null){
                      $tdList.eq(2).find("> span.fancytree-node > span.fancytree-custom-icon").addClass("glyphicon-exclamation-sign erro");
                  }else{
                      $tdList.eq(2).find("> span.fancytree-node > span.fancytree-custom-icon").addClass("glyphicon-ok");
                  }
              }
          },
  
          renderColumns: function(event, data) {
              var node = data.node, $tdList = $(node.tr).find(">td");
              
              
              if(!node.hasChildren()){
  
                  var aux = parseFloat(node.data.valor_unitario);
  
                  isNaN(aux) ? aux = 0 : '';
  
                  $tdList.eq(1).text(node.getIndexHier());
                  if(node.data.quantidade > 0){
                    $tdList.eq(3).find("input").val(parseFloat(node.data.quantidade));
                  }else{
                    $tdList.eq(3).find("input").val(0);
                  }
                  
                  $tdList.eq(4).find("input").val(node.data.unidade);
                  $tdList.eq(5).find("input").val(aux.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
                  $tdList.eq(6).find("input").val(calc_total(node).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
  
              }else{
  
                  node.toggleClass("pai" ,true);
                  $tdList.eq(1).text(node.getIndexHier());
                  $tdList.eq(6).find("input").val(calc_total(node).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
              }
          }
      }).on("nodeCommand", function(event, data) {
  
          if($('select#orcamento option:selected').attr('editable') == '0'){
              // Custom event handler that is triggered by keydown-handler and
              // context menu:
              var data_finalizado = $('select#orcamento > option:selected').attr('data-finalizado'); 
              var refNode, moveMode,
                  tree = $(tabela).fancytree("getTree"),
                  node = tree.getActiveNode();
  
              switch (data.cmd) {
  
                  case "data_orc":
                      $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Data de Fechamento da Tabela: "+data_finalizado+"</h4>");
                      $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
                      $('button#dialog').click();
                      break;
                  default:
                      alert("aLONSO command: " + data.cmd);
                      return;
              }
          }else{
              var refNode, moveMode,
                  tree = $(tabela).fancytree("getTree"),
                  node = tree.getActiveNode();
  
  
              if(tabela != "table#tree"){
                  switch (data.cmd) {
                      case "rename":
                          //refNode = node.getParent();
                          //refNode.render(true);
                          node.editStart();
                          node.render();
  
                          break;
                      case "remove":
                          refNode = node.getParent();
                          node.remove();
                          //renderizando a arvore depois da exclusão, para solucionar os id dos nós
                          refNode.render(true);
                          if (refNode) {
                              refNode.setActive();
                          }
                          break;
                      case "addChild":
                          let pai = node.getParent();
  
                          node.editCreateNode("child", "");
  
                          let filho = node.getLastChild();
                          $tdList = $(filho.tr).find(">td");
  
                          filho.type = "file";
                          filho.data.id_insumo_plano = null;
                          filho.data.id_orcamento = $("select#orcamento").find('option:selected').val();
                          filho.data.tabela = null;
  
                          filho.render();
                          break;
                      case "addSibling":
                          //atualizando a criação de filhos subsequentes
                          let aux = node.getParent();
                          if (aux != null) {
                              aux.getLastChild().editCreateNode("after", "");
  
                              let filho = aux.getLastChild();
                              $tdList = $(filho.tr).find(">td");
  
                              filho.type = "folder";
                              filho.data.id_insumo_plano = null;
                              filho.data.id_orcamento = $("select#orcamento").find('option:selected').val();
                              filho.data.tabela = null;
  
                              filho.render();
                          }
                          else {
                              node.editCreateNode("after", "");
  
                              let filho = node.getNextSibling();
                              $tdList = $(filho.tr).find(">td");
  
                              filho.type = "folder";
                              filho.data.id_insumo_plano= null;
                              filho.data.tabela = null;
                              filho.data.id_orcamento = $("select#orcamento").find('option:selected').val();
  
                              filho.render();
                          }
                          break;
                      case "cut":
                          CLIPBOARD = {
                              mode: data.cmd,
                              data: node
                          };
                          break;
                      case "copy":
                          CLIPBOARD = {
                              mode: data.cmd,
                              data: node.toDict(function(n) {
                                  delete n.key;
                              })
                          };
                          break;
                      case "clear":
                          CLIPBOARD = null;
                          break;
                      case "paste":
                          if (CLIPBOARD.mode === "cut") {
                              // refNode = node.getPrevSibling();
                              CLIPBOARD.data.moveTo(node, "child");
                              CLIPBOARD.data.setActive();
                          }
                          else if (CLIPBOARD.mode === "copy") {
                              node.addChildren(CLIPBOARD.data).setActive();
                          }
                          break;
                      case "novo_insumo":
                            $("div#modal-insumo").modal('show');
                          $("input#cad_tarefa_input").val(node.title);
                          $("div#cad_tarefa").modal('show');
                          break;
  
                      case "novo_plano": 
  
                          // se no contexto clicar em novn plano
                          //ele faz a açao de clicar no botao de cad plano
                          $("input#cad_plano_desc").val(node.title);
                          $("button#cad_plano").click();
                          break;
  
                      default:
                          alert("Unhandled command: " + data.cmd);
                          return;
                  }
              }else{
                  switch (data.cmd) {
                      case "rename":
                          //refNode = node.getParent();
                          //refNode.render(true);
                          node.editStart();
                          node.render();
  
                          break;
                      case "remove":
                          refNode = node.getParent();
                          node.remove();
                          //renderizando a arvore depois da exclusão, para solucionar os id dos nós
                          refNode.render(true);
                          if (refNode) {
                              refNode.setActive();
                          }
                          break;
                      case "addChild":
                          let pai = node.getParent();
  
                          node.editCreateNode("child", "");
  
                          let filho = node.getLastChild();
                          $tdList = $(filho.tr).find(">td");
  
                          filho.type = "file";
                          filho.data.id_insumo_plano = null;
                          filho.data.id_orcamento = $("select#orcamento").find('option:selected').val();
                          filho.data.tabela = null;
  
                          filho.render();
                          break;
                      case "addSibling":
                          //atualizando a criação de filhos subsequentes
                          let aux = node.getParent();
                          if (aux != null) {
                              aux.getLastChild().editCreateNode("after", "");
  
                              let filho = aux.getLastChild();
                              $tdList = $(filho.tr).find(">td");
  
                              filho.type = "folder";
                              filho.data.id_insumo_plano = null;
                              filho.data.id_orcamento = $("select#orcamento").find('option:selected').val();
                              filho.data.tabela = null;
  
                              filho.render();
                          }
                          else {
                              node.editCreateNode("after", "");
  
                              let filho = node.getNextSibling();
                              $tdList = $(filho.tr).find(">td");
  
                              filho.type = "folder";
                              filho.data.id_insumo_plano= null;
                              filho.data.tabela = null;
                              filho.data.id_orcamento = $("select#orcamento").find('option:selected').val();
  
                              filho.render();
                          }
                          break;
                      case "cut":
                          CLIPBOARD = {
                              mode: data.cmd,
                              data: node
                          };
                          break;
                      case "copy":
                          CLIPBOARD = {
                              mode: data.cmd,
                              data: node.toDict(function(n) {
                                  delete n.key;
                              })
                          };
                          break;
                      case "clear":
                          CLIPBOARD = null;
                          break;
                      case "paste":
                          if (CLIPBOARD.mode === "cut") {
                              // refNode = node.getPrevSibling();
                              CLIPBOARD.data.moveTo(node, "child");
                              CLIPBOARD.data.setActive();
                          }
                          else if (CLIPBOARD.mode === "copy") {
                              node.addChildren(CLIPBOARD.data).setActive();
                          }
                          break;
                      case "novo_insumo":
                            $("div#modal-insumo").modal('show');
                          $("input#cad_insumo_desc").val(node.title);
                          $("button#cad_insumo").click();
                          break;
  
                      case "novo_plano": 
                          $("input#cad_plano_desc").val(node.title);
                          $("button#cad_plano").click();
                          break;
  
                      default:
                          alert("Unhandled command: " + data.cmd);
                          return;
                  }
              }
              
  
              // renderizo o pai novamento para tirar os campos de preenchimento
  
              // }).on("click dblclick", function(e){
              //   console.log( e, $.ui.fancytree.eventToString(e) );
          }
      }).on("keydown", function(e) {
  
          if($('select#orcamento option:selected').attr('editable') == '0'){
              var cmd = null;
  
              // console.log(e.type, $.ui.fancytree.eventToString(e));
              switch ($.ui.fancytree.eventToString(e)) {
                  /*
                  case "ctrl+up":
                      cmd = "moveUp";
                      break;
                  */
              }
              if (cmd) {
                  $(this).trigger("nodeCommand", {
                      cmd: cmd
                  });
              }
          }else{
              var cmd = null;
  
              // console.log(e.type, $.ui.fancytree.eventToString(e));
              switch ($.ui.fancytree.eventToString(e)) {
                  case "alt+shift+n":
                  case "meta+shift+n": // mac: cmd+shift+n
                      cmd = "addChild";
                      break;
                  case "ctrl+c":
                  case "meta+c": // mac
                      cmd = "copy";
                      break;
                  case "ctrl+v":
                  case "meta+v": // mac
                      cmd = "paste";
                      break;
                  case "shift+x":
                  case "meta+x": // mac
                      cmd = "cut";
                      break;
                  case "shift+n":
                  case "meta+n": // mac
                      cmd = "addSibling";
                      break;
                  case "del":
                  case "meta+backspace": // mac
                      cmd = "remove";
                      break;
              }
              if (cmd) {
                  $(this).trigger("nodeCommand", {
                      cmd: cmd
                  });
                  //e.preventDefault();
                  //e.stopPropagation();
                  //return false;
              }
          }
      }).on("click keydown", function(event){
  
          if($('select#orcamento option:selected').attr('editable') == '0'){
              //Linhas para debug, onde mostra toda a estruura de um nó da tabela
              let aux = event;
              let fn = $.ui.fancytree.getNode(event);  			
              //console.log(fn);    		
  
              setTimeout(function(aux){
  
                  if($.ui.fancytree.getEventTargetType(event) == "checkbox" || event.keyCode == 32){
                      if (fn.isSelected() && fn.hasChildren()) {
                          fn.visit(function(aux) {
                              aux.setSelected(true);
                          });
                      // caso todos os elementos filhos estiverem selecionados eu deseleciono todos
                      }else if (!fn.isSelected()  && fn.hasChildren()) {
                          fn.visit(function(aux) {
                              aux.setSelected(false);
                          });
                      }
                  }
              }, 20);
          }else{
              //Linhas para debug, onde mostra toda a estruura de um nó da tabela
              let aux = event;
              let fn = $.ui.fancytree.getNode(event);  			
              //console.log(fn);    		
  
              setTimeout(function(aux){
  
                  if($.ui.fancytree.getEventTargetType(event) == "checkbox" || event.keyCode == 32){
                      if (fn.isSelected() && fn.hasChildren()) {
                          fn.visit(function(aux) {
                              aux.setSelected(true);
                          });
                      // caso todos os elementos filhos estiverem selecionados eu deseleciono todos
                      }else if (!fn.isSelected()  && fn.hasChildren()) {
                          fn.visit(function(aux) {
                              aux.setSelected(false);
                          });
                      }
                  }else if($.ui.fancytree.getEventTargetType(event) == "icon" && fn.data.tabela == 3){
                      if(tabela == "table#orc_tarefa"){
  
                          if(!fn.hasChildren()){
                              let tree = $(tabela).fancytree("getTree");
                              let fn = tree.getActiveNode();
  
                              $("input#cad_tarefa_input").val(fn.title);
                              $("div#cad_tarefa").modal('show');
                          }else if(fn.hasChildren()){
                              let tree = $(tabela).fancytree("getTree");
                              let fn = tree.getActiveNode();
                              $("input#cad_plano_desc").val(fn.title);
  
                              $("button#cad_plano").click();
                          }
  
                      }else{
                          if(!fn.hasChildren()){
                              let tree = $(tabela).fancytree("getTree");
                              let fn = tree.getActiveNode();
                              $("input#cad_insumo_desc").val(fn.title);
  
                              $("button#cad_insumo").click();
                          }else if(fn.hasChildren()){
                              let tree = $(tabela).fancytree("getTree");
                              let fn = tree.getActiveNode();
                              $("input#cad_plano_desc").val(fn.title);
  
                              $("button#cad_plano").click();
                          }
                      }
                  }
              }, 20);
          }
      });
  }
  
  function define_contextMenu(option = 1, tabela){
      if(option == 1){
  
          var CLIPBOARD = null;
  
          //console.log(tabela);
  
          if(tabela != "table#tree"){
  
              $(tabela).contextmenu({
                  delegate: "td",
                  menu: [{
                          title: "Editar <kbd>[F2]</kbd>",
                          cmd: "rename",
                          uiIcon: "ui-icon-pencil"
                      },
                      {
                          title: "Deletar <kbd>[Del]</kbd>",
                          cmd: "remove",
                          uiIcon: "ui-icon-trash"
                      },
                      {
                          title: "Novo Plano de Conta <kbd>[Shift+N]</kbd>",
                          cmd: "addSibling",
                          uiIcon: "ui-icon-plus"
                      },
                      {
                          title: "Nova Tarefa <kbd>[Alt+Shift+N]</kbd>",
                          cmd: "addChild",
                          uiIcon: "ui-icon-arrowreturn-1-e"
                      },
                      {
                          title: "Copiar <kbd>Ctrl-C</kbd>",
                          cmd: "copy",
                          uiIcon: "ui-icon-copy"
                      },
                      {
                          title: "Colar Tarefa / Plano <kbd>Ctrl+V</kbd>",
                          cmd: "paste",
                          uiIcon: "ui-icon-clipboard",
                          disabled: true
                      },
                      {
                          title: "Cadastrar tarefa ",
                          cmd: "novo_insumo",
                          uiIcon: "ui-icon-insumo",
                      },
                      {
                          title: "Cadastrar Plano de Contas ",
                          cmd: "novo_plano",
                          uiIcon: "ui-icon-plano",
                      } 
                  ],
                  beforeOpen: function(event, ui) {
                      var node = $.ui.fancytree.getNode(ui.target);
                      $(tabela).contextmenu("enableEntry", "paste", !!CLIPBOARD);
  
                      $(tabela).contextmenu("showEntry", "novo_insumo", false);
                      $(tabela).contextmenu("showEntry", "novo_plano", false);
  
                      $(tabela).contextmenu("showEntry", "addSibling", true);
                      $(tabela).contextmenu("showEntry", "addChild", true);
                      $(tabela).contextmenu("showEntry", "copy", true);
                      $(tabela).contextmenu("showEntry", "paste", true);
  
                      if(!node.hasChildren() &&  node.data.tabela == 3){
                          $(tabela).contextmenu("showEntry", "novo_insumo", true);
  
                          $(tabela).contextmenu("showEntry", "addSibling", false);
                          $(tabela).contextmenu("showEntry", "addChild", false);
                          $(tabela).contextmenu("showEntry", "copy", false);
                          $(tabela).contextmenu("showEntry", "paste", false);
  
                      }else if(node.hasChildren() && node.data.tabela == 3){
                          $(tabela).contextmenu("showEntry", "novo_plano", true);
  
                          $(tabela).contextmenu("showEntry", "addSibling", false);
                          $(tabela).contextmenu("showEntry", "addChild", false);
                          $(tabela).contextmenu("showEntry", "copy", false);
                          $(tabela).contextmenu("showEntry", "paste", false);
  
                      }else if(!node.hasChildren()){
                          $(tabela).contextmenu("showEntry", "addSibling", false);
                      }
  
                      node.setActive();
                  },
                  select: function(event, ui) {
                      var that = this;
                      // delay the event, so the menu can close and the click event does
                      // not interfere with the edit control
                      setTimeout(function() {
                          $(that).trigger("nodeCommand", {
                              cmd: ui.cmd
                          });
                      }, 100);
                  }
              });
  
          }else{
              $(tabela).contextmenu({
                  delegate: "td",
                  menu: [{
                          title: "Editar <kbd>[F2]</kbd>",
                          cmd: "rename",
                          uiIcon: "ui-icon-pencil"
                      },
                      {
                          title: "Deletar <kbd>[Del]</kbd>",
                          cmd: "remove",
                          uiIcon: "ui-icon-trash"
                      },
                      {
                          title: "Novo Plano de Conta <kbd>[Shift+N]</kbd>",
                          cmd: "addSibling",
                          uiIcon: "ui-icon-plus"
                      },
                      {
                          title: "Novo Insumo <kbd>[Alt+Shift+N]</kbd>",
                          cmd: "addChild",
                          uiIcon: "ui-icon-arrowreturn-1-e"
                      },
                      {
                          title: "Copiar <kbd>Ctrl-C</kbd>",
                          cmd: "copy",
                          uiIcon: "ui-icon-copy"
                      },
                      {
                          title: "Colar Insumo / Plano <kbd>Ctrl+V</kbd>",
                          cmd: "paste",
                          uiIcon: "ui-icon-clipboard",
                          disabled: true
                      },
                      {
                          title: "Cadastrar Insumo ",
                          cmd: "novo_insumo",
                          uiIcon: "ui-icon-insumo",
                      },
                      {
                          title: "Cadastrar Plano de Contas ",
                          cmd: "novo_plano",
                          uiIcon: "ui-icon-plano",
                      } 
                  ],
                  beforeOpen: function(event, ui) {
                      var node = $.ui.fancytree.getNode(ui.target);
                      $(tabela).contextmenu("enableEntry", "paste", !!CLIPBOARD);
  
                      $(tabela).contextmenu("showEntry", "novo_insumo", false);
                      $(tabela).contextmenu("showEntry", "novo_plano", false);
  
                      $(tabela).contextmenu("showEntry", "addSibling", true);
                      $(tabela).contextmenu("showEntry", "addChild", true);
                      $(tabela).contextmenu("showEntry", "copy", true);
                      $(tabela).contextmenu("showEntry", "paste", true);
  
                      if(!node.hasChildren() &&  node.data.tabela == 3){
                          $(tabela).contextmenu("showEntry", "novo_insumo", true);
  
                          $(tabela).contextmenu("showEntry", "addSibling", false);
                          $(tabela).contextmenu("showEntry", "addChild", false);
                          $(tabela).contextmenu("showEntry", "copy", false);
                          $(tabela).contextmenu("showEntry", "paste", false);
  
                      }else if(node.hasChildren() && node.data.tabela == 3){
                          $(tabela).contextmenu("showEntry", "novo_plano", true);
  
                          $(tabela).contextmenu("showEntry", "addSibling", false);
                          $(tabela).contextmenu("showEntry", "addChild", false);
                          $(tabela).contextmenu("showEntry", "copy", false);
                          $(tabela).contextmenu("showEntry", "paste", false);
  
                      }else if(!node.hasChildren()){
                          $(tabela).contextmenu("showEntry", "addSibling", false);
                      }
  
                      node.setActive();
                  },
                  select: function(event, ui) {
                      var that = this;
                      // delay the event, so the menu can close and the click event does
                      // not interfere with the edit control
                      setTimeout(function() {
                          $(that).trigger("nodeCommand", {
                              cmd: ui.cmd
                          });
                      }, 100);
                  }
              });
          }
          
      }else{
          var CLIPBOARD = null;
  
          $(tabela).contextmenu({
              delegate: "td",
              menu: [{
                      title: "Ver Data Orçamento",
                      cmd: "data_orc",
                      uiIcon: "ui-icon-pencil",
                  }
              ],
              beforeOpen: function(event, ui) {
                  var node = $.ui.fancytree.getNode(ui.target);
                  node.setActive();
              },
              select: function(event, ui) {
                  var that = this;
  
                  setTimeout(function() {
                      $(that).trigger("nodeCommand", {
                          cmd: ui.cmd
                      });
                  }, 100);
              }
          });
      }
  }
  
  function mascara_money() {
      $("input[id='money']").each(function() {
          $(this).maskMoney({
              prefix: 'R$ ',
              thousands: '.',
              decimal: ',',
              affixesStay: true
          });
      });
  }
  
  function salva_tabela(){
  
      var tree = $("#tree").fancytree("getTree");
      var tree_tarefa = $("table#orc_tarefa").fancytree("getTree");
      var orcamento = $('select#orcamento option:selected').val();
  
      if(orcamento != -1){
          var nos_material = new Array();
  
          //Rotina para capturar os nós da tabela de material
          tree.expandAll();
  
          tree.visit(function(fn){
              var no =  new Array();
              if(fn.hasChildren()){
                  let $tdList = $(fn.tr).find(">td");
  
                  no.push($tdList.eq(1).text());
                  no.push($tdList.eq(2).text());
  
                  no.push(orcamento);
                  no.push(fn.data.id_insumo_plano);
                  no.push(fn.data.tabela);
              }else{
                  let $tdList = $(fn.tr).find(">td");
  
                  no.push($tdList.eq(1).text());
                  no.push($tdList.eq(2).text());
                  no.push($tdList.eq(3).find("input").val());
                  no.push($tdList.eq(4).find("input").val());
  
                  isNaN(parseFloat($tdList.eq(5).find("input").val().replace(/[R$,.]/g, ''))) ? no.push('') : no.push($tdList.eq(5).find("input").val().replace(/[R$. ]/g, '').replace(/,/g, '.'));
  
                  no.push(orcamento);
                  no.push(fn.data.id_insumo_plano);
                  no.push(fn.data.tabela);
              }
              console.log('ele >>>', no);
              // console.log('orcam >> ', orcamento);
              nos_material.push(no);
          });
  
          no = null;
          tree.expandAll(false);
  
  
          //Rotina para capturar os nós da tabela de tarefa
          tree_tarefa.expandAll();
          var nos_tarefa = new Array();
  
          tree_tarefa.visit(function(fn){
  
              //console.log(fn.data);
              no =  new Array();
              if(fn.hasChildren()){
  
                // pega valores de pai
                  let $tdList = $(fn.tr).find(">td");

                  no.push($tdList.eq(1).text());
                  no.push($tdList.eq(2).text());
  
                  no.push(orcamento);
                  no.push(fn.data.id_tarefa_plano);
                  no.push(fn.data.tabela);
              }else{

                  let $tdList = $(fn.tr).find(">td");
                  no.push($tdList.eq(1).text());
                  no.push($tdList.eq(2).text());
                  no.push($tdList.eq(3).find("input").val());
                  no.push($tdList.eq(4).find("input").val());
  
                  isNaN(parseFloat($tdList.eq(5).find("input").val().replace(/[R$,.]/g, ''))) ? no.push('') : no.push($tdList.eq(5).find("input").val().replace(/[R$. ]/g, '').replace(/,/g, '.'));
  
                  no.push(orcamento);
                  no.push(fn.data.id_tarefa_plano);
                  no.push(fn.data.tabela);
              }
  
              nos_tarefa.push(no);
          });
  
          tree_tarefa.expandAll(false);
  
          console.log(no);
        //   console.log(nos_tarefa);
        //   console.log(orcamento);
  
          $.ajax({
             url:   'const_grava_tabela.php',
             type:  'POST',
             //cache: false,
             //data:  { ok : 'deu certo!'},
                 data: {orcamento:orcamento, nos_material:nos_material, nos_tarefa:nos_tarefa}, //essa e o padrao x-www-form-urlencode
  
             error: function() {
                  $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Erro ao Salvar a Tabela!!</h4>");
                  $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
             },
             success: function(data) { 
                     //tree.reload();
  
                     $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Salvo com Sucesso!</h4>");
                  $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
             },
             beforeSend: function() {
                     $("div#dialog-body").html("<img src='img/loading.gif' width='45' height='45' style='text-align: right;'>");
                  $("div#dialog-footer").html("<h4 class='modal-title' align='center' id='salvar'>Carregando, aguarde!</h4>");
                  $("button#dialog").click();
             }
          });
      }else{
          alert('Selecione um Orçamento! ');
      }
  }
  
  function atualiza_no(){
      let tree = $("table#tree").fancytree("getTree");
      let tree_tarefa = $("table#orc_tarefa").fancytree("getTree");
  
      let fn = tree.getActiveNode();
      let fn_tarefa = tree_tarefa.getActiveNode();
  
      if(fn != null){
          // renderizo o pais
          // renderizo o style do pai
          if(!fn.isEditing() && fn.getParent().getLastChild() == fn && fn.getLevel() > 1){
              if(fn.getParent().extraClasses.indexOf("pai") == -1){
                  fn.getParent().render(true, false);
              }
          }
  
          var $tdList = $(fn.tr).find(">td");
              
          if(!(fn.hasChildren())){
  
              fn.toggleClass("pai", false);
              let total_f = 0;
  
              // Validacao e armazenamento dos campos quantidade e valor Unitario
              if($tdList.eq(3).find("input").val() != null && $tdList.eq(5).val() != null ){
                    isNaN(parseFloat($tdList.eq(3).find("input").val().replace(',', '.'))) ? fn.data.quantidade = 0 : fn.data.quantidade = parseFloat($tdList.eq(3).find("input").val().replace(',', '.'));

                  isNaN(parseFloat($tdList.eq(5).find("input").val().replace(/[R$. ]/g, '').replace(/,/g, '.'))) ? fn.data.valor_unitario = 0 : fn.data.valor_unitario = parseFloat($tdList.eq(5).find("input").val().replace(/[R$. ]/g, '').replace(/,/g, '.'));
  
                  total_f = parseFloat(fn.data.quantidade)  * parseFloat(fn.data.valor_unitario);
              }
  
              if(total_f > 0){
                  $tdList.eq(6).find("input").val(total_f.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
              }else{
                  $tdList.eq(6).find("input").val(0.00.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
              }
  
              // Atualizando o total dos pais do nó
              let pais = fn.getParentList();
              for(let i = 0; i < pais.length; i++){
                  let $tdpai = $(pais[i].tr).find(">td");
  
                  $tdpai.eq(3).find("input").val(calc_total(pais[i]).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
              }
          }else{
              fn.toggleClass("pai", true);
              $tdList.eq(3).find("input").val(calc_total(fn).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
          }
  
          // fazendo o calculo do total selecionado
          let selecionados = tree.getSelectedNodes(), total_final = 0;
  
          for (let i = 0; i < selecionados.length; i++) {
              if(!selecionados[i].hasChildren()){
  
                  total_final += parseFloat(selecionados[i].data.quantidade) * parseFloat(selecionados[i].data.valor_unitario);
              }
          }
  
          $("#total").val(total_final.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
      }
  
      if(fn_tarefa != null){
          // renderizo o pais
          // renderizo o style do pai
          if(!fn_tarefa.isEditing() && fn_tarefa.getParent().getLastChild() == fn_tarefa && fn_tarefa.getLevel() > 1){
              if(fn_tarefa.getParent().extraClasses.indexOf("pai") == -1){
                  fn_tarefa.getParent().render(true, false);
              }
          }
  
          var $tdList = $(fn_tarefa.tr).find(">td");
              
          if(!(fn_tarefa.hasChildren())){
  
              fn_tarefa.toggleClass("pai", false);
              let total_f = 0;
  
              // Validacao e armazenamento dos campos quantidade e valor Unitario
              if($tdList.eq(3).find("input").val() != null && $tdList.eq(5).val() != null ){
  
                  isNaN(parseFloat($tdList.eq(3).find("input").val().replace(',', '.'))) ? fn_tarefa.data.quantidade = 0 : fn_tarefa.data.quantidade = parseFloat($tdList.eq(3).find("input").val().replace(',', '.'));
                  isNaN(parseFloat($tdList.eq(5).find("input").val().replace(/[R$. ]/g, '').replace(/,/g, '.'))) ? fn_tarefa.data.valor_unitario = 0 : fn_tarefa.data.valor_unitario = parseFloat($tdList.eq(5).find("input").val().replace(/[R$. ]/g, '').replace(/,/g, '.'));
                    total_f = parseFloat(fn_tarefa.data.quantidade)  * parseFloat(fn_tarefa.data.valor_unitario);

            }
  
              if(total_f > 0){
                  $tdList.eq(6).find("input").val(total_f.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
              }else{
                  $tdList.eq(6).find("input").val(total_f.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
              }
  
              // Atualizando o total dos pais do nó
              let pais = fn_tarefa.getParentList();
              for(let i = 0; i < pais.length; i++){
                  let $tdpai = $(pais[i].tr).find(">td");
  
                  $tdpai.eq(3).find("input").val(calc_total(pais[i]).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
              }
          }else{
              fn_tarefa.toggleClass("pai", true);
              $tdList.eq(3).find("input").val(calc_total(fn_tarefa).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
          }
  
          // fazendo o calculo do total selecionado
          let selecionados = tree_tarefa.getSelectedNodes(), total_final = 0;
  
          for (let i = 0; i < selecionados.length; i++) {
              if(!selecionados[i].hasChildren()){
                  total_final += parseFloat(selecionados[i].data.quantidade) * parseFloat(selecionados[i].data.valor_unitario);
              }
          }
  
          $("#total").val(total_final.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
      }
  }
  
  function calc_total(no){
  
      let total = 0;
  
      if(!no.hasChildren()){
          total += parseFloat(no.data.quantidade) * parseFloat(no.data.valor_unitario);
      }else{
          no.visit(function(fn){
              if(!fn.hasChildren()){
                  if(fn.data.quantidade > 0 && fn.data.valor_unitario > 0){
                    total += parseFloat(fn.data.quantidade) * parseFloat(fn.data.valor_unitario);
                  }
              }
          });
      }
  
      if(isNaN(total) ){
          return 0.00;
      }else{
          return total;
      }
  }
  
  
  //pegando o id do orçamento quando vai subir a planilha de orcamento
  $('a#upload_planilha').click(function(event){
      //event.preventDefault();  
      var op = $('select#orcamento > option:selected').val();
      var tipo_up = $('select#select_up > option:selected').val();
  
      if(op == -1){
          alert("Selecione um Orçamento!");
          //$('div#modal-message').modal('hide');
          setTimeout(function(){
              $('div#modal-message').modal('hide');
          }, 25);
      }else{
          $('input#id_orcamento').val(op);
      }
  });
  



  //Atualiza os campos do select de acordo com a categoria selecionada
  $("select#choice_categoria").change(function(data){
  
      //Pego o elemento selecionado
      var opcao_select = $(this).find('option:selected').val();
      let selecione = $('select#choice_especie').find('> option[id="selecione"]').clone(true);
      
  
  
     // errro aqui estudar o que se passa pae
  
  
      $.ajax({  
          url:'const_grava_insumo.php',  
          method:'POST', 
          data: {opcao_select:opcao_select},
          dataType:'json',
          error: erro => {console.log(0)},
          success: dados =>
          { 
  
              $('select#choice_especie').empty();
              $('select#choice_especie').append(selecione);
  
              for(var i = 0; i < dados.length; i++){
                  $('select#choice_especie').append("<option value='"+dados[i]+"'>"+dados[i]+"</option>");
              }	
              // console.log(dados);
              
          }
            
      });  
  });
  
  
  
  
  
  
  // Lista os itens da categoria e especie escolhidos
  $("a#atualizar").click(function(){
  
      var $TABLE = $('#table_ins > table');
      var $FORM_PRINCI = $('#form_principal');
  
      var $clone = $TABLE.find('> tbody > tr.hide').clone(true);
      $TABLE.find('> tbody').empty();
      $TABLE.find('> tbody').append($clone);
      
      console.log($clone);
      var aux = {};
  
      // pega a categoria e especie selecionada
      aux['categoria'] = $FORM_PRINCI.find('select#choice_categoria > option:selected').val();
      aux['especie'] = $FORM_PRINCI.find('select#choice_especie > option:selected').val();
  
      console.log(aux);
  
      $.ajax({  
          url:'const_grava_insumo.php',  
          method:'POST', 
          data: aux,
          dataType:'json', 
          beforeSend: function(){
              $("div#salvar").html("<img src='img/loading.gif' width='45' height='45' style='text-align: right;'>");
              $("div#footer_salvar").html("<h4 class='modal-title' align='center' id='salvar'>Carregando, aguarde!</h4>");
              $('div#modal7').modal('show');
          },
          success: dados => 
          {   
              //console.log(dados);
              $('div#modal7').modal('hide');
  
              if(!isEmpty(dados)){
  
                  for(var data in dados ){
  
                      console.log(data);
                      var $clone = $TABLE.find('> tbody > tr.hide').clone(true).removeClass('hide table-line').attr('id-insumo-solo', dados[data].id);
                      $TABLE.find('> tbody').append($clone);
  
                      $TABLE.find('> tbody > tr:last-child > td').each(function(i){
                          if(i == 0){
                              $(this).text(dados[data].codigo);
  
                          }else if(i == 1){
                              $(this).text(dados[data].desc);
                          }
                      });
                  }
              }else{
                  $TABLE.find('> tbody').empty();
              }
          },
          error: erro => {
              $('div#modal7').modal('hide');
              console.log("Erro")
          },  
      });
  });
  
  
  
  
  
  $('#envia_xlsx').on("submit", function(){
    $("div#dialog-body").html("<img src='img/loading.gif' width='45' height='45' style='text-align: right;'>");
    $("div#dialog-footer").html("<h4 class='modal-title' align='center' id='salvar'>Carregando, aguarde!</h4>");
    $("button#dialog").click();
    setTimeout(function(){
        $("div#dialog-body").hide();
        $("div#dialog-footer").hide();
        window.location.reload(true);
    },21000);
});  
  
  
  
  
  //Salva o insumo cadastrado
  $('#cad_insumo_form').on("submit", function(event){  
          event.preventDefault();  
  
          var adiciona = [];
          var tree = $("#tree").fancytree("getTree");
          var fn = tree.getActiveNode(), $tdList = $(fn.tr).find("> td");
  
          adiciona.push($("input#cad_insumo_cod").val().replace(',' , '.'));
          adiciona.push($("input#cad_insumo_desc").val().toUpperCase());
          adiciona.push($("select#select_categoria").find('option:selected').val());
          adiciona.push($("select#select_especie").find('option:selected').val());
  
          //variaveis para alteração do id do insumo na tabela orçamento
          adiciona.push(fn.data.id);
          fn.hasChildren() ? adiciona.push(1) : adiciona.push(2);
          adiciona.push(fn.data.id_orcamento);
          
          console.log(adiciona, ' << adiciona ');
  
          $.ajax({  
          url:'const_grava_insumo.php',
          method:'POST', 
          data: {adiciona:adiciona},
          dataType:'json',  
          success: dados => 
          {   
              //Atualizo o id e a tabela do insumo 	                	
              fn.data.id_insumo_plano = dados.id;
              fn.data.tabela = dados.tabela;
  
                $("button.close").click();
  
                //alterando os icones da linha acrecentada
                $tdList.eq(2).find("> span.fancytree-node > span.fancytree-custom-icon").removeClass("glyphicon-exclamation-sign erro");
                $tdList.eq(2).find("> span.fancytree-node > span.fancytree-custom-icon").addClass("glyphicon-ok");
  
                fn.title = $("input#cad_insumo_desc").val().toUpperCase();
  
                $tdList.eq(2).find("> span.fancytree-node > span.fancytree-title").text(fn.title);
                //fn.renderTitle();
                $("button#reset").click();
  
                $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Salvo com Sucesso!</h4>");
                $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
                $('button#dialog').click();
  
          },
          error: erro => {
              $("button.close").click();
              $("button#reset").click();
  
              $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Erro ao salvar alonsooo!</h4>");
              $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
              $('button#dialog').click();
          }  
          });  
  });
  
  //Salva a Tarefa cadastrado
  $('#cad_tarefa_form').on("submit", function(event){  
      event.preventDefault();  
  
      var adiciona = [];
      var tree = $("table#orc_tarefa").fancytree("getTree");
      var fn = tree.getActiveNode(), $tdList = $(fn.tr).find("> td");
  
      adiciona.push($("input#cad_tarefa_cod").val().replace(',' , '.'));
      adiciona.push($("input#cad_tarefa_input").val().toUpperCase());
  
      //variaveis para alteração do id do insumo na tabela orçamento
      adiciona.push(fn.data.id);
      fn.hasChildren() ? adiciona.push(1) : adiciona.push(0);
      adiciona.push(fn.data.id_orcamento);
  
      $.ajax({  
      url:'const_grava_tabela.php',  
      method:'POST', 
      data: {adiciona:adiciona},
      dataType:'json',  
      success: dados => 
      {   
          //Atualizo o id e a tabela do insumo                        
          fn.data.id_insumo_plano = dados;
          fn.data.tabela = 4;
  
          $("button.close").click();
  
          //alterando os icones da linha acrecentada
          $tdList.eq(2).find("> span.fancytree-node > span.fancytree-custom-icon").removeClass("glyphicon-exclamation-sign erro");
          $tdList.eq(2).find("> span.fancytree-node > span.fancytree-custom-icon").addClass("glyphicon-ok");
  
          fn.title = $("input#cad_insumo_desc").val().toUpperCase();
  
          //$tdList.eq(2).find("> span.fancytree-node > span.fancytree-title").text(fn.title);
          //fn.renderTitle();
          $("button#reset").click();
  
          $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Salvo com Sucesso!</h4>");
          $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
          $('button#dialog').click();
  
      },
      error: erro => {
          $("button.close").click();
          $("button#reset").click();
  
          $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Erro ao salvar alonso!</h4>");
          $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
          $('button#dialog').click();
      }  
      });  
  });
  
  //Salva o plano cadastrado
  $('#cad_plano_form').on("submit", function(event){  
          event.preventDefault();  
  
          var adiciona = [];
          var tree = $("#tree").fancytree("getTree");

          
          console.log(tree.getActiveNode());
          var fn = tree.getActiveNode();
          var $tdList = $(fn.tr).find("> td");
          
          
  
        //   console.log(fn);

          adiciona.push($("input#cad_plano_cod").val().replace(/,/g , '.'));
          adiciona.push($("input#cad_plano_desc").val().toUpperCase());
  
          //variaveis para alteração do id do insumo na tabela orçamento
          adiciona.push(fn.data.id);
          fn.hasChildren() ? adiciona.push(1) : adiciona.push(2);
          
  
          adiciona.push(fn.data.id_orcamento);
          
          console.log('adiciona >>>', adiciona);
  
          $.ajax({  
          url:'const_grava_planoContas.php',  
          method:'POST', 
          data: {adiciona:adiciona},
          dataType:'json',  
          success: dados => 
          {   
            //   console.log('deu baaaaao');
  
              //Atualizo o id e a tabela do insumo 	                	
              fn.data.id_insumo_plano = dados.id;
              fn.data.tabela = dados.tabela;
  
                $("button.close").click();
  
                //alterando os icones da linha acrecentada
                $tdList.eq(2).find("> span.fancytree-node > span.fancytree-custom-icon").removeClass("glyphicon-exclamation-sign erro").addClass("glyphicon-file");
                fn.title = $("input#cad_plano_desc").val().toUpperCase();
  
                $tdList.eq(2).find("> span.fancytree-node > span.fancytree-title").text(fn.title);
                //fn.renderTitle();
                $("button#reset").click();
  
                $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Salvo com Sucesso!</h4>");
                $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
                $('button#dialog').click();
  
          },
          error: erro => {
              $("button.close").click();
              $("button#reset").click();
  
              $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Erro ao salvar alonso!</h4>");
              $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
              $('button#dialog').click();
          }  
          });  
  });
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  //Atualiza os campos do select de acordo com a categoria selecionada
$("select#select_categoria").change(function(data){

	//Pego o elemento selecionado
	var opcao_select = $(this).find('option:selected').val();
    let selecione = $('select#select_especie').find('> option[id="selecione"]').clone(true);
    


   // errro aqui estudar o que se passa pae


	$.ajax({  
		url:'const_grava_insumo.php',  
		method:'POST', 
		data: {opcao_select:opcao_select},
        dataType:'json',
        error: erro => {console.log(0)},
        success: dados =>
        { 

            $('select#select_especie').empty();
            $('select#select_especie').append(selecione);

            for(var i = 0; i < dados.length; i++){
                $('select#select_especie').append("<option value='"+dados[i]+"'>"+dados[i]+"</option>");
            }	
            // console.log(dados);
			
		}
		  
	});  
});
  
  
  
  //Cadastra um novo orçamento
  $('#form_cad_orcamento').on("submit", function(event){
      // event.preventDefault(); 
  
      if($('select#select_empreendimento > option:selected').val() != -1 &&  $('select#select_sub_empreendimento > option:selected').val() != -1 && $('input#cad_orcamento').val() != ''){
          
          var plano_desc = [];
  
          plano_desc.push($('input#cad_orcamento').val().toUpperCase());
          plano_desc.push($("select#select_empreendimento > option:selected").val());
          plano_desc.push($("select#select_sub_empreendimento > option:selected").val());
  

        //   console.log(plano_desc);
        //   debugger;
          $.ajax({  
              url:'const_grava_tabela.php',  
              method:'POST', 
              data: {plano_desc:plano_desc},
              dataType:'json',  
              success: dados => 
              {   
                  //$('select#orcamento').append("<option value='"+dados+"' >"+ $('input#cad_orcamento').val() +"</option> ");
  
                    $("button.close").click();
                    $("button#reset").click();
  
                    $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Salvo com Sucesso!</h4>");
                    $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
                    $('button#dialog').click();
  
              },
              error: erro => {
                  $("button.close").click();
                  $("button#reset").click();
  
                  $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Erro ao salvar alonso!</h4>");
                  $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
                  $('button#dialog').click();
              }  
          });
      }else{
          alert('Preencha corretamente todos os campos!');
      }
  });
  
  //Realiza uma ação de acordo com o orçamento selecionado
  $("select#orcamento").change(function() {
  
      let orcamento = $('select#orcamento > option:selected').text();
      let editable = $('select#orcamento > option:selected').attr('editable'); // Status de edição da tabela 0 = fachado, 1 = aberto
      let tree = $("#tree").fancytree("getTree");
      let tree_tarefa = $("table#orc_tarefa").fancytree("getTree");
      let id_orcamento = $('select#orcamento > option:selected').val();
  
      //console.log(id_orcamento);
  
      // Caso o orçamento seja valido
      if($('select#orcamento >  option:selected').val() != -1){
  
          // let orcamento = $('select#orcamento option:selected').text();
          // let editable = $('select#orcamento option:selected').attr('editable'); // Status de edição da tabela 0 = fachado, 1 = aberto
          // let tree = $("#tree").fancytree("getTree");
          // let tree_tarefa = $("table#orc_tarefa").fancytree("getTree");
          // let id_orcamento = $('select#orcamento option:selected').val();
  
          if(editable == '0'){
              //Desmonto a tabela atual
  
              /*
              $("#tree").fancytree("destroy");
              //Quando eu desmonto a tabela a 'tr' modelo dentro da 'td'
              $("table#tree > tbody").append("<tr><td id='checkbox' class='alignCenter'></td><td id='id' style='padding: 4px !important; ' ></td><td id='tree'></td><td class='alignCenter' id='no_input'><input name='unidade' id='unidade' type='text' disabled></td><td class='alignCenter' id='no_input'><input name='qnt' id='qnt' type='text' disabled></td><td class='alignCenter' id='no_input'><input name='valor_qnt' type='text' id='money' disabled></td><td class='alignCenter'><input name='total' type='text' id='money' disabled></td></tr>");
              
              table_not_editing("orcamentos/"+orcamento+".json");
              */
  
            //   console.log(id_orcamento, 'orcaenviado');
              $.ajax({
                 url:   'const_grava_tabela.php',
                 type:  'POST',
                 //cache: false,
                 //data:  { ok : 'deu certo!'},
                     data: {id_orcamento:id_orcamento}, //essa e o padrao x-www-form-urlencode
  
                 error: function() {
                      $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Erro ao Carregar a Tabela!!</h4>");
                      $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
                 },
                 success: function(data) { 
                         //tree.reload();
                         //$('button.close').click();
                         
                 },
                 beforeSend: function() {
                         $("div#dialog-body").html("<img src='img/loading.gif' width='45' height='45' style='text-align: right;'>");
                      $("div#dialog-footer").html("<h4 class='modal-title' align='center' id='salvar'>Carregando, aguarde!</h4>");
                      $("button#dialog").click();
                 }
              });
  
  
              setTimeout(function(){
                  tree.reload({
                      url: "orcamentos/"+orcamento+".json"
  
                  }).done(function() {
                      define_contextMenu(editable, "table#tree");
  
                      tree.expandAll();
  
                      //Caso o status do orçamento seja 0, Visito todos os inputs da tabela e acrescento o atributo disabled
                      $('table#tree > tbody').find('> tr').each(function(i){
                          $(this).find('td#no_input').each(function(j){
                              $(this).find('input').attr('disabled', '');
                          });
                      });
  
                      tree.expandAll(false);
                  });
  
                  tree_tarefa.reload({
                      url: "orcamentos/"+orcamento+"_tarefa.json"
  
                  }).done(function() {
                      define_contextMenu(editable, "table#orc_tarefa");
  
                      tree_tarefa.expandAll();
  
                      //Caso o status do orçamento seja 0, Visito todos os inputs da tabela e acrescento o atributo disabled
                      $('table#orc_tarefa > tbody').find('> tr').each(function(i){
                          $(this).find('td#no_input').each(function(j){
                              $(this).find('input').attr('disabled', '');
                          });
                      });
  
                      tree_tarefa.expandAll(false);
                  });
  
                  $('button.close').click();
              }, 1500);
  
              $('button#salva_tabela').hide();
              $('button#chama_finaliza_orcamento').hide();
              $('button#planilhas').hide();
              $('span#orcamento_fechado').removeClass('hidden');
  
          }else{
              /*
              $("#tree").fancytree("destroy");
              $("table#tree > tbody").append("<tr><td id='checkbox' class='alignCenter'></td><td id='id' style='padding: 4px !important; ' ></td><td id='tree'></td><td class='alignCenter' id='no_input'><input name='unidade' id='unidade' type='text'></td><td class='alignCenter' id='no_input'><input name='qnt' id='qnt' type='text'></td><td class='alignCenter' id='no_input'><input name='valor_qnt' type='text' id='money'></td><td class='alignCenter'><input name='total' type='text' id='money' disabled></td></tr>");
              table("orcamentos/"+orcamento+".json");
              */
  
              $.ajax({
                 url:   'const_grava_tabela.php',
                 type:  'POST',
                 //cache: false,
                 //data:  { ok : 'deu certo!'},
                     data: {id_orcamento:id_orcamento}, //essa e o padrao x-www-form-urlencode
  
                 error: function() {
                      $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Erro ao Carregar a Tabela!!</h4>");
                      $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
                 },
                 success: function(data) { 
                         //tree.reload();
                         //$('button.close').click();
                         
                 },
                 beforeSend: function() {
                         $("div#dialog-body").html("<img src='img/loading.gif' width='45' height='45' style='text-align: right;'>");
                      $("div#dialog-footer").html("<h4 class='modal-title' align='center' id='salvar'>Carregando, aguarde!</h4>");
                      $("button#dialog").click();
                 }
              });
  
              setTimeout(function(){
                  tree.reload({
                      url: "orcamentos/"+orcamento+".json"
                  }).done(function() {
                      define_contextMenu(editable, "table#tree");
                  });
  
                  tree_tarefa.reload({
                      url: "orcamentos/"+orcamento+"_tarefa.json"
                  }).done(function() {
                      define_contextMenu(editable, "table#orc_tarefa");
                  });
  
                  $('button.close').click();
              }, 1500);
  
              $('button#salva_tabela').show();
              $('button#chama_finaliza_orcamento').show();
              $('button#planilhas').show();
              $('span#orcamento_fechado').addClass('hidden');
          }
      }else{
          /*
          $("#tree").fancytree("destroy");
          $("table#tree > tbody").append("<tr><td id='checkbox' class='alignCenter'></td><td id='id' style='padding: 4px !important; ' ></td><td id='tree'></td><td class='alignCenter' id='no_input'><input name='unidade' id='unidade' type='text'></td><td class='alignCenter' id='no_input'><input name='qnt' id='qnt' type='text'></td><td class='alignCenter' id='no_input'><input name='valor_qnt' type='text' id='money'></td><td class='alignCenter'><input name='total' type='text' id='money' disabled></td></tr>");
          table("orcamentos/"+orcamento+".json");
          */
          //var tree = $("#tree").fancytree("getTree");
          //var tree_tarefa = $("table#orc_tarefa").fancytree("getTree");
  
          $.ajax({
             url:   'const_grava_tabela.php',
             type:  'POST',
             //cache: false,
             //data:  { ok : 'deu certo!'},
                 data: {id_orcamento:id_orcamento}, //essa e o padrao x-www-form-urlencode
  
             error: function() {
                  $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Erro ao Carregar a Tabela!!</h4>");
                  $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
             },
             success: function(data) { 
                     //tree.reload();
                     $('button.close').click();
                     
             },
             beforeSend: function() {
                     $("div#dialog-body").html("<img src='img/loading.gif' width='45' height='45' style='text-align: right;'>");
                  $("div#dialog-footer").html("<h4 class='modal-title' align='center' id='salvar'>Carregando, aguarde!</h4>");
                  $("button#dialog").click();
             }
          });
  
          tree.reload({
              url: "orcamentos/default.json"
          }).done(function() {
              define_contextMenu(editable, "table#tree");
          });
  
          tree_tarefa.reload({
              url: "orcamentos/default.json"
          }).done(function() {
              define_contextMenu(editable, "table#orc_tarefa");
          });
  
          $('button#salva_tabela').show();
          $('button#chama_finaliza_orcamento').show();
          $('button#planilhas').show();
          $('span#orcamento_fechado').addClass('hidden');
      }
  });
  
  // Finaliza um Orçamento via Ajax e logo em seguida desabilita todos os campos de manipulação/edição da tabela
  $('button#finaliza_orcamento').click(function(){
      if($('select#orcamento option:selected').val() != -1){
  
          let id_orc = $('select#orcamento option:selected').val();
          let editable = $('select#orcamento option:selected').attr('editable');
          let tree = $('table#tree').fancytree('getTree');
          let tree_tarefa = $('table#orc_tarefa').fancytree('getTree');
          let valida = 1;

          console.log(valida);
  
          tree.visit(function(fn){
              if(fn.data.tabela == '3'){
                  valida = 0;
                  return;
              }
          });
  
          if(valida != 0){
              tree_tarefa.visit(function(fn){
                  if(fn.data.tabela == '3'){
                      valida = 0;
                      return;
                  }
              });
          }
  
          //console.log(id_orc);
          console.log(valida);


  
          if(valida == 1){
              if(editable == 1){
  
                  $.ajax({
                     url:   'const_grava_tabela.php',
                     type:  'POST',
                     //cache: false,
                     //data:  { ok : 'deu certo!'},
                         data: {id_orc:id_orc, editable:editable}, //essa e o padrao x-www-form-urlencode
                         dataType:'json',  
  
                     success: function(data) { 
                             window.location.replace("const_tabela.php");
                     },
                     error: function() {
                             $("div#dialog-body").html("<h4 class='modal-title' align='center' id='salvar'>Erro ao salvar!</h4>");
                             $("div#dialog-footer").html("<button type='button' class='btn btn-defaut' data-dismiss='modal' >Fechar</button>");
                             $('button#dialog').click();
                     }
                  });
              }else{
                  alert("Orçamento já finalizado!");
              }
          }else{
              alert("Registre todos os Insumos/Plano de Contas/Tarefas Antes de fechar a Tabela!");
          }
  
      }else{
          alert('Selecione um Orçamento!');
      }
  });
  
  //Rotina para preencher o select do orçamento de acordo com o empreendimento selecionado
  $('select#empre').change(function(){
  
      let empreendimento = $(this).find('> option:selected').val();
  
  
      let tree = $("#tree").fancytree("getTree");
      let tree_tarefa = $("table#orc_tarefa").fancytree("getTree");
  
      tree.reload({
          url: "orcamentos/default.json"
      }).done(function() {
          define_contextMenu(1, "table#tree");
      });
  
      tree_tarefa.reload({
          url: "orcamentos/default.json"
      }).done(function() {
          define_contextMenu(1, "table#orc_tarefa");
      });
  
      $('button#salva_tabela').show();
      $('button#chama_finaliza_orcamento').show();
      $('button#planilhas').show();
      $('span#orcamento_fechado').addClass('hidden');
  
      //Limpo as opções do select de orçamento
      $("select#orcamento").find('> option:not(option[value="-1"])').each(function(){
          $(this).detach();
      });
  
      if(empreendimento != -1){
          $.ajax({
             url:   'const_grava_tabela.php',
             type:  'POST',
             //cache: false,
             //data:  { ok : 'deu certo!'},
              data: {lista_orcamento:empreendimento}, //essa e o padrao x-www-form-urlencode
              dataType:'json',  
  
             success: function(data) { 
                  
                  if(data != 0){
                      for(let i in data){
                          $("select#orcamento").append('<option value="'+data[i].id+'" editable="'+data[i].status_editar+'"  data-finalizado="'+data[i].data_finalizado+'">'+data[i].titulo+'</option>');
                      }
                  }
             },
             error: function() {
                  console.log(0);
             }
          });
      }
  });
  
  //Rotina para listar os sub empreendimentos de acordo com o empreendimento selecionado para realiza
  $('select#select_empreendimento').change(function(){
      let empreendimento = $(this).find('> option:selected').val();
  
      //limpo as opções do select
      $('select#select_sub_empreendimento').find('> option:not(option[value="-1"])').each(function(){
          $(this).detach();
      });
  
      if(empreendimento != -1){
          $.ajax({
             url:   'const_grava_tabela.php',
             type:  'POST',
             //cache: false,
             //data:  { ok : 'deu certo!'},
              data: {lista_sub_empre:empreendimento}, //essa e o padrao x-www-form-urlencode
              dataType:'json',  
  
             success: function(data) { 
                  
                  if(data != 0){
                      for(let i in data){
                          $("select#select_sub_empreendimento").append('<option value="'+data[i].id+'" >'+data[i].titulo+'</option>');
                      }
                  }
             },
             error: function() {
                  console.log(0);
             }
          });
      }
  });
  
  //Rotina para verificar no banco de dados se o insumo/Plano de contas a ser criado já existe no banco de dados
  
  //cria e manipula o auto-complete
  $( function() {
      $.widget( "custom.combobox", {
          _create: function() {
              this.wrapper = $( "<span>" )
              .addClass( "custom-combobox" )
              .insertAfter( this.element );
  
              this.element.hide();
              this._createAutocomplete();
              this._createShowAllButton();
          },
  
          _createAutocomplete: function() {
              var selected = this.element.children( ":selected" ),
              value = selected.val() ? selected.text() : "";
  
              this.input = $( "<input>" )
              .appendTo( this.wrapper )
              .val( value )
              .attr("title", "Digite para pesquisar")
              .attr("required", "")
              .attr("id", "cad_especie")
              .addClass( "form-control" )
              .autocomplete({
                  delay: 0,
                  minLength: 0,
                  source: $.proxy( this, "_source" )
              })
              .tooltip({
                  classes: {
                      "ui-tooltip": "ui-state-highlight"
                  }
              });
  
              this._on( this.input, {
                  autocompleteselect: function( event, ui ) {
                      ui.item.option.selected = true;
                      this._trigger( "select", event, {
                          item: ui.item.option
                      });
                  },
  
                  autocompletechange: "_removeIfInvalid"
              });
          },
  
          _createShowAllButton: function() {
              var input = this.input,
              wasOpen = false
  
              $( "<a>" )
              .attr( "id", "botao_pesquisa" )
              .appendTo( this.wrapper )
              .button({
                  icons: {
                      primary: "ui-icon-triangle-1-s"
                  },
                  text: "false"
              })
              .addClass( "btn btn-defaut" )
              .removeClass("ui-button ui-corner-all ui-widget")
              .on( "click", function() {
                  input.trigger( "focus" );
  
                  // Close if already visible
                  if ( wasOpen ) {
                      return;
                  }
  
                  // Pass empty string as value to search for, displaying all results
                  input.autocomplete( "search", "" );
              });
          },
  
          _source: function( request, response ) {
              var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
              response( this.element.children( "option" ).map(function() {
                  var text = $( this ).text();
                  if ( this.value && ( !request.term || matcher.test(text) ) )
                      return {
                          label: text,
                          value: text,
                          option: this
                      };
                  }) );
          },
  
          _removeIfInvalid: function( event, ui ) {
  
              // Selected an item, nothing to do
              if ( ui.item ) {
                  return;
              }
  
              // Search for a match (case-insensitive)
              var value = this.input.val(),
              valueLowerCase = value.toLowerCase(),
              valid = false;
              this.element.children( "option" ).each(function() {
                  if ( $( this ).text().toLowerCase() === valueLowerCase ) {
                      this.selected = valid = true;
                      return false;
                  }
              });
  
              // Found a match, nothing to do
              if ( valid ) {
                  return;
              }
  
              // Remove invalid value
              this.input
              .val( "" )
              .attr( "title", value + " Item não encontrado !" )
              .tooltip( "open" );
              this.element.val( "" );
              this._delay(function() {
                  this.input.tooltip( "close" ).attr( "title", "" );
              }, 2500 );
              this.input.autocomplete( "instance" ).term = "";
          },
  
          _destroy: function() {
              this.wrapper.remove();
              this.element.show();
          }
      });
  
      $( "#combobox" ).combobox();
      $( "#toggle" ).on( "click", function() {
          $( "#combobox" ).toggle();
      });
  });
  
  //Rotina para manipular os campos de busca de Materiais
  $("#search_material").on("keyup", function(e){
      var n = 0,
      tree = $("table#tree").fancytree("getTree"),
      match = $(this).val();
  
      n = tree.filterNodes(match);
  
      n > 1 ? n : n = 0;
  
      $("button#reset_material").attr("disabled", false);
      $("span#matches").text("(" + n + " Encontrados)");
  }).focus();
  $("button#reset_material").click(function(e){
      var tree = $("table#tree").fancytree("getTree");
  
      $("#search").val("");
      $("span#matches").text("");
      tree.clearFilter();
  });
  
  //Rotina para manipular os campos de busca de Tarefas
  $("#search_tarefa").on("keyup", function(e){
      var n = 0,
      tree = $("table#orc_tarefa").fancytree("getTree"),
      match = $(this).val();
  
      n = tree.filterNodes(match);
  
      n > 1 ? n : n = 0;
  
      $("button#reset_tarefa").attr("disabled", false);
      $("span#matches").text("(" + n + " Encontrados)");
  }).focus();
  $("button#reset_tarefa").click(function(e){
      var tree = $("table#orc_tarefa").fancytree("getTree");
  
      $("#search").val("");
      $("span#matches").text("");
      tree.clearFilter();
  });
  
  
  
