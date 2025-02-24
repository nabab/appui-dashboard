<bbn-table :source="configurator.root + 'data/configurator/dashboards'"
           :pageable="true"
           :filterable="true"
           editable="inline"
           :toolbar="[{
             text: '<?= _('New') ?>',
             action: 'insert',
             icon: 'nf nf-fa-plus'
           }]"
           ref="table"
           :url="configurator.root + 'actions/configurator/dashboard/action'"
           @editsuccess="editSuccess"
           @editfailure="editFailure"
           :auto-reset="true">
  <bbns-column :field="configurator.prefCfg.fields.id"
               label="<?= _('ID') ?>"
               :invisible="true"/>
  <bbns-column :field="configurator.prefCfg.fields.text"
               label="<?= _('Name') ?>"
               :render="renderText"/>
  <bbns-column field="code"
               label="<?= _('Code') ?>"
               :render="renderCode"/>
  <bbns-column :field="configurator.prefCfg.fields.public"
               label="<?= _('Public') ?>"
               type="boolean"
               :width="60"
               cls="bbn-c"/>
  <bbns-column :field="configurator.prefCfg.fields.id_user"
               label="<?= _('User') ?>"
               :source="configurator.users"
               :options="{
                 nullable: true
               }"/>
  <bbns-column :field="configurator.prefCfg.fields.id_group"
               label="<?= _('Group') ?>"
               :source="configurator.groups"
               :options="{
                 nullable: true
               }"/>
  <bbns-column :buttons="[{
                 text: '<?= _('See') ?>',
                 action: open,
                 icon: 'nf nf-fa-eye',
                 notext: true
               }, {
                 text: '<?= _('Configure') ?>',
                 action: configure,
                 icon: 'nf nf-oct-settings',
                 notext: true
               }, {
                 text: '<?= _('Edit') ?>',
                 action: 'edit',
                 icon: 'nf nf-fa-edit',
                 notext: true
               }, {
                 text: '<?= _('Delete') ?>',
                 action: 'delete',
                 icon: 'nf nf-fa-trash',
                 notext: true
               }]"
               :width="150"
               cls="bbn-c"/>
</bbn-table>