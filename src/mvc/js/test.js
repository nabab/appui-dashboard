// Javascript Document
(() => {
  return {
    data(){
      return {
        root: appui.plugins['appui-dashboard'] + '/test/',
        widgets: this.source.widgets
      }
    },
    methods: {
      sortWidgets(){
        let dab = this.getRef('dashboard');
        if ( dab ){
          this.post(this.root + '/actions/' + this.source.id + '/order', {
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