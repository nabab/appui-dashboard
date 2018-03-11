// Javascript Document
(() => {
  return {
    beforeMount(){
      this.source.data.forEach((w,) => {
        let comp = w.component || w.itemComponent;
        if ( comp && !Vue.options.components[comp] ){
          let  c = comp.split('-'),
               prefix = c.shift();
          c = c.join('/');
          bbn.vue.setComponentRule('components/', prefix);
          bbn.vue.addComponent(c);
          bbn.vue.unsetComponentRule();
        }
      });
    },
    data(){
      return {
        widgets: this.source.data
      }
    }
  };
})();