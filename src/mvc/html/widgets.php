<div class="bbn-overlay">
  
  <bbn-table :source="source.widgets"
             :editor="$options.components['widgets-form']"
             ref="table" 
             :editable="true"
             :toolbar="getToolbar"
             :data="{id_parent:source.list.id}"
  >
    <bbns-column field="num"
                label="<?= _('Num') ?>" 
    >
    </bbns-column>

    <bbns-column field="text"
                label="<?= _('Text') ?>" 
    >
    </bbns-column>

    <bbns-column field="code"
                label="<?= _('Code') ?>" 
    >
    </bbns-column>

    <bbns-column field="closable"
                label="<?= _('Closable') ?>" 
    >
    </bbns-column>

    <bbns-column field="observe"
                label="<?= _('Observe') ?>" 
    >
    </bbns-column>

    <bbns-column field="component"
                label="<?= _('Component') ?>" 
    >
    </bbns-column>

    <bbns-column field="itemComponent"
                label="<?= _('itemComponent') ?>" 
    >
    </bbns-column>

    <bbns-column field="alias"
                 :render="renderAlias"              
                 label="<?= _('itemComponent') ?>" 
    >
    </bbns-column>
    <bbns-column :width="180"
                 flabel="<?= _('Actions') ?>"
                 :editable="false"
                 :buttons="renderButtons"
                 cls="bbn-c"
    ></bbns-column>

</bbn-table>
</div>
<script type="text/x-template" id="widgets-form">
  <bbn-form :action="'dashboard/actions/widgets/' + (source.row.id ? 'update' : 'insert')"
            class="bbn-overlay appui-option-form"
            :source="source.row"
            @success="success"
            :data="source.data"
            
  >
    <div class="bbn-grid-fields bbn-padding">
      
      <div><?= _('Text') ?></div>
      <bbn-input v-model="source.row.text"></bbn-input>
      
      <div><?= _('Code') ?></div>
      <bbn-input v-model="source.row.code"></bbn-input>
      
      <div><?= _('Closable') ?></div>
      <bbn-checkbox v-model="source.row.closable" :value="1"></bbn-checkbox>

      <div><?= _('Observe') ?></div>
      <bbn-checkbox v-model="source.row.observe" :value="1"></bbn-checkbox>

      <div><?= _('Component') ?></div>
      <bbn-input v-model="source.row.component"></bbn-input>  
      
      <div><?= _('itemComponent') ?></div>
      <bbn-input v-model="source.row.itemComponent"></bbn-input>


      <div><?= _('Limit') ?></div>
      <bbn-numeric v-model="source.row.limit"></bbn-numeric>

      <div><?= _('Right buttons') ?></div>
      <bbn-json-editor v-model="source.row.buttonsRight" mode="tree"></bbn-json-editor>

      <div><?= _('Left buttons') ?></div>
      <bbn-json-editor v-model="source.row.buttonsLeft" mode="tree"></bbn-json-editor>

      <div><?= _('Component\'s options') ?></div>
      <bbn-json-editor v-model="source.row.componentOptions" mode="tree"></bbn-json-editor>
      

      <div><?= _('Alias') ?></div>
      <bbn-input v-model="source.row.alias.text"></bbn-input>

      
    </div>
  </bbn-form>

</script>