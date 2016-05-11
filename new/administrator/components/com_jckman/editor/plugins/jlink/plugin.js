/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.plugins.add( 'jlink',
{
	
	lang : ['en'],
	
	init : function( editor )
	{
		// Add the link and unlink buttons.
		editor.addCommand( 'jlink', new CKEDITOR.dialogCommand( 'jlink' ) );
		editor.ui.addButton( 'JLink',
			{
				label : editor.lang.jlink.toolbar,//editor.lang.jdoclink.toolbar,
				command : 'jlink',
				icon : this.path + 'images/jlink.gif'
			} );
	
		CKEDITOR.dialog.add( 'jlink', this.path + 'dialogs/jlink.js' );

		
		// If the "menu" plugin is loaded, register the menu items.
		if ( editor.addMenuItems )
		{
			editor.addMenuItems(
				{
					jlink :
					{
						label : editor.lang.jlink.menu,
						command : 'jlink',
						icon: this.path + 'images/jlink.gif',
						group : 'link',
						order: -1
					}
				});
		}

		// If the "contextmenu" plugin is loaded, register the listeners.
		if ( editor.contextMenu )
		{
			editor.contextMenu.addListener( function( element, selection )
				{
					if ( !element )
						return null;
						
						
					if ( !( element = element.getAscendant( 'a', true ) ) )
							return null;

					var islink = (element.getAttribute( 'href' ) );
						
                           
					return  islink ? { jlink : CKEDITOR.TRISTATE_OFF} : null;
				});
		}
			
	},
      
	requires : [ 'dialogui' ]
} );


