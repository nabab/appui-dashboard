(() => {
  return {
    data(){
      return {
        compName: bbn.fn.randomString()
      }
    },
    methods: {
      hasExpander(row){
        let props = Object.keys(row.data);
        return !props.includes('component') && !props.includes('itemComponent') ? {
          template: `<component is="appui-dashboard-configurator-tab-widgets" :source="source"/>`,
          props: ['source']
        } : false
      },
      addContainer(){
        this.getPopup().open({
          title: bbn._('New container'),
          component: this.$options.components.container,
          source: {
            row: {
              [this.configurator.optCfg.fields.id]: '',
              [this.configurator.optCfg.fields.id_parent]: this.source ? this.source.id : '',
              [this.configurator.optCfg.fields.text]: '',
              [this.configurator.optCfg.fields.code]: ''
            },
            widgetsComp: this.compName
          }
        })
      },
      renderClosable(row){
        return row.closable !== undefined ? `<i class="nf nf-fa-${row.closable ? 'check' : 'close'}"></i>` : '';
      },
      renderObserve(row){
        return row.observe !== undefined ? `<i class="nf nf-fa-${row.observe ? 'check' : 'close'}"></i>` : '';
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
      editRow(row, col, idx){
        let props = Object.keys(row);
        if (!props.includes('component')) {
          this.getPopup().open({
            title: bbn._('Container edition'),
            component: this.$options.components.container,
            source: {
              row: row,
              widgetsComp: this.compName
            }
          });
        }
        else {
          this.getRef('table').edit(row, {
            title: bbn._('Widget edition')
          }, idx);
        }
      }
    },
    created(){
      appui.register('appui-dashboard-configurator-tab-widgets-' + this.compName, this);
    },
    beforeDestroy() {
      appui.unregister('appui-dashboard-configurator-tab-widgets-' + this.compName);
    },
    components: {
      container: {
        template: `
<bbn-form :action="widgetsComp.configurator.root + 'actions/configurator/widgets'"
          :source="source.row"
          :data="{
            action: source.row[widgetsComp.configurator.optCfg.fields.id] ? 'update' : 'insert',
            isContainer: true
          }"
          @success="success"
>
  <div class="bbn-spadded bbn-grid-fields">
    <label>` + bbn._('Text') + `</label>
    <bbn-input v-model="source.row[widgetsComp.configurator.optCfg.fields.text]" :required="true"/>
    <label>` + bbn._('Code') + `</label>
    <bbn-input v-model="source.row[widgetsComp.configurator.optCfg.fields.code]"/>
  </div>
</bbn-form>
        `,
        props: {
          source: {
            type: Object
          }
        },
        data(){
          return {
            widgetsComp: appui.getRegistered('appui-dashboard-configurator-tab-widgets-' + this.source.widgetsComp)
          }
        },
        methods: {
          success(d){
            if (d.success) {
              this.widgetsComp.getRef('table').updateData();
              appui.success();
            }
            else {
              appui.error();
            }
          }
        }
      }
    }
  }
})();