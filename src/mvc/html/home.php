<div class="appui-h-100 appui-w-100 appui-block">
  <div class="appui-dashboard appui-masonry appui-margin" id="dashboard">
    <div :class="'k-block appui-widget appui-widget-' + index" v-for="(w, index) in widgets" v-if="w.text && w.num" data-handle=".appui-widget-header">
      <div class="k-header appui-widget-header" v-html="'<h4>' + w.text + '</h4>'"></div>
      <div class="appui-widget-content">

        <ul v-if="w.template === 'msg'">
          <li v-for="item in w.items" >
        <span>
          <a href="javascript:;" v-text="item.titre" :onclick="'bbn.fn.window(\'message\', {id: ' + item.id + '})'">
          </a>
        </span>
            <span><em v-text="show_auteur(item.auteur)"></em></span>
          </li>
        </ul>

        <ul v-else-if="w.template === 'adh'">
          <li v-for="item in w.items" >
            <a :href="'adherent/fiche/' + item.id" :style="get_couleur(item)" v-text="item.nom"></a>
          </li>
        </ul>

        <ul v-else-if="w.template === 'notes'">
          <li v-for="item in w.items" >
            <div v-html="userFull(item.id_user)"></div>
            <br>
            <a :href="'adherent/fiche/'+ item.id + '/notes'" :style="get_couleur(item)" v-text="item.nom"></a>
            <br>
            <span v-text="item.texte"></span>
          </li>
        </ul>

        <ul v-else-if="w.template === 'doc'">
          <li v-for="item in w.items">
            <a :href="'adherent/fiche/' + item.id + '/pad'" :style="get_couleur(item)">{{item.nom}}</a>
          </li>
        </ul>
        <ul v-else-if="w.template === 'svn'">
          <li v-for="item in w.items">
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

        <ul v-else-if="w.template === 'utilisateurs'">
          <li v-for="item in w.items">
            <span>{{item.nom}}</span>
            <span>{{item.last_connection}}</span>
          </li>
        </ul>

        <ul v-else-if="w.template === 'pdt'">
          <li v-for="item in w.items" class="appui-c">
            <div class="appui-stats">
              <div class="value appui-purple" v-html="money(item.val)"></div>
              <div class="label">{{item.titre}}</div>
            </div>
          </li>
        </ul>

        <ul v-else-if="w.template === 'cgar'">
          <li v-for="item in w.items">
            <a :href="'adherent/fiche'+ item.id_adherent +'/cgar'" class="adherent">{{item.nom}}</a>
            <span> {{item.num_jours }} jours</span>
          </li>
        </ul>

        <ul v-else-if="w.template === 'bugs'">
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


        <ul v-else-if="w.template === 'dossiers'">
          <li v-for="item in w.items">
          <span>
            <a class="adherent"  :href="'adherent/fiche/' + item.id +'/tasks'">{{item.nom}}</a>
          </span>
            <span v-text="showDateAuthor('dossiers',item.deadline,'')"></span>
          </li>
        </ul>

        <p v-else>Ce widget revient très bientôt...</p>
      </div>



      <!--div v-if="w.template === 'stats'">
        <div data-role="chart"
             data-bind="source: bbn.dashboard.widgets.stats.items.data"
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
                 data-bind="source: bbn.dashboard.widgets.stats.items.charts, value: bbn.dashboard.widgets.stats.items.value"
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

    </div>
  </div>
</div>
<script type="text/html" id="appui-dashboard-new-note-tpl">
  <form id="iasjdiahoi3248asdho" action="notes/actions/insert" style="display:none">
    <input class="k-textbox" name="title" placeholder="Titre" style="width: 100%">
    <textarea name="content" style="width: 100%"></textarea>
    <div class="appui-c appui-lg">
      <input id="appui-note-checkbox-private" class="k-checkbox" name="private" value="1" type="checkbox">
      <label class="k-checkbox-label" for="appui-note-checkbox-private" style="margin-right: 2em">
        <i class="fa fa-eye-slash"> </i>
      </label>
      <input id="appui-note-checkbox-locked" class="k-checkbox" name="locked" value="1" type="checkbox">
      <label class="k-checkbox-label" for="appui-note-checkbox-locked" style="margin-right: 2em">
        <i class="fa fa-lock"> </i>
        </label>
      <button class="k-button" type="button" style="margin-right:0.5em"><i class="fa fa-close"></i> Annuler</button>
      <button class="k-button" type="submit"><i class="fa fa-send"></i> Ajouter</button>
      </div>
    </form>

</script>
