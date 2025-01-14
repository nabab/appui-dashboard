<bbn-table :source="configurator.root + 'data/configurator/widgets/list'"
           :data="{id: source ? source.id : undefined}"
           :pageable="true"
           :server-paging="false"
           :filterable="true"
           editable="popup"
           :toolbar="[{
             text: '<?= _('New widget') ?>',
             action: 'insert',
             icon: 'nf nf-fa-plus'
           }, {
             text: '<?= _('Add container') ?>',
             action: addContainer,
             icon: 'nf nf-mdi-folder_plus'
           }]"
           :expander="hasExpander"
           :scrollable="!source"
           :url="configurator.root + 'actions/configurator/widgets'"
           ref="table"
           @editsuccess="editSuccess"
           @editfailure="editFailure">
  <bbns-column :field="configurator.optCfg.fields.id"
               label="<?= _('ID') ?>"
               :hidden="true"
               :editable="false"/>
  <bbns-column :field="configurator.optCfg.fields.id_parent"
               label="<?= _('ID parent') ?>"
               :hidden="true"
               :editable="false"
               :default="source ? source.id : null"/>
  <bbns-column field="plugin"
               label="<?= _('Plugin') ?>"
               :hidden="true"
               :editable="true"
               :default="defaultPlugin"
               :editor="$options.components.plugin"/>
  <bbns-column :field="configurator.optCfg.fields.text"
               label="<?= _('Name') ?>"
               :options="{
                 required: true
               }"/>
  <bbns-column :field="configurator.optCfg.fields.code"
               label="<?= _('Code') ?>"
               :options="{
                 required: true
               }"/>
  <bbns-column field="closable"
               label="<?= _('Closable') ?>"
               type="boolean"
               :width="70"
               :options="{
                 value: true,
                 novalue: false
               }"
               cls="bbn-c"
               :default="false"
               :render="renderClosable"
               editor="bbn-checkbox"/>
  <bbns-column field="observe"
               label="<?= _('Observe') ?>"
               type="boolean"
               :width="70"
               :options="{
                 value: true,
                 novalue: false
               }"
               cls="bbn-c"
               :default="false"
               :render="renderObserve"
               editor="bbn-checkbox"/>
  <bbns-column field="component"
               label="<?= _('Component') ?>"/>
  <bbns-column field="itemComponent"
               label="<?= _('itemComponent') ?>"/>
  <bbns-column field="limit"
               label="<?= _('Limit') ?>"
               type="number"
               :default="5"/>
  <bbns-column field="rightButtons"
               label="<?= _('Right buttons') ?>"
               type="json"
               default="[]"/>
  <bbns-column field="leftButtons"
               label="<?= _('Left buttons') ?>"
               type="json"
               default="[]"/>
  <bbns-column field="options"
               label="<?= _("Component's options") ?>"
               type="json"
               default="{}"/>
  <bbns-column field="cache"
               label="<?= _('Cache') ?>"
               type="number"/>
  <bbns-column :buttons="[{
                 text: '<?= _('Edit') ?>',
                 action: editRow,
                 icon: 'nf nf-fa-edit',
                 notext: true
               }, {
                 text: '<?= _('Delete') ?>',
                 action: 'delete',
                 icon: 'nf nf-fa-trash',
                 notext: true
               }]"
               :width="100"
               cls="bbn-c"/>
</bbn-table>