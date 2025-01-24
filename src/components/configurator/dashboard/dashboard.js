(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: {
      source: {
        type: Object
      }
    },
    data(){
      return {
        selectedWidget: false,
        selectedPerms: false,
        currentSection: '',
        currentAvailableWidgets: this.source.availableWidgets,
        availableTreeVisible: true
      }
    },
    computed: {
      treeFilters(){
        let filters = [];
        if (this.configurator) {
          bbn.fn.each(this.source.widgets, w => {
            filters.push({
              field: this.configurator.optCfg.fields.id,
              operator: '!=',
              value: w[this.configurator.bitCfg.fields.id_option]
            });
          });
        }
        return {
          logic: 'AND',
          conditions: filters
        };
      },
      permsUsers(){
        return this.configurator ? bbn.fn.map(bbn.fn.clone(this.configurator.users), u => {
          return {
            id: u.value,
            username: u.text
          }
        }) : [];
      },
      permsGroups(){
        return this.configurator ? bbn.fn.map(bbn.fn.clone(this.configurator.groups), g => {
          return {
            id: g.value,
            group: g.text
          }
        }) : [];
      },
      panelSource(){
        return this.configurator && this.selectedPerms ? [{
          header: '<span class="bbn-lg bbn-b">' + bbn._("Groups") + '</span>',
          component: 'appui-option-permissions-groups',
          componentOptions: {
            users: this.permsUsers,
            groups: this.permsGroups,
            source: this.selectedPerms,
            url: `${appui.plugins['appui-option']}/permissions/actions/`
          }
        }, {
          header: '<span class="bbn-lg bbn-b">' + bbn._("Users") + '</span>',
          component: 'appui-option-permissions-users',
          componentOptions: {
            users: this.permsUsers,
            groups: this.permsGroups,
            source: this.selectedPerms,
            url: `${appui.plugins['appui-option']}/permissions/actions/`
          }
        }, {
          header: '<span class="bbn-lg bbn-b">' + bbn._("Configuration") + '</span>',
          component: 'appui-option-permissions-configuration',
          componentOptions: {
            source: this.selectedPerms,
            url: `${appui.plugins['appui-option']}/permissions/actions/`
          }
        }] : []
      }
    },
    methods: {
      mapTree(d){
        return {
          id: d[this.configurator.bitCfg.fields.id],
          text: d[this.configurator.bitCfg.fields.text],
          num: d[this.configurator.optCfg.fields.num],
          filterable: true,
          numChildren: 0,
          data: d
        }
      },
      mapAvailableTree(d){
        return {
          id: d[this.configurator.optCfg.fields.id],
          text: d[this.configurator.optCfg.fields.text],
          num: d[this.configurator.optCfg.fields.num],
          icon: d.icon || (d.num_children ? 'nf nf-fa-folder' : 'nf nf-md-square'),
          filterable: true,
          numChildren: d.num_children,
          data: d
        }
      },
      selectWidget(w){
        this.selectedWidget = w.data;
        this.selectedPerms = false;
        this.post(`${this.configurator.root}data/configurator/widgets/permissions`, {id: w.data[this.configurator.bitCfg.fields.id_option]}, d => {
          if (d.data) {
            this.selectedPerms = d.data;
          }
        });
      },
      infoSaved(d){
        if (d.success) {
          appui.success();
        }
        else {
          appui.error();
        }
      },
      widgetSaved(d){
        if (d.success && (bbn.fn.isArray(d.widgets))) {
          let id = this.selectedWidget[this.configurator.bitCfg.fields.id];
          this.selectedWidget = false;
          this.selectedPerms = false;
          this.source.widgets.splice(0, this.source.widgets.length, ...d.widgets);
          let tree = this.getRef('tree');
          tree.$once('dataloaded', () => {
            setTimeout(() => {
              tree.getNodeByUid(id).addToSelected();
            }, 200)
          });
          this.$nextTick(() => {
            tree.updateData();
          });
          appui.success();
        }
        else {
          appui.error();
        }
      },
      refreshAvailableWidgets(){
        this.post(`${this.configurator.root}data/configurator/widgets/tree`, d => {
          if (d.data) {
            this.currentAvailableWidgets.splice(0, this.currentAvailableWidgets.length, ...d.data);
            this.$nextTick(() => {
              this.getRef('availableTree').reload();
            })
          }
        })
      },
      changeNum(data, num){
        this.post(this.configurator.root + 'actions/configurator/dashboard/widget/move', {
          idDashboard: this.source.info[this.configurator.prefCfg.fields.id],
          idWidget: data[this.configurator.bitCfg.fields.id],
          num: num
        }, d => {
          if (d.success) {
            appui.success()
          }
          else {
            appui.error()
          }
        })
        bbn.fn.warning('ORDER', data, num)
      }
    },
    components: {
      availableWidget: {
        template: `
<span>
  <span class="bbn-tree-node-block-icon">
    <span v-if="!source.icon"/>
    <img v-else-if="source.icon && (source.icon.indexOf('data:image') === 0)"
          :src="source.icon">
    <i v-else :class="source.icon"/>
  </span>
  <span class="bbn-tree-node-block-title">
    <span v-html="source.text"/>
  </span>
  <i v-if="!source.numChildren && (!!source.data.component || !!source.data.itemComponent)"
     class="nf nf-md-plus_circle_outline bbn-p bbn-left-xsmargin"
     @click="addWidget"/>
</span>
        `,
        mixins: [bbn.cp.mixins.basic],
        props: {
          source: {
            type: Object
          }
        },
        data(){
          return {
            dash: this.closest('appui-dashboard-configurator-dashboard')
          }
        },
        methods: {
          addWidget(){
            this.post(`${this.dash.configurator.root}actions/configurator/dashboard/widget/add`, {
              idDashboard: this.dash.source.info[this.dash.configurator.prefCfg.fields.id],
              idWidget: this.source.data[this.dash.configurator.optCfg.fields.id]
            }, d => {
              if (d.success && d.id && (bbn.fn.isArray(d.widgets))) {
                this.dash.selectedWidget = false;
                this.dash.selectedPerms = false;
                this.dash.source.widgets.splice(0, this.dash.source.widgets.length, ...d.widgets);
                let tree = this.dash.getRef('tree');
                tree.$once('dataloaded', () => {
                  setTimeout(() => {
                    tree.getNodeByUid(d.id).addToSelected();
                  }, 200)
                });
                this.$nextTick(() => {
                  tree.updateData();
                  this.dash.availableTreeVisible = false;
                  this.$nextTick(() => {
                    this.dash.availableTreeVisible = true;
                  })
                });
                appui.success();
              }
              else {
                appui.error();
              }
            })
          }
        }
      },
      widget: {
        template: `
<span>
  <span class="bbn-tree-node-block-icon">
    <span v-if="!source.data.icon"/>
    <img v-else-if="source.data.icon && (source.data.icon.indexOf('data:image') === 0)"
          :src="source.data.icon">
    <i v-else :class="source.data.icon"/>
  </span>
  <span class="bbn-tree-node-block-title">
    <span v-html="source.text"/>
  </span>
  <i class="nf nf-md-minus_circle_outline bbn-p bbn-left-xsmargin"
     @click.prevent.stop="removeWidget"/>
</span>
        `,
        mixins: [bbn.cp.mixins.basic],
        props: {
          source: {
            type: Object
          }
        },
        data(){
          return {
            dash: this.closest('appui-dashboard-configurator-dashboard')
          }
        },
        methods: {
          removeWidget(){
            this.confirm(bbn._('Are you sure you want to remove this widget?'), () => {
              let idWidget = this.source.data[this.dash.configurator.bitCfg.fields.id];
              this.post(`${this.dash.configurator.root}actions/configurator/dashboard/widget/remove`, {
                idDashboard: this.dash.source.info[this.dash.configurator.prefCfg.fields.id],
                idWidget: idWidget
              }, d => {
                if (d.success) {
                  if (this.dash.selectWidget && (this.dash.selectedWidget[this.dash.configurator.bitCfg.fields.id] === idWidget)) {
                    this.dash.selectedWidget = false;
                    this.dash.selectedPerms = false;
                  }
                  let idx = bbn.fn.search(this.dash.source.widgets, this.dash.configurator.bitCfg.fields.id, idWidget);
                  if (idx > -1) {
                    this.dash.source.widgets.splice(idx, 1);
                    this.dash.getRef('tree').updateData();
                  }
                  this.$nextTick(() => {
                    this.dash.availableTreeVisible = false;
                    this.$nextTick(() => {
                      this.dash.availableTreeVisible = true;
                    })
                  });
                  appui.success();
                }
                else {
                  appui.error();
                }
              })
            })
          }
        }
      }
    }
  }
})();