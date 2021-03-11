(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    methods: {
      isFunction: bbn.fn.isFunction
    }
  }
})();