<bbn-form :action="configurator.root + 'actions/configurator/widgets'"
          :source="source.row"
          :data="{
            action: source.row[configurator.optCfg.fields.id] ? 'update' : 'insert',
            isContainer: true
          }"
          @success="success"
          @error="error"
>
  <div class="bbn-spadded bbn-grid-fields">
    <label><?= _('Text') ?></label>
    <bbn-input v-model="source.row[configurator.optCfg.fields.text]"
               :required="true"/>
    <label><?= _('Code') ?></label>
    <bbn-input v-model="source.row[configurator.optCfg.fields.code]"/>
  </div>
</bbn-form>