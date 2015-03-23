define(function(){"use strict";var a={toolbarSelector:".list-toolbar-container",datagridSelector:".datagrid-container",listViewStorageKey:"collectionEditListView"},b={},c={table:{itemId:"table",name:"table"},thumbnailSmall:{itemId:"small-thumbnails",name:"thumbnail",thViewOptions:{large:!1,selectable:!1}},thumbnailLarge:{itemId:"big-thumbnails",name:"thumbnail",thViewOptions:{large:!0,selectable:!1}}};return{view:!0,header:{noBack:!0,toolbar:{template:"empty"}},layout:{navigation:{collapsed:!0},content:{width:"max"}},templates:["/admin/media/template/collection/files"],initialize:function(){this.options=this.sandbox.util.extend(!0,{},b,this.options);var c="/admin/api/collections";this.sandbox.emit("husky.navigation.select-id","collections-edit",{dataNavigation:{url:c}}),this.listView=this.sandbox.sulu.getUserSetting(a.listViewStorageKey)||"thumbnailSmall",this.bindCustomEvents(),this.render()},bindCustomEvents:function(){this.sandbox.on("sulu.list-toolbar.change.table",function(){this.sandbox.emit("husky.datagrid.view.change","table"),this.sandbox.sulu.saveUserSetting(a.listViewStorageKey,"table")}.bind(this)),this.sandbox.on("sulu.list-toolbar.change.thumbnail-small",function(){this.sandbox.emit("husky.datagrid.view.change","thumbnail",c.thumbnailSmall),this.sandbox.sulu.saveUserSetting(a.listViewStorageKey,"thumbnailSmall")}.bind(this)),this.sandbox.on("sulu.list-toolbar.change.thumbnail-large",function(){this.sandbox.emit("husky.datagrid.view.change","thumbnail",c.thumbnailLarge),this.sandbox.sulu.saveUserSetting(a.listViewStorageKey,"thumbnailLarge")}.bind(this)),this.sandbox.on("husky.datagrid.item.click",function(a,b){this.sandbox.emit("sulu.router.navigate","media/collections/edit:"+b.collection+"/files/edit:"+a);var c="/admin/api/collections/"+b.collection+"?depth=1";this.sandbox.emit("husky.data-navigation.collections.set-url",c)}.bind(this))},render:function(){this.setHeaderInfos(),this.sandbox.dom.html(this.$el,this.renderTemplate("/admin/media/template/collection/files")),this.startDatagrid()},setHeaderInfos:function(){var a=[{title:"navigation.media"},{title:"media.collections.title"}];this.sandbox.emit("sulu.header.set-title","sulu.media.all"),this.sandbox.emit("sulu.header.set-breadcrumb",a)},startDatagrid:function(){this.sandbox.sulu.initListToolbarAndList.call(this,"media","/admin/api/media/fields",{el:this.$find(a.toolbarSelector),instanceName:this.options.instanceName,template:[{id:"change",icon:"th-large",itemsOption:{markable:!0},items:[{id:"small-thumbnails",title:this.sandbox.translate("sulu.list-toolbar.small-thumbnails"),callback:function(){this.sandbox.emit("sulu.list-toolbar.change.thumbnail-small")}.bind(this)},{id:"big-thumbnails",title:this.sandbox.translate("sulu.list-toolbar.big-thumbnails"),callback:function(){this.sandbox.emit("sulu.list-toolbar.change.thumbnail-large")}.bind(this)},{id:"table",title:this.sandbox.translate("sulu.list-toolbar.table"),callback:function(){this.sandbox.emit("sulu.list-toolbar.change.table")}.bind(this)}]}],inHeader:!1},{el:this.$find(a.datagridSelector),url:"/admin/api/media?orderBy=media.changed&orderSort=DESC",view:c[this.listView].name,resultKey:"media",viewOptions:{table:{selectItem:!0,fullWidth:!1,rowClickSelect:!1},thumbnail:c[this.listView].thViewOptions||{}}})}}});