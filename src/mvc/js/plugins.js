// Javascript Document
(() => {
  return {
    props: ['source'],
    created(){
      bbn.fn.log("CREATED", this.source);
    },
    computed: {
      data(){
        return this.source.data.map((a) => {
          a.itemComponent = this.$options.components.link;
          return a;
        });
      }
    },
    components: {
      link: {
        props: ['source'],
        template: `<a :href="source.link"
											v-text="source.text + '  (' + source.n_menu +')'"
											:class="source.id_option ? 'bbn-blue' : 'bbn-red'"
										></a>` 
      }
    }
  }
})();