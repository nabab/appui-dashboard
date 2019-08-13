( () => {
  return {
    methods: {
      edit(row, col, idx){
        this.$refs.table.edit(row, {
          title: bbn._("Configuration des documents"),
          height: 600,
          width: 800
        }, idx);
      },
      insert(){
        this.$refs.table.insert(null, {
          title: bbn._("Configuration des documents"),
          height: 600,
          width: 800
        });
      },
      renderSurveillance(row){
        if ( row.surveillance ){
          return bbn._('Oui');
        }
        else {
          return bbn._('Non');
        }
      },
      renderPublic(row){
        if ( row.public ){
          return bbn._('Oui');
        }
        else {
          return bbn._('Non');
        }
      },
      renderExtensions(row){
        if ( row.id_alias ){
          return bbn.fn.get_field( bbn.opt.extensions, 'value', row.id_alias, 'text');
        }
      }
    },
    components: {
      'options-documents-form': {
        template: '#options-documents-form',
        props: ['source', 'data'],
        data(){
          return  {
            extensionsSource: bbn.opt.extensions
          }
        },
        methods: {
          success(d){
            if ( d.success ){
              if ( !this.source.row.id ){
                this.closest('bbn-container').getComponent().source.options.push(d.row);
              }
              appui.success(this.source.row.id ? bbn._("Document type correctly updated") : bbn._("Document type correctly inserted"));
            }
            else{
              !this.source.row.id ? appui.error(bbn._("Something went wrong while inserting the new document type")) : appui.error(bbn._("Something went wrong while updatind the document type"));
            }
          }

        }



      }
    }
  }
})();
