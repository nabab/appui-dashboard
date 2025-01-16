<div class="appui-dashboard-configurator-tab-widgets-tree bbn-overlay">
  <bbn-splitter orientation="horizontal">
    <bbn-pane :size="300">
      <div class="bbn-overlay bbn-flex-height bbn-border-right">
        <div class="appui-dashboard-configurator-tab-widgets-tree-header bbn-header bbn-spadding bbn-b bbn-no-border-right bbn-flex-width bbn-vmiddle">
          <div class="bbn-flex-fill bbn-middle"><?= _('WIDGETS') ?></div>
          <div>
            <bbn-button icon="nf nf-fa-plus"
                        label="<?= _('Add widget') ?>"
                        :notext="true"
                        @click="addWidget"/>
            <bbn-button icon="nf nf-md-folder_plus"
                        label="<?= _('Add container') ?>"
                        :notext="true"
                        @click="addContainer"/>
            <bbn-button icon="nf nf-fa-refresh"
                        label="<?= _('Refresh') ?>"
                        :notext="true"
                        @click="getRef('tree').updateData()"/>
          </div>
        </div>
        <div class="bbn-flex-fill">
          <bbn-tree :source="configurator.root + 'data/configurator/widgets/list'"
                    class="bbn-overlay"
                    @select="select"
                    ref="tree"
                    :menu="treeMenu"
                    :draggable="true"
                    @move="treeMove"
                    :map="treeMap"
                    uid="id"/>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane>
      <div class="bbn-overlay bbn-flex-height">
        <div class="appui-dashboard-configurator-tab-widgets-tree-header bbn-header bbn-padding bbn-b bbn-c bbn-no-border-left bbn-upper"
             v-text="!!currentSelected ? (!!currentSelected.id ? (currentSelected.text || _('No text')) : _('New widget')) : ''"/>
        <div class="bbn-flex-fill">
          <appui-dashboard-configurator-form-widget v-if="!!currentSelected && !currentSelected.isContainer"
                                                    :source="{
                                                      row: currentSelected,
                                                      data: {
                                                        action: !!currentSelected.id ? 'update' : 'insert'
                                                      }
                                                    }"
                                                    :extra-fields="true"
                                                    @success="editSuccess"
                                                    @error="editFailure"/>
          <appui-dashboard-configurator-form-container v-else-if="!!currentSelected && !!currentSelected.isContainer"
                                                    :source="{
                                                      row: currentSelected
                                                    }"
                                                    @success="editSuccess"
                                                    @error="editFailure"/>
          <div v-else
               class="bbn-overlay bbn-middle">
            <div class="nf nf-fa-long_arrow_left bbn-xxxl bbn-right-space"></div>
            <div class="bbn-upper bbn-lg"><?= _('Select a widget')?><br><?=_('or create a new one') ?></div>
          </div>
        </div>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>