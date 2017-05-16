<div class="bbn-full-content">
  <bbn-dashboard :source="widgets"></bbn-dashboard>
</div>

<script type="text/html" id="bbn-dashboard-new-note-tpl">
  <form id="iasjdiahoi3248asdho" action="notes/actions/insert" style="display:none">
    <input class="k-textbox" name="title" placeholder="Titre" style="width: 100%">
    <textarea name="content" style="width: 100%"></textarea>
    <div class="bbn-c bbn-lg">
      <input id="bbn-note-checkbox-private" class="k-checkbox" name="private" value="1" type="checkbox">
      <label class="k-checkbox-label" for="bbn-note-checkbox-private" style="margin-right: 2em">
        <i class="fa fa-eye-slash"> </i>
      </label>
      <input id="bbn-note-checkbox-locked" class="k-checkbox" name="locked" value="1" type="checkbox">
      <label class="k-checkbox-label" for="bbn-note-checkbox-locked" style="margin-right: 2em">
        <i class="fa fa-lock"> </i>
        </label>
      <button class="k-button" type="button" style="margin-right:0.5em"><i class="fa fa-close"></i> Annuler</button>
      <button class="k-button" type="submit"><i class="fa fa-send"></i> Ajouter</button>
    </div>
  </form>
</script>


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

