(() => {
  return {
    props: ['source'],
    data(){
      return {
        optionsRoot: appui.plugins['appui-option']
      };
    }
  };
})();