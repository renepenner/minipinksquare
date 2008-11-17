<?
$php_include_prefix = '../';
require_once($php_include_prefix.'inc/functions.php');
?>//init
var horizSplit = false;

window.addEvent('domready', function(){
	
	/*its_all_text*/
	var firefoxExtensionItsAllText = false;
	$$('img').each(function(element){
		if(element.src=='chrome://itsalltext/locale/gumdrop.png') {
			debug('Firefox Extension "Its all Text" seems to be installed');
			var firefoxExtensionItsAllText = true;
		}
	});
	
	
	
	
	new TabSwapper({
		selectedClass: 'on',
		deselectedClass: 'off',
		tabs: $$('#cnt_context li'),
		clickers: $$('#cnt_context li a'),
		sections: $$('div.panelSet div.panel'),
		/*remember what the last tab the user clicked was*/
		cookieName: 'tabSetBinContext',
		/*use transitions to fade across*/
		smooth: false,
		smoothSize: false
	});
	
	
	
	
	horizSplit=new Splitter($("frame_cnt"), {hasIframe:true, oncomplete:'resizeEdit'});
	horizSplit.addWidget($("cnt_main"),{minimumSize:300});
	horizSplit.addWidget($("cnt_context"), {minimumSize: 100});
	var bodywidth = $$('body')[0].getSize().x;
	horizSplit.setSizes([bodywidth-331,331]);
	horizSplit.setSizes([bodywidth-330,330]);

	resizeEdit('dummy');
	
	
	/*
	
	$$('ul#tags li span').each(function(element){
		if(!element.hasClass('noedit')){
			element.addEvent('click', function(){this.inlineEdit({
				onComplete: editTag,
				stripHtml: true
				});
			
			});
			
			
			
			var rel = element.getAttribute('rel');
			
			element.getParent().getChildren('a').each(function(el){
				//debug('remove found: '+rel);
				el.addEvent('click', function(){
					debug('remove Tag: '+rel);
					removeTag(rel);
					});
				}, rel);
		}
	});
	
	
	
	*/
	
	
});

window.addEvent('resize', resizeEdit);


function resizeEdit(dimensions){
	debug('trying to resize the main editor and splitPane');
	//var bodywidth = $$('body')[0].getSize().x;
	//horizSplit.setSizes([bodywidth-331,331]);
	//horizSplit.setSizes([bodywidth-330,330]);
	
	editAreaLoader.hide('main_edit');
	editAreaLoader.show('main_edit');
}






function getMetadata(binID) {
	var jsonRequest = new Request.JSON({url: "action.php", onComplete: function(response){
    if(response.status==1){//success
		//window.location = 'edit.php?bin='+response.value;
		debug(response);
		response.value.tags.each(function(tag){
			addTagHTML(tag.name, tag.type, tag.tags_id);
		});
		
	}else{
		debug(response);
	}
}}).get({'action': 'getMetadata', 'bin': binID});

}





function createNewBin(typeID) {
	var jsonRequest = new Request.JSON({url: "action.php", onComplete: function(response){
    if(response.status==1){//success
		window.location = 'edit.php?bin='+response.value;
	}
}}).get({'action': 'add', 'type': typeID});

}


function editTag(element) {
	var oldTag = element.getAttribute('rel');
	var newTag = element.innerHTML;
	if(newTag == oldTag){
		debug('Tag '+newTag+' not changed');
	}
	else {
		debug('Tag '+oldTag+' changed to '+newTag+' (implement save!)');
	}
	
}


function addTagHTML(name, type, id){
	// 	<li class="tags is"><a href="#"><img src="img/ico_delete_16.png"></a><span rel="nocheintag">nocheintag</span></li>
	//var class =
	
	var newTagA = new Element('a', {
		'href':'#',
		'html':'<img src="img/ico_delete_16.png">'
	});

	var newTagSpan = new Element('span', {
		'rel': name,
		'html': name
	});
	
	var newTag = new Element('li', {
		'class': type,
		//'html': '<a href="#"></a><span rel="'+name+'">'+name+'</span>'
	});
	
	newTagA.inject(newTag, 'top');
	newTagSpan.inject(newTag, 'bottom');
	
	
	
	
	newTagA.addEvent('click', function(){
					debug('remove Tag: '+name);
					removeTag(name);
					});
	
	newTagSpan.addEvent('click', function(){this.inlineEdit({
				onComplete: editTag,
				stripHtml: true
				});
				}); 
	
	newTag.inject($('tags'), 'bottom');
}

function addTag(name, type) { //TODO: save tag, get ID.
if(name != '')
	addTagHTML(name, type, '123');
}

function removeTag(tagName){
	debug('removing');
	$$('ul#tags li span[rel='+tagName+']').each(function(el){
		el.getParent().destroy();
	});

}

<?
//get all types
// $query = "SELECT id, name FROM bins_types";
// $sql = new Sql();
// $result = $sql->getAll($query);
// $tagtypes = Array();
// foreach($result as $key=>$value){
	// $tagtypes[$value['id']] = $value['name'];
// }

// $tagtypes = array('normal'=>'is', 
	// 'conflicts'=>'conflicts');
//var_dump($tagtypes);
?>
var addTagPrefill = '';
function addTagDialog(){
	debug('addTagDialog');
	
	var stickyHtml = '<label for="addTag_tagname">Name:</label><input type="text" name="addTag_tagname" id="addTag_tagname" value="'+addTagPrefill+'" onChange="addTagPrefill=this.value">';
	
	var stickycontent = StickyWin.ui('Add Tag', stickyHtml, {
  width: '200px',
    buttons: [
        {
            text: 'add Tag', 
            onClick: function(){addTag(addTagPrefill, 'is'); addTagPrefill = '';},
            properties: {
                'class': 'closeSticky blah', //still closes
                style: 'width: 100px, border: 1px solid red',
                title: 'add this tag!'
            }
        }
    ]
});
var addTagSticky = new StickyWin.Modal({
    content: stickycontent,
	onClose: destroyStickies()
});

$('addTag_tagname').focus();

}

function destroyStickies() {
	$$('.StickyWinInstance').each(function(element){
		element.retrieve('StickyWin').destroy();
	});
}


function debug(debugobj){
	if(typeof console != undefined) {
	 console.log (debugobj);
	}

}