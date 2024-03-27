<!-- HTML Document -->
<div class="bbn-overlay appui-dashboard-configurator-dashboard">
  <bbn-splitter orientation="horizontal">
    <bbn-pane :size="350" class="bbn-bordered-right">
      <bbn-splitter orientation="vertical">
        <bbn-pane>
          <!-- Used widgets -->
          <div class="bbn-flex-height">
            <div class="bbn-header bbn-spadded bbn-b bbn-c bbn-no-border-right bbn-no-border-top"><?= _('WIDGETS') ?></div>
            <div class="bbn-flex-fill">
              <bbn-tree :source="source.widgets"
                        uid="id"
                        ref="tree"
                        :map="mapTree"
                        @select="selectWidget"
                        :item-component="$options.components.widget"
                        :sortable="true"
                        @order="changeNum"/>
            </div>
          </div>
        </bbn-pane>
        <bbn-pane>
          <!-- Available widgets -->
          <div class="bbn-flex-height">
            <div class="bbn-flex-width bbn-header bbn-spadded bbn-vmiddle bbn-no-border-right">
              <div class="bbn-flex-fill bbn-b bbn-c"><?= _('AVAILABLE WIDGETS') ?></div>
              <i class="bbn-p nf nf-fa-refresh"
                @click="refreshAvailableWidgets"/>
            </div>
            <div class="bbn-flex-fill">
              <bbn-tree :source="source.availableWidgets"
                        uid="id"
                        ref="availableTree"
                        :map="mapAvailableTree"
                        :filterable="true"
                        :filters="treeFilters"
                        :item-component="$options.components.availableWidget"
                        :selectable="false"
                        v-if="availableTreeVisible"/>
            </div>
          </div>
        </bbn-pane>
      </bbn-splitter>
    </bbn-pane>
    <bbn-pane>
      <div class="bbn-overlay bbn-flex-height">
        <div class="bbn-header bbn-spadded bbn-b bbn-c bbn-no-border-left bbn-no-border-top"><?= _('INFO') ?></div>
        <bbn-form :action="configurator.root + 'actions/configurator/dashboards'"
                  :data="{action: 'update'}"
                  :source="source.info"
                  v-if="configurator"
                  @success="infoSaved">
          <div class="bbn-spadded bbn-grid-fields">
            <label><?= _('Name') ?></label>
            <bbn-input v-model="source.info[configurator.prefCfg.fields.text]"/>
            <label><?= _('Code') ?></label>
            <bbn-input v-model="source.info.code"/>
            <label><?= _('Public') ?></label>
            <bbn-checkbox v-model="source.info[configurator.prefCfg.fields.public]"
                          :value="1"
                          :novalue="0"/>
            <label><?= _('User') ?></label>
            <bbn-dropdown v-model="source.info[configurator.prefCfg.fields.id_user]"
                          :source="configurator.users"
                          :nullable="true"/>
            <label><?= _('Group') ?></label>
            <bbn-dropdown v-model="source.info[configurator.prefCfg.fields.id_group]"
                          :source="configurator.groups"
                          :nullable="true"/>
          </div>
        </bbn-form>
        <div class="bbn-header bbn-spadded bbn-b bbn-c bbn-no-border-left bbn-no-border-top bbn-top-sspace"><?= _('WIDGET CONFIGURATION') ?></div>
        <div class="appui-dashboard-configurator-dashboard-tabs bbn-flex-fill">
          <bbn-router :autoload="true"
                      :nav="true">
            <bbn-container url="widget"
                          :fixed="true"
                          title="<?= _('Widget') ?>"
                          icon="nf nf-fa-th_list">
              <appui-dashboard-configurator-form-widget :source="{
                                                          row: selectedWidget,
                                                          data: {
                                                            idDashboard: source.info[configurator.prefCfg.fields.id],
                                                            idWidget: selectedWidget[configurator.bitCfg.fields.id]
                                                          },
                                                          url: configurator.root + 'actions/configurator/dashboard/widget/update',
                                                          success: widgetSaved
                                                        }"
                                                        class="bbn-overlay"
                                                        v-if="selectedWidget"/>
              <div v-else
                  class="bbn-overlay bbn-middle">
                <div class="bbn-xl bbn-block"><?= _("Select a widget...") ?></div>
              </div>
            </bbn-container>
            <bbn-container url="permissions"
                          :fixed="true"
                          title="<?= _('Permissions') ?>"
                          icon="nf nf-fa-key">
              <div class="bbn-overlay bbn-bordered"
                  v-if="selectedWidget">
                <bbn-panelbar class="bbn-100"
                              :flex="true"
                              :source="panelSource"/>
              </div>
              <div v-else
                  class="bbn-overlay bbn-middle">
                <div class="bbn-xl bbn-block"><?= _("Select a widget...") ?></div>
              </div>
            </bbn-container>
          </bbn-router>
        </div>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>