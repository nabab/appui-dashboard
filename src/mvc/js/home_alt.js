// Javascript Document
(() => {
  return {
    data(){
      return {
        dashboards: this.source.dashboards,
        root: appui.plugins['appui-dashboard'] + '/',
        widgets: this.source.widgets,
        currentDashboard: null
      }
    },
    methods: {
      sortWidgets(){
        let dab = this.getRef('dashboard');
        if ( dab ){
          this.post(this.root + '/actions/order', {
            order: dab.currentOrder
          }, d => {
            if ( d.success ){
              appui.success(bbn._('Sorting saved'));
            }
            else if (d.deleted ){
              appui.success(bbn._('Sorting reset successfull'));
            }
            else{
              appui.error();
            }
          })
        }
      }
    }
  };
})();