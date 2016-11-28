<div class="appui-h-100 appui-w-100 appui-block">
  <div class="appui-dashboard appui-masonry appui-margin" id="dashboard">
    <div :class="'k-block appui-widget ' + index" v-for="(w, index) in widgets" v-if="w.text && w.num">
      <div class="k-header" v-html="w.text"></div>

      <ul v-if="w.template === 'msg'">
        <li v-for="item in w.items" >
        <span>
          <a href="javascript:;" v-text="item.titre" :onclick="'appui.fn.window(\'message\', {id: ' + item.id + '})'">
          </a>
        </span>
          <span><em v-text="show_auteur(item.auteur)"></em></span>
        </li>
      </ul>

      <ul v-if="w.template === 'adh'">
        <li v-for="item in w.items" >
          <a :href="'adherent/fiche/' + item.id" :style="get_couleur(item)" v-text="item.nom"></a>
        </li>
      </ul>

      <ul v-if="w.template === 'notes'">
        <li v-for="item in w.items" >
          <div v-html="userFull(item.id_user)">
          </div>
          <br>
          <a :href="'adherent/fiche/'+ item.id + '/notes'" :style="get_couleur(item)" v-text="item.nom"></a>
          <br>
          <span v-text="item.texte"></span>
        </li>
      </ul>

      <ul v-if="w.template === 'doc'">
        <li v-for="item in w.items" >
          <a :href="'adherent/fiche/' + item.id + '/pad'" :style="get_couleur(item)">{{item.nom}}</a>
        </li>
      </ul>

      <!--div v-if="w.template === 'stats'">
        <div data-role="chart"
             data-bind="source: appui.dashboard.widgets.stats.items.data"
             :data-theme="theme"
             data-legend="{position: 'bottom'}"
             data-series-defaults="{type: 'line'}"
             data-series="[{field: 'val'}]"
             :data-value-axis="'{labels:{format: \'{0:n0}\'},majorUnit: ' + w.items.mu + '}'"
             data-category-axis="{
              baseUnit: 'fit',
              field: 'date',
              type: 'category',
              maxDateGroups: 20,
              labels:{
                format: 'dd/MM/yy',
                step: 1,
                rotation: '90'
              }
             }"
             data-tooltip="{visible: true,shared: true}">
        </div>
        <div class="dropdownstats">
          <input id="As9275dK2D45gm2C0JSS033sd"
                 data-role="dropdownlist"
                 data-bind="source: appui.dashboard.widgets.stats.items.charts, value: appui.dashboard.widgets.stats.items.value"
                 data-text-field="text"
                 data-value-field="value"
                 style="width: 100%; float: none; clear: none; margin-left: 5px;"
                 onchange="apst.chartChange()" />
        </div>
      </div-->


      <!-- non sappiamo se funziona perchè non abbiamo data-->
      <!--ul v-if="w.template === 'modifs'">
        <li v-for="item in w.items">
          <span>
            <a :href="'adherent/fiche/' + item.id"  :style="get_couleur(item)">{{item.nom}}</a>
          </span>
          <span><em v-text="id_user"></em></span>
        </li>
        <!--li v-for="item in w.items">
          <span>
            <a :href="'adherent/fiche/' + item.id"  :style="get_couleur(item)">{{item.nom}}</a>
          </span>
          <span><em v-text="users()">fsgdfgsdfgsfgsfg</em></span>
        </li>
      </ul-->

      <ul v-if="w.template === 'svn'">
        <li  v-for="item in w.items">
          <div class="k-header k-block" v-text="item.title"></div>
          <ul v-for="obj in item.revisions">
            <li>
              <a :href="'https://svn.apst.travel/revision.php?repname=app&rev='+ obj.revision" target="_blank">Rev. {{obj.revision}}</a>
              <span v-text="showDateAuthor('svn', obj.date_rev, obj.author)"></span>
            </li>
            <li>
              <span v-html="obj.info"></span>
            </li>
          </ul>
        </li>
      </ul>

      <ul v-if="w.template === 'utilisateurs'">
        <li v-for="item in w.items">
          <span>{{item.nom}}</span>
          <span>{{item.last_connection}}</span>
        </li>
      </ul>

      <ul v-if="w.template === 'pdt'">
        <li v-for="item in w.items" class="appui-c">
          <div class="ui tiny horizontal purple statistic">
            <div class="value" v-html="money(item.val)">
            </div>
            <div class="label">
              {{item.titre}}
            </div>
          </div>
        </li>
      </ul>

      <ul v-if="w.template === 'cgar'">
        <li v-for="item in w.items">
          <a :href="'adherent/fiche'+ item.id_adherent +'/cgar'" class="adherent">{{item.nom}}</a>
          <span> {{item.num_jours }} jours</span></li>
      </ul>

      <ul v-if="w.template === 'bugs'">
        <li v-for="item in w.items" class="apst-bugs">
       <span v-if="item.title" :class="item.bugclass" :title="item.status">
         <a :href="'pm/panel/tasks/' + item.id">{{item.title}}</a>
       </span>
          <span v-else :class="item.bugclass" :title=" item.status">
         Sans titre
       </span>
          <span v-text="showDateAuthor('bugs',item.last_activity,'')"></span>
        </li>
      </ul>


      <ul v-if="w.template === 'dossiers'">
        <li v-for="item in w.items">
       <span>
         <a class="adherent"  :href="'adherent/fiche/' + item.id +'/tasks'">{{item.nom}}</a>
       </span>
          <span v-text="showDateAuthor('dossiers',item.deadline,'')"></span>
        </li>
      </ul>
      <!--
          <ul v-if="w.template === 'notes'">
            <li v-for="items in w.items" v-if="w.template !== 'adh'">Ciao</li>
          </ul>

          <ul v-if="w.template !== 'notes'">
            <li v-for="items in w.items" v-if="w.template !== 'adh'">Ciao</li>
          </ul>

          <ul v-if="w.template !== 'notes'">
            <li v-for="items in w.items" v-if="w.template !== 'adh'">Ciao</li>
          </ul>

          <ul v-if="w.template !== 'notes'">
            <li v-for="items in w.items" v-if="w.template !== 'adh'">Ciao</li>
          </ul>

          <ul v-if="w.template !== 'notes'">
            <li v-for="items in w.items" v-if="w.template !== 'adh'">Ciao</li>
          </ul>

          <ul v-if="w.template !== 'notes'">
            <li v-for="items in w.items" v-if="w.template !== 'adh'">Ciao</li>
          </ul>

          <ul v-if="w.template !== 'notes'">
            <li v-for="items in w.items" v-if="w.template !== 'adh'">Ciao</li>
          </ul>

          <ul v-if="w.template !== 'notes'">
            <li v-for="items in w.items" v-if="w.template !== 'adh'">Ciao</li>
          </ul>

          <ul v-if="w.template !== 'notes'">
            <li v-for="items in w.items" v-if="w.template !== 'adh'">Ciao</li>
          </ul-->

    </div>
  </div>
</div>
<!--

<script id="home_modifs_tpl" type="text/x-kendo-template">
  <li>
    <span><a href="adherent/fiche/#: id #" class="#: statut #">#: nom #</a></span>
    <span><em>par #: appui.app.apst.users[appui.fn.search(appui.app.apst.users, "value", id_user)].text #</em></span>
  </li>
</script>

<script id="home_svn_tpl" type="text/x-kendo-template">
  <div class="k-header k-block">#: title #</div>
  # for ( var i = 0; i < data.revisions.length; i++ ){
  # <li>
    <span><a href="https://svn.apst.travel/revision.php?repname=app&rev=#: data.revisions[i].revision #" target="_blank">Rev. #: data.revisions[i].revision #</a></span>
    <span>#= appui.fn.fdate(data.revisions[i].date_rev) # par #: data.revisions[i].author #</span><br>
    #= data.revisions[i].info #
  </li>#
  } #
</script>

<script id="home_utilisateurs_tpl" type="text/x-kendo-template">
  <li>
    <span>#: nom #</span>
    <span>#: last_connection #</span>
  </li>
</script>

<script id="home_pdt_tpl" type="text/x-kendo-template">
  <li class="appui-c">
    <div class="ui tiny horizontal purple statistic">
      <div class="value">
        # val = val.toString().match(/^[-+]?[0-9]+\.[0-9]+$/) ? appui.fn.money(Math.round(val/1000)) + " k&euro;" : appui.fn.money(val); # #= val #
      </div>
      <div class="label">
        #: titre #
      </div>
    </div>
  </li>
</script>

<script id="home_cgar_tpl" type="text/x-kendo-template">
  <li>
  <span>
    <a href="adherent/fiche/#: id_adherent #/cgar" class="adherent">#: nom #</a>
  </span>
    <span>#: num_jours # jours</span>
  </li>
</script>

<script id="home_bugs_tpl" type="text/x-kendo-template">
  <li class="apst-bugs">
  <span class="#: bugclass #" title="#: status #">
    <a href="pm/panel/tasks/#: id #">#= title ? title : 'Sans titre' #</a>
  </span>
    <span>#= appui.fn.fdate(last_activity) #</span>
  </li>
</script>

<script id="home_dossiers_tpl" type="text/x-kendo-template">
  <li>
  <span>
    <a href="adherent/fiche/#: id #/tasks" class="adherent">#: nom #</a>
  </span>
    <span>#= appui.fn.fdate(deadline) #</span>
  </li>
</script>

<script id="home_stats_tpl" type="text/x-kendo-template">
  <li>
  </li>
</script-->
