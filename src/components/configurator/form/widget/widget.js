(() => {
  return {
    props: {
      source: {
        type: Object
      },
      extraFields: {
        type: Boolean,
        default: false
      }
    },
    data(){
      let plugins = [];
      bbn.fn.iterate(appui.plugins, (v,i) => {
        plugins.push({
          text: i,
          value: v
        });
      });
      return {
        plugins: plugins
      };
    },
    methods: {
      isFunction: bbn.fn.isFunction,
      emitSuccess(d){
        this.$emit('success', d);
      },
      emitError(d){
        this.$emit('error', d);
      }
    }
  }
})();