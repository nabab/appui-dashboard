<div class="bbn-dashboard bbn-masonry bbn-margin" id="cont">


  <div class="k-block bbns-widget{{cls}}" v-for="d in data" /*v-if="data.link.num"*/>
    <div class="k-header"v-text="ciao"></div>
    <!--ul data-bbn-type="widget_{{link}}" data-template="home_{{template}}_tpl" data-bind="source: {{link}}.items"></ul-->
  </div>

</div>


<script id="home_widget_tpl" type="text/x-kendo-template">
  <div class="k-block bbns-widget">
    <div class="k-header">#= title #</div>
    <ul id="bbns-widgets_#: name #" data-template="home_#: template #_tpl" data-bind="source: data, visible: num"></ul>
  </div>
</script>
<script id="home_msg_tpl" type="text/x-kendo-template">
  <li>
  <span>
    <a href="javascript:;" onclick="bbn.fn.window('message', {id: #: id # });">
      #: titre #
    </a>
  </span>
    <span><em>par #= apst.utilisateur(auteur) #</em></span>
  </li>
</script>

<script id="home_adh_tpl" type="text/x-kendo-template">
  <li><a href="adherent/fiche/#: id #" style="color: #: apst.get_couleur(statut, statut_prospect !== undefined ? statut_prospect : '') #">#: nom #</a></li>
</script>

<script id="home_notes_tpl" type="text/x-kendo-template">
  <li>
    #= apst.userFull(id_user) #<br>
    <a href="adherent/fiche/#: id #/notes" class="#: statut #">#: nom #</a><br>
    #= texte #
  </li>
</script>

<script id="home_doc_tpl" type="text/x-kendo-template">
  <li>
    <a href="adherent/fiche/#: id #/pad" class="#: statut #">#: nom #</a>
  </li>
</script>

<script id="home_modifs_tpl" type="text/x-kendo-template">
  <li>
    <span><a href="adherent/fiche/#: id #" class="#: statut #">#: nom #</a></span>
    <span><em>par #: appui.apst.users[bbn.fn.search(appui.apst.users, "value", id_user)].text #</em></span>
  </li>
</script>

<script id="home_svn_tpl" type="text/x-kendo-template">
  <div class="k-header k-block">#: title #</div>
  # for ( var i = 0; i < data.revisions.length; i++ ){
  # <li>
    <span><a href="https://svn.apst.travel/revision.php?repname=app&rev=#: data.revisions[i].revision #" target="_blank">Rev. #: data.revisions[i].revision #</a></span>
    <span>#= bbn.fn.fdate(data.revisions[i].date_rev) # par #: data.revisions[i].author #</span><br>
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
  <li class="bbn-c">
    <div class="ui tiny horizontal purple statistic">
      <div class="value">
        # val = val.toString().match(/^[-+]?[0-9]+\.[0-9]+$/) ? bbn.fn.money(Math.round(val/1000)) + " k&euro;" : bbn.fn.money(val); # #= val #
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
    <a href="pm/page/tasks/#: id #">#= title ? title : 'Sans titre' #</a>
  </span>
    <span>#= bbn.fn.fdate(last_activity) #</span>
  </li>
</script>

<script id="home_dossiers_tpl" type="text/x-kendo-template">
  <li>
  <span>
    <a href="adherent/fiche/#: id #/tasks" class="adherent">#: nom #</a>
  </span>
    <span>#= bbn.fn.fdate(deadline) #</span>
  </li>
</script>

<script id="home_stats_tpl" type="text/x-kendo-template">
  <li>
    <div data-role="chart"
         data-bind="source: data"
         data-theme="#: appui.theme #"
         data-legend="{position: 'bottom'}"
         data-series-defaults="{type: 'line'}"
         data-series="[{field: 'val'}]"
         data-value-axis="{
         labels:{format: '{0:n0}'},
         majorUnit: #= mu #
       }"
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
             data-bind="source: charts, value: value"
             data-text-field="text"
             data-value-field="value"
             style="width: 100%; float: none; clear: none; margin-left: 5px;"
             onchange="apst.chartChange()" />
    </div>
  </li>
</script>
