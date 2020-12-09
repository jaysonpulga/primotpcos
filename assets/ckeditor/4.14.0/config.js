/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.removePlugins = 'save,newpage,form,checkbox';	
	config.extraPlugins = 'button,floatpanel,panel,panelbutton,quicktable,eqneditor';
	var lite = config.lite = config.lite || {};
	lite.isTracking = false;    
	lite.userName = getCookie("UserName") ;
	lite.userId = getCookie("UserID");     
	lite.userStyles = {
	"39": 3,
	"43": 1,
	"1": 2
	};
	// lite.tooltipTemplate = "%a by %u";
};

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
