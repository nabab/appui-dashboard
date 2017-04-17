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
bbn.dashboard = new Vue({
  el: $ele.children(".appui-full-content")[0],
  data: {
    widgets: data,
    theme: appui.theme,
    components: {
      msg: {
        name: 'msg',
        props: ['item'],
        template: `
<span>
  <a href="javascript:;" @click="openMessage(item.id)">{{item.titre}}</a>
</span>
`,
        methods: {
          openMessage: function (id){
            bbn.fn.window("message", {id: id});
          }
        }
      },
      adh: {
        name: 'adh',
        props: ['item'],
        methods: {
          get_couleur: function(item){
            return apst.get_couleur(item.statut, item.statut_prospect !== undefined ? item.statut_prospect : '');
          },
        },
        template: `
<a :href="'adherent/fiche/' + item.id" :style="'color: ' + get_couleur(item)">
  {{item.nom}}
</a>
`
      },
      notes: {
        name: 'notes',
        props: ['item'],
        methods: {
          get_couleur: function(item){
            return apst.get_couleur(item.statut, item.statut_prospect !== undefined ? item.statut_prospect : '');
          },
          userName: function(id_user){
            return apst.userName(id_user)
          },
        },
        template: `
<div class="appui-form-full">
  <div class="appui-w-100">
    <a :href="'adherent/fiche/'+ item.id + '/notes'" :style="'color: ' + get_couleur(item)" v-text="item.nom">
      {{item.nom}}
    </a>
  </div>
  <div class="appui-w-100">
    <bbn-initial width="20" height="20" :user-id="item.id_user" 
    style="vertical-align: middle; padding-right: 3px"></bbn-initial>
    <div class="appui-iblock" v-html="userName(item.id_user)"></div>
  </div>
  <div class="appui-w-100">{{item.texte}}</div>
</div>
`
      },
      doc: {
        name: 'doc',
        props: ['item'],
        methods: {
          get_couleur: function(item){
            return apst.get_couleur(item.statut, item.statut_prospect !== undefined ? item.statut_prospect : '');
          },
        },
        template: `
<a :href="'adherent/fiche/' + item.id + '/pad'" :style="'color: ' + get_couleur(item)">
  {{item.nom}}
</a>`
      },
      svn: {
        name: 'svn',
        props: ['item'],
        methods: {
          showDateAuthor: function(type,date,author){
            if(type === 'svn') {
              return bbn.fn.fdate(date) + ' par ' + author;
            }
            else{
              return bbn.fn.fdate(date);
            }
          },
        },
        template: `
<div class="appui-w-100">
  <div class="k-header k-block" v-text="item.title"></div>
  <ul v-for="obj in item.revisions">
    <li>
      <div class="appui-block-left">
        <a :href="'https://svn.apst.travel/revision.php?repname=app&rev='+ obj.revision" target="_blank">Rev. {{obj.revision}}</a>
      </div>
      <div class="appui-block-right appui-r" v-text="showDateAuthor('svn', obj.date_rev, obj.author)"></div>
    </li>
    <li>
      <div class="appui-w-100" v-html="obj.info"></div>
    </li>
  </ul>
</div>
`
      },
      utilisateurs: {
        name: 'utilisateurs',
        props: ['item'],
        template: `
<div class="appui-w-100">
  <span>{{item.nom}}</span>
  <span>{{item.last_connection}}</span>
</div>
`
      },
      pdt: {
        name: 'pdt',
        props: ['item'],
        methods: {
          money: function(val) {
            return val.toString().match(/^[-+]?[0-9]+\.[0-9]+$/) ? bbn.fn.money(Math.round(val / 1000)) + " k&euro;" : bbn.fn.money(val);
          },
        },
        template: `
<div class="appui-stats appui-c">
  <div class="value appui-purple" v-html="money(item.val)"></div>
  <div class="label">{{item.titre}}</div>
</div>
`
      },
      cgar: {
        name: 'cgar',
        props: ['item'],
        template: `
<div>
  <a :href="'adherent/fiche'+ item.id_adherent +'/cgar'" class="adherent">{{item.nom}}</a>
  <span> {{item.num_jours }} jours</span>
</div>
`
      },
      bugs: {
        name: 'bugs',
        props: ['item'],
        methods: {
          showDateAuthor: function(type,date,author){
            if(type === 'svn') {
              return bbn.fn.fdate(date) + ' par ' + author;
            }
            else{
              return bbn.fn.fdate(date);
            }
          },
        },
        template: `
<div>
  <span v-if="item.title" :class="item.bugclass" :title="item.status">
    <a :href="'pm/panel/tasks/' + item.id">{{item.title}}</a>
  </span>
  <span v-else :class="item.bugclass" :title=" item.status">
    Sans titre
  </span>
  <span v-text="showDateAuthor('bugs',item.last_activity,'')"></span>
</div>
`
      },
      dossiers: {
        name: 'dossiers',
        props: ['item'],
        methods: {
          showDateAuthor: function(type,date,author){
            if(type === 'svn') {
              return bbn.fn.fdate(date) + ' par ' + author;
            }
            else{
              return bbn.fn.fdate(date);
            }
          },
        },
        template: `
<div>
  <span>
    <a class="adherent"  :href="'adherent/fiche/' + item.id +'/tasks'">{{item.nom}}</a>
  </span>
  <span v-text="showDateAuthor('dossiers',item.deadline,'')"></span>
</div>
`
      }
    }
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
