(() => {
  return {
    methods: {
      renderText(row){
        return `<span${row[this.configurator.prefCfg.fields.id_alias] ? ' class="bbn-i"' : ''}>${row[this.configurator.prefCfg.fields.text]}</span$>`
      },
      renderCode(row){
        return `<span${row[this.configurator.prefCfg.fields.id_alias] ? ' class="bbn-i"' : ''}>${row.code}</span$>`
      },
      configure(row){
        bbn.fn.link(this.configurator.root + 'page/dash/' + row[this.configurator.prefCfg.fields.id]);
      },
      editSuccess(d){
        if (d.success) {
          this.getRef('table').updateData();
          appui.success();
        }
      },
      editFailure(d){
        appui.error(d.error || '');
      },
      open(row){
        bbn.fn.link(this.configurator.root + 'test/' + row.id);
      }
    }
  }
})();