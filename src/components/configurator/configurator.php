<bbn-router :scrollable="true"
            :autoload="true"
            mode="tabs">
  <bbn-container url="dashboards"
                 label="<?= _('Dashboards') ?>"
                 :fixed="true"
                 component="appui-dashboard-configurator-tab-dashboards"
                 icon="nf nf-oct-dashboard"
                 :notext="true"
                 bcolor="yellowgreen"
                 fcolor="white"/>
  <bbn-container url="widgets"
                 label="<?= _('Widgets') ?>"
                 :fixed="true"
                 icon="nf nf-md-widgets"
                 :notext="true"
                 bcolor="skyblue"
                 fcolor="white">
  	<bbn-router mode="tabs">
      <bbn-container url="list"
                     label="<?= _('List') ?>"
                     :fixed="true"
                     component="appui-dashboard-configurator-tab-widgets-table"
                     icon="nf nf-fa-list"
                     bcolor="skyblue"
                     fcolor="white"/>
      <bbn-container url="tree"
                     label="<?= _('Tree') ?>"
                     :fixed="true"
                     component="appui-dashboard-configurator-tab-widgets-tree"
                     icon="nf nf-md-file_tree"
                     bcolor="skyblue"
                     fcolor="white"/>
    </bbn-router>
  </bbn-container>
</bbn-router>
