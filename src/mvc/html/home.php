<bbn-dashboard :source="widgets"
               url="<?=APPUI_DASHBOARD_ROOT?>actions/"
               :sortable="true"
               ref="dashboard"
               :storage="true"
               @sort="sortWidgets"
               
               class="bbn-background"
></bbn-dashboard>