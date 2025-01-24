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
          <template v-if="!!extraFields && !source.row[configurator.optCfg.fields.id]">
            <label><?= _('Plugin') ?></label>
            <bbn-dropdown v-model="source.row.plugin"
                          :nullable="true"
                          :source="plugins"/>
          </template>

          <label><?= _('Name') ?></label>
          <bbn-input v-model="source.row[configurator.optCfg.fields.text]"
                     class="bbn-wide"
                     :required="true"/>

          <label><?= _('Code') ?></label>
          <bbn-input v-model="source.row[configurator.optCfg.fields.code]"
                     class="bbn-wide"
                    :required="true"/>

          <label><?= _('URL') ?></label>
          <bbn-input v-model="source.row.url"
                     class="bbn-wide"/>

          <label><?= _('Icon') ?></label>
          <bbn-input v-model="source.row.icon"
                     class="bbn-wide"/>

          <label><?= _('Closable') ?></label>
          <bbn-checkbox v-model="source.row.closable"
                        :value="true"
                        :novalue="false"/>

          <label><?= _('Observe') ?></label>
          <bbn-checkbox v-model="source.row.observe"
                        :value="true"
                        :novalue="false"/>

          <label><?= _('Limit') ?></label>
          <bbn-numeric v-model="source.row.limit"
                       class="bbn-wide"
                      :min="0"/>

          <label><?= _('Component') ?></label>
          <bbn-input v-model="source.row.component"
                     class="bbn-wide"/>

          <label><?= _('itemComponent') ?></label>
          <bbn-input v-model="source.row.itemComponent"
                     class="bbn-wide"/>

          <label><?= _('Right buttons') ?></label>
          <bbn-json-editor v-model="source.row.buttonsRight"
                           class="bbn-widest"/>

          <label><?= _('Left buttons') ?></label>
          <bbn-json-editor v-model="source.row.buttonsLeft"
                           class="bbn-widest"/>

          <label><?= _("Component's options") ?></label>
          <bbn-json-editor v-model="source.row.options"
                           class="bbn-widest"/>

          <label><?= _('Cache') ?></label>
          <bbn-numeric v-model="source.row.cache"
                       :min="0"
                       class="bbn-wide"/>
        </div>
      </bbn-form>
    </div>
  </div>
</div>
