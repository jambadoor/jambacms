
tinyeditor = new TINY.editor.edit('editor',{
	id:'input',
	cssclass:'te',
	cssfile: '/assets/css/tinyeditor_iframe.css',
	controlclass:'tecontrol',
	rowclass:'teheader',
	dividerclass:'tedivider',
	controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|',
			  'orderedlist','unorderedlist','|','outdent','indent','|','leftalign',
			  'centeralign','rightalign','blockjustify','|','unformat','|','undo','redo','n',
			  'size','style','|','image','hr','link','unlink','|','cut','copy','paste','print'],
	footer:true,
	xhtml:false,
	bodyid:'editor',
	footerclass:'tefooter',
	toggle:{text:'source',activetext:'wysiwyg',cssclass:'toggle'},
	resize:{cssclass:'resize'}
});
