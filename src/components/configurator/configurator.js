(() => {
  let mixins = [{
    data(){
      return {
        _configurator: null
      }
    },
    computed:{
      configurator(){
        return this._configurator;
      },
    },
    methods: bbn.fn.extend({
      find: bbn.vue.find,
      findAll: bbn.vue.findAll,
      getRow: bbn.fn.getRow,
      getField: bbn.fn.getField
    }, appui.app.$options.methods),
    beforeMount(){
      this._configurator = this.closest('appui-dashboard-configurator');
    }
  }];
  bbn.vue.addPrefix('appui-dashboard-configurator-', (tag, resolve, reject) => {
    return bbn.vue.queueComponent(
      tag,
      appui.plugins['appui-dashboard'] + '/components/configurator/' + bbn.fn.replaceAll('-', '/', tag).substr('appui-dashboard-configurator-'.length),
      mixins,
      resolve,
      reject
    );
  });

  return {
    props: ['source'],
    data(){
      let d = JSON.parse(JSON.stringify(this.$options.propsData.source));
      d.optCfg = {
        table: this.source.optCfg.table,
        fields: this.source.optCfg.arch.options
      };
      d.prefCfg = {
        table: this.source.prefCfg.table,
        fields: this.source.prefCfg.arch.user_options
      };
      d.bitCfg = {
        table: this.source.prefCfg.tables.user_options_bits,
        fields: this.source.prefCfg.arch.user_options_bits
      };
      return d;
    }
  };
})();