(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    methods: {
      success(d){
        this.$emit('success', d);
      },
      error(d){
        this.$emit('error', d);
      }
    }
  }
})();