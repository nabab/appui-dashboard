// Javascript Document
//appui.tabstrip.ele.tabNav("addData", data, 0);
(function(){
  return {
    data: function(){
      var vm = this,
          data = vm.source;
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

      for ( var n in data ){
        //data[n].template = 'adh';
        if ( data[n].template ){
          data[n].component = 'apst-widget-' + (data[n].template ? data[n].template : 'adh');
        }
      }
      return {
        widgets: data,
        theme: appui.theme
      }
    },
    methods: {
      show_auteur: function (auteur){
        return 'par ' + apst.utilisateur(auteur);
      },
      getNoteContainer: function (){
        return $(".bbn-widget-news", this.$el);
      },
      getNoteTemplate: function (){
        return $("#bbn-dashboard-new-note-tpl", ele).html();
      },
      toggleNote: function (){
        var v     = this,
            $c    = v.getNoteContainer(),
            tpl   = v.getNoteTemplate(),
            $note = $("#iasjdiahoi3248asdho", $c);
        $c.css("height", "auto");
        if ( !$note.length ){
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
          $("i.fa-close", $note).parent().on('click', function (){
            v.toggleNote();
          });
          $("input[name=title]", $c).focus();
          $note.data("script", function (d){
            if ( d.success ){
              v.toggleNote();
              appui.success("Note cr&eacute;&eacute;e!");
            }
            else{
              bbn.fn.alert();
            }
          }).bbn("animateCss", "bounceIn", function (){
            bbn.fn.cssMason(v.$el);
          });
        }
        else{
          $note.bbn("animateCss", "bounceOut", function (){
            $("textarea", $note).data("kendoEditor").destroy();
            $note.remove();
            $c.css("height", "auto");
            setTimeout(function (){
              bbn.fn.cssMason(v.$el);
            }, 50);
          })
        }
      },
    },
    mounted: function (){
      var vm = this,
          $c = this.getNoteContainer(),
          $h = $("div.k-header", $c);
      bbn.fn.analyzeContent(vm.$el, true);
    }
  };
})();