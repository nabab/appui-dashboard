<div class="bbn-overlay bbn-flex-height">
  <div class="bbn-w-100 bbn-spadding bbn-c">
    <bbn-dropdown :source="dashboards"
                  v-model="currentDashboard"/>
  </div>
  <div class="bbn-flex-fill">
    <bbn-dashboard :source="widgets"
                   :url="root + 'actions/'"
                   :sortable="true"
                   ref="dashboard"
                   :storage="true"
                   @sort="sortWidgets"
                   :order="source.order"
                   class="bbn-background"/>
  </div>
</div>
