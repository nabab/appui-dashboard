<bbn-form :action=" source.url || (configurator.root + 'actions/configurator/widgets')"
          :source="source.row"
          :data="source.data"
          @success="d => isFunction(source.success) ? source.success(d) : false">
  <div class="bbn-spadded bbn-grid-fields">
    <label><?=_('Name')?></label>
    <bbn-input v-model="source.row[configurator.optCfg.fields.text]"
               :required="true"/>
    <label><?=_('Code')?></label>
    <bbn-input v-model="source.row[configurator.optCfg.fields.code]"
               :required="true"/>
    <label><?=_('Closable')?></label>
    <bbn-checkbox v-model="source.row.closable"
                  :value="true"
                  :novalue="false"/>
    <label><?=_('Observe')?></label>
    <bbn-checkbox v-model="source.row.observe"
                  :value="true"
                  :novalue="false"/>
    <label><?=_('Limit')?></label>
    <bbn-numeric v-model="source.row.limit"
                 :min="0"/>
    <label><?=_('Component')?></label>
    <bbn-input v-model="source.row.component"/>
    <label><?=_('itemComponent')?></label>
    <bbn-input v-model="source.row.itemComponent"/>
    <label><?=_('Right buttons')?></label>
    <bbn-json-editor v-model="source.row.rightButtons"/>
    <label><?=_('Left buttons')?></label>
    <bbn-json-editor v-model="source.row.leftButtons"/>
    <label><?=_("Component's options")?></label>
    <bbn-json-editor v-model="source.row.options"/>
    <label><?=_('Cache')?></label>
    <bbn-numeric v-model="source.row.cache"
                :min="0"/>
  </div>
</bbn-form>