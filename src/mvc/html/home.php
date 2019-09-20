<bbn-dashboard :source="widgets"
               :url="root + 'actions/'"
               :sortable="true"
               ref="dashboard"
               :storage="true"
               @sort="sortWidgets"
               :order="source.order"
               class="bbn-background"
></bbn-dashboard>