// Javascript Document
(() => {
  return {
    methods: {
      getToolbar(){
        let res = [];
        res.push({
          text: bbn._('Add'),
          icon: 'fas fa-plus',
          command: this.insert
        });
        return res
      },
      insert() {
        this.$refs.table.insert({}, {
          title: bbn._('New widget'),
          height: '90%',
          width: 800
        });
      },
      renderAlias(row){
        if (row.alias){
          return '<a>'+ row.alias.text + '</a>' + ' (' + row.alias.code + ')'
        }
      },
      renderButtons(row) {
        let res = [];
        //if (this.source.cfg.write) {
          res.push({
            text: bbn._('Edit'),
            icon: 'fas fa-edit',
            command: this.edit,
            notext: true
          });
          res.push({
            text: bbn._('Copy'),
            icon: 'fas fa-copy',
            command: this.duplicate,
            notext: true
          });
          res.push({
            text: bbn._('Delete'),
            icon: 'fas fa-trash',
            command: this.remove,
            notext: true
          });
        //}
        /*if (this.source.cfg.allow_children || this.source.cfg.categories) {
          res.push({
            text: bbn._('List'),
            icon: 'fas fa-list',
            url: this.source.root + 'list/' + row.id,
            notext: true
          });
        }*/
        bbn.fn.log(res)
        return res;
      },
      insert() {
        this.$refs.table.insert({}, {
          title: bbn._('New option'),
          height: '90%',
          width: 800
        });
      },
      edit(row, col, idx) {
        this.$refs.table.edit(row, {
          title: bbn._('Updating option') + ' "' + row.text + '"',
          height: '90%',
          width: 800
        }, idx);
      },
      duplicate(row) {
        let newRow = $.extend({}, row, {
          id: '',
          code: null
        });
        if (this.source.cfg.sortable) {
          newRow.num = this.source.options.length + 1;
        }
        if (row.num_children) {
          appui.confirm(bbn._("Do you also want to duplicate children options?"), () => {
            newRow.source_children = row.id;
            this.openDuplicateForm(newRow);
          }, () => {
            newRow.num_children = 0;
            this.openDuplicateForm(newRow);
          });
        } else {
          newRow.num_children = 0;
          this.openDuplicateForm(newRow);
        }
      },
    },
    components: {
      'widgets-form':{
        name: 'widgets-form',
        template: '#widgets-form',
        props: ['source'],
        data(){
          return {
           
          }
        },
        methods:{
          success(d){
            if ( d.success ){
              appui.success(this.source.row.id ? bbn._('Widget successfully updated') : bbn._('Widget successfully inserted'));
            }
          },
        }
      }
    }
  }
})();