define([],function(){"use strict";var a=function(){this.sandbox.on("husky.datagrid.item.click",function(a){this.sandbox.emit("sulu.translate.package.load",a)},this),this.sandbox.on("sulu.list-toolbar.delete",function(){this.sandbox.emit("husky.datagrid.items.get-selected",function(a){this.sandbox.emit("sulu.translate.packages.delete",a)}.bind(this))},this),this.sandbox.on("sulu.list-toolbar.add",function(){this.sandbox.emit("sulu.translate.package.new")},this)};return{view:!0,layout:{content:{width:"max",leftSpace:!1,rightSpace:!1}},header:function(){return{title:"translate.package.title",noBack:!0,breadcrumb:[{title:"navigation.settings"},{title:"translate.package.title"}]}},templates:["/admin/translate/template/package/list"],initialize:function(){this.render(),a.call(this)},render:function(){this.sandbox.dom.html(this.$el,this.renderTemplate("/admin/translate/template/package/list")),this.sandbox.sulu.initListToolbarAndList.call(this,"packagesFields","/admin/api/packages/fields",{el:"#list-toolbar-container",instanceName:"package",inHeader:!0},{el:this.$find("#package-list"),url:"/admin/api/packages?flat=true",viewOptions:{table:{fullWidth:!0}}})}}});