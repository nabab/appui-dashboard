<div class="bbn-overlay">
  <bbn-splitter orientation="horizontal" :resizable="true">
    <bbn-pane size="30%" :resizable="true">
      <div class="bbn-overlay bbn-middle">
        <h1>Hello!</h1>
      </div>
    </bbn-pane>
    <bbn-pane :resizable="true">
      <div class="bbn-overlay">
        <bbn-form action="options/actions/update" :scrollable="true" :source="source">

          <div class="bbn-grid-fields bbn-padded">
            <div>Texte</div>
            <bbn-input v-model="source.text">
            </bbn-input>

            <div>Code</div>
            <bbn-input v-model="source.code">
            </bbn-input>

            <div>Closable</div>
            <bbn-checkbox v-model="source.closable" :required="false" :novalue="false">
            </bbn-checkbox>

            <div>Observe</div>
            <bbn-checkbox v-model="source.observable" :required="false" :novalue="false">
            </bbn-checkbox>

            <div>Component</div>
            <bbn-input v-model="source.component">
            </bbn-input>

            <div>itemComponent</div>
            <bbn-input v-model="source.itemComponent">
            </bbn-input>

            <!--div>Limit</div>
            <bbn-numeric v-model="source.limit" :required="false">
            </bbn-numeric-->

            <div>Right buttons</div>
            <bbn-json-editor v-model="source.rightButtons"
                             :required="false">
            </bbn-json-editor>

            <div>Left buttons</div>
            <bbn-json-editor v-model="source.leftButtons"
                             :required="false">
            </bbn-json-editor>

            <div>Component's options</div>
            <bbn-json-editor v-model="source.componentOptions"
                             :required="false">
            </bbn-json-editor>

            <div>Alias</div>
            <bbn-input v-model="source.alias">
            </bbn-input>
          </div>
        </bbn-form>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>