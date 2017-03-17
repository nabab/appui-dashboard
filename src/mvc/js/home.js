// Javascript Document
//bbn.app.tabstrip.ele.tabNav("addData", data, 0);
bbn.fn.log("THE DATA", data);
/*
var $dashboard = $(".appui-dashboard", ele),
    $msgCont = $("ul[data-template=home_msg_tpl]", "#apst_dashboard", ele)
        .closest("div.k-block.appui-widget"),
    $msgContHeader = $("div.k-header", $msgCont),
    msgNew = $("#appui-dashboard-new-note-tpl").html();
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
            bbn.fn.cssMason($dashboard);
            $("i.fa-close", $msgNew).parent().on('click', function(){
              $("textarea", $msgNew).data("kendoEditor").destroy();
              $msgNew.remove();
              bbn.fn.cssMason($dashboard);
            });
            $("input[name=title]", $msgCont).focus();
            $msgNew.data("script", function(d){
              if ( d.success ){
                $msgNew.remove();
                appui.notification.success("Note cr&eacute;&eacute;e!");
                bbn.fn.cssMason($dashboard);
              }
              else{
                bbn.fn.alert();
              }
            })
          }
          else{
            $msgNew.remove();
            bbn.fn.cssMason($dashboard);
          }
        })
    )
);
bbn.fn.addToggler($dashboard);

bbn.app.home = kendo.observable(data);
kendo.bind($dashboard, bbn.app.home);
bbn.app.home.bind("change", function(e){
  bbn.fn.cssMason($dashboard);
});


*/

var $ele = $(ele);
bbn.dashboard = new Vue({
  el: $(".appui-dashboard", ele)[0],
  data: {
    widgets: data,
    theme: bbn.app.theme

  },
  methods: {
    get_couleur: function(item){
      return 'color: ' + apst.get_couleur(item.statut, item.statut_prospect !== undefined ? item.statut_prospect : '');
    },
    show_auteur: function(auteur){
      return 'par '+ apst.utilisateur(auteur);
    },
    showDateAuthor: function(type,date,author){
      if(type === 'svn') {
        return bbn.fn.fdate(date) + ' par ' + author;
      }
      else{
        return bbn.fn.fdate(date);
      }
    },
    userFull: function(id_user){
      return apst.userFull(id_user)
    },
    money: function(val) {
      return val.toString().match(/^[-+]?[0-9]+\.[0-9]+$/) ? bbn.fn.money(Math.round(val / 1000)) + " k&euro;" : bbn.fn.money(val);
    },
    getNoteContainer: function(){
      return $(".appui-widget-news", this.$el);
    },
    getNoteTemplate: function(){
      return $("#appui-dashboard-new-note-tpl", ele).html();
    },
    toggleNote: function(){
      var v = this,
          $c = v.getNoteContainer(),
          tpl = v.getNoteTemplate(),
          $note = $("#iasjdiahoi3248asdho", $c);
      $c.css("height", "auto");
      if ( !$note.length ) {
        $c.children(".appui-widget-content").append(tpl);
        $note = $("#iasjdiahoi3248asdho", $c).show();
        $("textarea", $note).kendoEditor({
          tools: [
            "bold",
            "italic",
            "underline",
            "insertUnorderedList",
            "insertOrderedList"
          ]
        });
        $c.css("height", "auto");
        bbn.fn.cssMason(v.$el);
        $("i.fa-close", $note).parent().on('click', function(){
          v.toggleNote();
        });
        $("input[name=title]", $c).focus();
        $note.data("script", function(d){
          if ( d.success ){
            v.toggleNote();
            appui.notification.success("Note cr&eacute;&eacute;e!");
          }
          else{
            bbn.fn.alert();
          }
        }).bbn("animateCss", "bounceIn", function () {
          bbn.fn.cssMason(v.$el);
        });
      }
      else{
        $note.bbn("animateCss", "bounceOut", function(){
          $("textarea", $note).data("kendoEditor").destroy();
          $note.remove();
          $c.css("height", "auto");
          setTimeout(function(){
            bbn.fn.cssMason(v.$el);
          }, 50);
        })
      }
    },
  },
  mounted : function(){
    var vm = this,
        $c = this.getNoteContainer(),
        $h = $("div.k-header", $c);
    bbn.fn.analyzeContent(vm.$el, true);
    bbn.fn.addToggler($(vm.$el));
    $h.append(
      $('<div/>').append(
        $('<i class="fa fa-sticky-note-o appui-p" title="Nouvelle note" tabindex="0"></i>').click(function(){
          vm.toggleNote();
        })
      )
    );
  }
});
