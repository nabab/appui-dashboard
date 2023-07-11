(() => {
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
    },
    created() {
      let config = this;
      let mixins = [{
        mixins: [bbn.cp.mixins.basic],
        data(){
          return {
            _configurator: config
          }
        },
        computed:{
          configurator(){
            return this._configurator;
          },
        },
        methods: {
          getRow: bbn.fn.getRow,
          getField: bbn.fn.getField
        }
      }];
      bbn.cp.addPrefix('appui-dashboard-configurator-', null, mixins);
    }
  };
})();