// Javascript Document
(() => {
  return {
    data(){
      return {
        widgets: this.source.data
      }
    },
    methods: {
      sortWidgets(){
        let dab = this.getRef('dashboard');
        if ( dab ){
          this.post(this.source.root + 'actions/order', {
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