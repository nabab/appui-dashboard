<bbn-router :scrollable="true"
            :autoload="true"
            :nav="true"
>
  <bbns-container url="dashboards"
                  title="<?=_('Dashboards')?>"
                  :static="true"
                  component="appui-dashboard-configurator-tab-dashboards"
                  icon="nf nf-oct-dashboard"
                  :notext="true"
                  bcolor="yellowgreen"
                  fcolor="white"/>
  <bbns-container url="widgets"
                  title="<?=_('Widgets')?>"
                  :static="true"
                  component="appui-dashboard-configurator-tab-widgets"
                  icon="nf nf-mdi-widgets"
                  :notext="true"
                  bcolor="skyblue"
                  fcolor="white"/>
</bbn-router>