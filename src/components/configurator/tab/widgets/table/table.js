(() => {
  return {
    data(){
      return {
        defaultPlugin: appui.plugins['appui-dashboard']
      }
    },
    methods: {
      hasExpander(row){
        return !!row.data && !!row.data.isContainer ? {
          template: `<component is="appui-dashboard-configurator-tab-widgets-table" :source="source"/>`,
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
            }
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
        if (!!row && !!row.isContainer) {
          this.getPopup().open({
            title: bbn._('Container edition'),
            component: this.$options.components.container,
            source: {
              row: row
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
      appui.register('appui-dashboard-configurator-tab-widgets-table', this);
    },
    beforeDestroy() {
      appui.unregister('appui-dashboard-configurator-tab-widgets-table');
    },
    components: {
      container: {
        template: `
<appui-dashboard-configurator-form-container :source="source"
                                             @success="success"
                                             @error="error"/>
        `,
        props: {
          source: {
            type: Object
          }
        },
        data(){
          return {
            widgetsComp: appui.getRegistered('appui-dashboard-configurator-tab-widgets-table')
          };
        },
        methods: {
          success(d){
            this.widgetsComp.editSuccess(d);
          },
          error(d){
            this.widgetsComp.editFailure(d);
          }
        }
      },
      plugin: {
        template: `
<bbn-dropdown v-model="plugin" :source="source" :disabled="!!form.source.id || !!form.source.id_parent"/>
        `,
        props: ['value'],
        data(){
          let ddSrc = [];
          bbn.fn.iterate(appui.plugins, (v,i) => {
            ddSrc.push({
              text: i,
              value: v
            });
          });
          return {
            plugin: this.value,
            source: ddSrc,
            form: this.closest('bbn-form')
          }
        },
        watch: {
          plugin(newVal){
            this.$emit('input', newVal);
          }
        }
      }
    }
  }
})();