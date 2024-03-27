<bbn-router :scrollable="true"
            :autoload="true"
            :nav="true">
  <bbn-container url="dashboards"
                 title="<?= _('Dashboards') ?>"
                 :fixed="true"
                 component="appui-dashboard-configurator-tab-dashboards"
                 icon="nf nf-oct-dashboard"
                 :notext="true"
                 bcolor="yellowgreen"
                 fcolor="white"/>
  <bbn-container url="widgets"
                 title="<?= _('Widgets') ?>"
                 :fixed="true"
                 icon="nf nf-mdi-widgets"
                 :notext="true"
                 bcolor="skyblue"
                 fcolor="white">
  	<bbn-router :nav="true">
      <bbn-container url="list"
                     title="<?= _('List') ?>"
                     :fixed="true"
                     component="appui-dashboard-configurator-tab-widgets-table"
                     icon="nf nf-fa-list"
                     bcolor="skyblue"
                     fcolor="white"/>
      <bbn-container url="tree"
                     title="<?= _('Tree') ?>"
                     :fixed="true"
                     component="appui-dashboard-configurator-tab-widgets-tree"
                     icon="nf nf-mdi-file_tree"
                     bcolor="skyblue"
                     fcolor="white"/>
    </bbn-router>
  </bbn-container>
</bbn-router>
