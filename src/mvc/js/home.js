// Javascript Document
//appui.tabstrip.ele.tabNav("addData", data, 0);
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
                appui.success("Note cr&eacute;&eacute;e!");
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

appui.home = kendo.observable(data);
kendo.bind($dashboard, appui.home);
appui.home.bind("change", function(e){
  bbn.fn.cssMason($dashboard);
});


*/
bbn.fn.log("DATA", data);
data.test1 = {
  text: "Test with content",
  content: '<h2>This is a test</h2>'
};
data.test2 = {
  text: "Test with simple items",
  items: [
    "Hello",
    "World"
  ]
};

var $ele = $(ele);
for ( var n in data ){
  data[n].closable = true;
  data[n].zoomable = true;
}
data.news.closable = false;
data.news.buttonsRight = [{
  icon: 'fa fa-sticky-note-o',
  text: bbn._("Nouvelle note"),
  action: 'toggleNote'
}];

for( var n in data ){
  //data[n].template = 'adh';
  if ( data[n].template ){
    data[n].component = 'apst-widget-' + (data[n].template ? data[n].template : 'adh');
  }
}
bbn.dashboard = new Vue({
  el: $ele.children(".appui-full-content")[0],
  data: {
    widgets: data,
    theme: appui.theme
  },
  methods: {
    show_auteur: function(auteur){
      return 'par '+ apst.utilisateur(auteur);
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
        $c.children(".content").append(tpl);
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
            appui.success("Note cr&eacute;&eacute;e!");
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
  }
});
