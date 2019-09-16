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
        bbn.fn.log("sortWid", dab, dab.currentOrder);
        if ( dab && dab.currentOrder && dab.currentOrder.length ){
          this.post(this.source.root + 'actions/order', {
            order: dab.currentOrder
          }, d => {
            bbn.fn.log(d);
            if ( d.success ){
              appui.success();
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