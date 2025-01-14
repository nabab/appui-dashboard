(() => {
  return {
    data(){
      return {
        defaultPlugin: appui.plugins['appui-dashboard'],
        currentSelected: false,
        currentNode: false,
        currentCopy: false
      }
    },
    methods: {
      treeMap(item){
        return {
          text: item[this.configurator.optCfg.fields.text],
          numChildren: item.num_children,
          icon: item.isContainer ? 'nf nf-fa-folder' : 'nf nf-mdi-widgets',
          data: item
        };
      },
      treeMenu(item){
        this.currentNode = item;
        let res = [];
        if (!!item.data.isContainer) {
          res.push({
            icon: 'nf nf-fa-plus',
            text: bbn._('Add widget'),
            action: this.addWidget
          }, {
            icon: 'nf nf-mdi-folder_plus',
            text: bbn._('Add container'),
            action: this.addContainer
          });
        }
        if (!item.data.isContainer) {
          res.push({
            icon: 'nf nf-fa-copy',
            text: bbn._('Copy'),
            action: this.treeCopy
          }, {
            icon: 'nf nf-mdi-content_duplicate',
            text: bbn._('Duplicate'),
            action: this.treeDuplicate
          });
        }
        if (!!this.currentCopy
          && !!item.data.isContainer
          && (this.currentCopy.data[this.configurator.optCfg.fields.id_parent] !== item.data[this.configurator.optCfg.fields.id])
        ) {
          res.push({
            icon: 'nf nf-mdi-content_paste',
            text: bbn._('Paste'),
            action: this.treePaste
          });
        }
        res.push({
          icon: 'nf nf-fa-trash',
          text: bbn._('Delete'),
          action: this.treeDelete
        });
        return res;
      },
      treeMove(item, dest, ev){
        if (!dest.data.isContainer
          || (item.data[this.configurator.optCfg.fields.id] === dest.data[this.configurator.optCfg.fields.id])
        ) {
          ev.preventDefault();
        }
        this.post(this.configurator.root + 'actions/configurator/widgets', {
          action: 'move',
          [this.configurator.optCfg.fields.id]: item.data[this.configurator.optCfg.fields.id],
          [this.configurator.optCfg.fields.id_parent]: dest.data[this.configurator.optCfg.fields.id]
        }, d => {
          if (d.success) {
            if (this.currentNode) {
              this.currentNode = false;
            }
            if (this.currentSelected
              && (this.currentSelected[this.configurator.optCfg.fields.id] === item.data[this.configurator.optCfg.fields.id])
            ){
              this.currentSelected = false;
              this.getRef('tree').unselect();
            }
            if (dest.getRef('tree')) {
              dest.getRef('tree').updateData();
            }
            appui.success();
          }
          else {
            this.editFailure(d);
          }
        })
      },
      treeCopy(item){
        this.currentNode = item;
        this.currentCopy = item;
      },
      treeDuplicate(item){
        this.currentNode = item;
        let obj = bbn.fn.extend(true, this.getDefaultProperties(), item.data);
        obj[this.configurator.optCfg.fields.id] = '';
        obj[this.configurator.optCfg.fields.text] += ' (' + bbn._('Copy') + ')';
        obj[this.configurator.optCfg.fields.code] += '_copy';
        this.currentSelected = false;
        this.getRef('tree').unselect();
        this.$nextTick(() => {
          this.currentSelected = obj;
        });
      },
      treePaste(item){
        this.currentNode = item;
        if (!!this.currentCopy
          && (this.currentCopy.data[this.configurator.optCfg.fields.id_parent] !== item.data[this.configurator.optCfg.fields.id])
        ) {
          let obj = bbn.fn.extend(true, this.getDefaultProperties(), this.currentCopy.data);
          obj[this.configurator.optCfg.fields.id] = '';
          obj[this.configurator.optCfg.fields.id_parent] = item.data[this.configurator.optCfg.fields.id];
          obj.action = 'insert';
          this.post(this.configurator.root + 'actions/configurator/widgets', obj, d => {
            this.editSuccess(d);
          });
        }
      },
      treeDelete(item){
        this.confirm(bbn._('Are you sure you want to delete this item?'), () => {
          this.post(this.configurator.root + 'actions/configurator/widgets', {
            action: 'delete',
            [this.configurator.optCfg.fields.id]: item.data[this.configurator.optCfg.fields.id]
          }, d => {
            if (d.success) {
              if (this.currentNode) {
                this.currentNode.parent.updateData();
                this.currentNode = false;
                this.currentSelected = false;
                this.getRef('tree').unselect();
              }
              else {
                this.getRef('tree').updateData();
                this.currentSelected = false;
                this.getRef('tree').unselect();
              }
              appui.success();
            }
            else {
              this.editFailure(d);
            }
          });
        });
      },
      select(item){
        this.currentNode = item;
        this.currentSelected = false;
        this.$nextTick(() => {
          this.currentSelected = item.data;
        });
      },
      addContainer(item){
        this.getPopup({
          label: bbn._('New container'),
          component: this.$options.components.container,
          source: {
            row: {
              [this.configurator.optCfg.fields.id]: '',
              [this.configurator.optCfg.fields.id_parent]: !!item && !!item.data && !!item.data.id ? item.data.id : '',
              [this.configurator.optCfg.fields.text]: '',
              [this.configurator.optCfg.fields.code]: ''
            }
          }
        });
      },
      addWidget(item){
        this.getRef('tree').unselect();
        this.currentSelected = false;
        this.$nextTick(() => {
          this.currentSelected = this.getDefaultProperties(!!item && !!item.id_parent ? item.id_parent : '');
        });
      },
      editSuccess(d){
        if (d.success) {
          if (this.currentNode) {
            this.currentNode.parent.updateData();
            this.currentNode = false;
            this.currentSelected = false;
          }
          else {
            this.getRef('tree').updateData();
            this.currentSelected = false;
          }
          appui.success();
        }
        else {
          this.editFailure(d);
        }
      },
      editFailure(d){
        appui.error(d.error || '');
      },
      getDefaultProperties(idParent = ''){
        return {
          id: '',
          id_parent: idParent,
          plugin: appui.plugins['appui-dashboard'],
          text: '',
          code: '',
          closable: false,
          observe: false,
          component: '',
          itemComponent: '',
          limit: 5,
          rightButton: [],
          leftButton: [],
          options: {},
          cache: null
        };
      }
    },
    created(){
      appui.register('appui-dashboard-configurator-tab-widgets-tree', this);
    },
    beforeDestroy() {
      appui.unregister('appui-dashboard-configurator-tab-widgets-treer');
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
            widgetsComp: appui.getRegistered('appui-dashboard-configurator-tab-widgets-tree')
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
      }
    }
  }
})();