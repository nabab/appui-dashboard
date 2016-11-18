// Javascript Document
//appui.app.tabstrip.ele.tabNav("addData", data, 0);
var $dashboard = $(".appui-dashboard", ele),
    $msgCont = $("ul[data-template=home_msg_tpl]", "#apst_dashboard", ele)
      .closest("div.k-block.appui-widget"),
    $msgContHeader = $("div.k-header", $msgCont),
    msgNew =
      '<form id="iasjdiahoi3248asdho" action="notes/actions/insert" style="display:none">' +
      '<input class="k-textbox" name="title" placeholder="Titre" style="width: 100%">' +
      '<textarea name="content" style="width: 100%"></textarea>' +
      '<div class="appui-c appui-lg">' +
      '<input id="appui-note-checkbox-private" class="k-checkbox" name="private" value="1" type="checkbox">' +
      '<label class="k-checkbox-label" for="appui-note-checkbox-private" style="margin-right: 2em"> ' +
      '<i class="fa fa-eye-slash"> </i>' +
      '</label> ' +
      '<input id="appui-note-checkbox-locked" class="k-checkbox" name="locked" value="1" type="checkbox">' +
      '<label class="k-checkbox-label" for="appui-note-checkbox-locked" style="margin-right: 2em"> ' +
      '<i class="fa fa-lock"> </i>' +
      '</label> ' +
      '<button class="k-button" type="button" style="margin-right:0.5em"><i class="fa fa-close"></i> Annuler</button>' +
      '<button class="k-button" type="submit"><i class="fa fa-send"></i> Ajouter</button>' +
      '</div>' +
      '</form>';

$msgContHeader.prepend(
  $('<div/>').append(
    $('<i class="fa fa-sticky-note-o appui-p" title="Nouvelle note"></i>').click(function(){
      var $msgNew = $("#iasjdiahoi3248asdho", $msgCont);
      if ( !$("#iasjdiahoi3248asdho", $msgCont).length ){
        $msgCont.append(msgNew);
        $msgNew = $("#iasjdiahoi3248asdho", $msgCont);
        $msgNew.show();
        $("textarea", $msgNew).kendoEditor({
          tools: [
            "bold",
            "italic",
            "underline",
            "insertUnorderedList",
            "insertOrderedList"
          ]
        });
        appui.fn.cssMason($dashboard);
        $("i.fa-close", $msgNew).parent().on('click', function(){
          $("textarea", $msgNew).data("kendoEditor").destroy();
          $msgNew.remove();
          appui.fn.cssMason($dashboard);
        });
        $("input[name=title]", $msgCont).focus();
        $msgNew.data("script", function(d){
          if ( d.success ){
            $msgNew.remove();
            appui.app.notification.success("Note cr&eacute;&eacute;e!");
            appui.fn.cssMason($dashboard);
          }
          else{
            appui.fn.alert();
          }
        })
      }
      else{
        $msgNew.remove();
        appui.fn.cssMason($dashboard);
      }
    })
  )
);
appui.fn.addToggler($dashboard);

appui.app.home = kendo.observable(data);
kendo.bind($dashboard, appui.app.home);
appui.app.home.bind("change", function(e){
  appui.fn.cssMason($dashboard);
});
