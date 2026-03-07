<div>
  <div class="bbn-padding bbn-centered-block">
    <div class="bbn-card bbn-vlmargin">
      <bbn-form :action=" source.url || (configurator.root + 'actions/configurator/widgets')"
                :source="source.row"
                :data="source.data"
                @success="d => isFunction(source.success) ? source.success(d) : emitSuccess(d)"
                :scrollable="false"
                @failure="emitError"
                mode="big">
        <div class="bbn-spadding bbn-grid-fields">
          <template bbn-if="!!extraFields && !source.row[configurator.optCfg.fields.id]">
            <label><?= _('Plugin') ?></label>
            <bbn-dropdown bbn-model="source.row.plugin"
                          :nullable="true"
                          :source="plugins"/>
          </template>

          <label><?= _('Name') ?></label>
          <bbn-input bbn-model="source.row[configurator.optCfg.fields.text]"
                     class="bbn-wide"
                     :required="true"/>

          <label><?= _('Code') ?></label>
          <bbn-input bbn-model="source.row[configurator.optCfg.fields.code]"
                     class="bbn-wide"
                    :required="true"/>

          <label><?= _('URL') ?></label>
          <bbn-input bbn-model="source.row.url"
                     class="bbn-wide"/>

          <label><?= _('Icon') ?></label>
          <bbn-input bbn-model="source.row.icon"
                     class="bbn-wide"/>

          <label><?= _('Closable') ?></label>
          <bbn-checkbox bbn-model="source.row.closable"
                        :value="true"
                        :novalue="false"/>

          <label><?= _('Observe') ?></label>
          <bbn-checkbox bbn-model="source.row.observe"
                        :value="true"
                        :novalue="false"/>

          <label><?= _('Limit') ?></label>
          <bbn-numeric bbn-model="source.row.limit"
                       class="bbn-wide"
                      :min="0"/>

          <label><?= _('Durée du cache') ?></label>
          <bbn-numeric bbn-model="source.row.cache"
                       class="bbn-wide"
                       :nullable="true"
                      :min="0"/>

          <label><?= _('Component') ?></label>
          <bbn-input bbn-model="source.row.component"
                     class="bbn-wide"/>

          <label><?= _('itemComponent') ?></label>
          <bbn-input bbn-model="source.row.itemComponent"
                     class="bbn-wide"/>

          <label><?= _('Right buttons') ?></label>
          <bbn-json-editor bbn-model="source.row.buttonsRight"
                           class="bbn-widest"/>

          <label><?= _('Left buttons') ?></label>
          <bbn-json-editor bbn-model="source.row.buttonsLeft"
                           class="bbn-widest"/>

          <label><?= _("Component's options") ?></label>
          <bbn-json-editor bbn-model="source.row.options"
                           class="bbn-widest"/>
        </div>
      </bbn-form>
    </div>
  </div>
</div>
