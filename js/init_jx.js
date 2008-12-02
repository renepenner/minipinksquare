//init
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
	
	    var snapImg = new Element('img', {
        src: 'images/a_pixel.png',
        width: 5,
        height: 14
    });
	    var snapImg2 = new Element('img', {
        src: 'images/a_pixel.png',
        width: 5,
        height: 14
    });
    /* we can change the orientation of the splitter and ask it to use
     * existing child nodes.  We can also set specific layout constraints
     * on some or all of the areas in the splitter
     */
	 new Jx.Layout('mainApp');

    var mainAppSplitter = new Jx.Splitter('mainApp', {
        useChildren: true,
        /* the first bar will snap the area before it
         * open and closed on double click, the second
         * uses another element for the snap.
         */
        barOptions: [
            {snap:'before',snapElement: snapImg, snapEvents:['click']},
            {snap:'after',snapElement: snapImg2, snapEvents:['click']}
        ],
		containerOptions: [{width: 250}, {}, {width: 200}]
    });
	

	
    /* make some panels to go in the panel set */
    var p1 = new Jx.Panel({
        content: 'panelContent1'
    });
    var p2 = new Jx.Panel({
        label: 'baum',
        content: '',
		
    });
    var p3 = new Jx.Panel({
        label: 'Panel 3',
        content: 'panelContent2'
    });
    
    /* not much to configure for a panel set, just the
     * element it should go in and the panels it should
     * manage.
     */
	 
    var panelSet = new Jx.PanelSet({
        parent: mainAppSplitter.elements[0], 
        panels: [p1, p2, p3]
    });
	
	
	
	
	/*treetest*/
	var tree = new Jx.Tree({parent: $('mainAppLayoutContextLeft').getElements('.jxPanelContent')[1]});

    /* you can put an item right into the tree */
    var item = new Jx.TreeFolder({
        label: 'page',
        image: 'img/folder_16.png'
    });
    tree.append(item);
	item.expand();
	
    var item2 = new Jx.TreeFolder({
        label: 'saeng',
        image: 'img/folder_16.png',
        onClick: function() {
            debug('you clicked the bug!');
        }
    });
    item.append(item2);

	
    var item3 = new Jx.TreeItem({
        label: 'saeng',
        image: 'img/folder_16.png',
        onClick: function() {
            debug('you clicked the bug!');
        }
    });
    item2.append(item3);

	
    var item4 = new Jx.TreeItem({
        label: 'saeng',
        image: 'img/folder_16.png',
        onClick: function() {
            debug('you clicked the bug!');
        }
    });
    item2.append(item4);

	
	/*content - main+sidebar*/
	var tabBox = new Jx.TabBox({parent: 'mainAppLayoutContent'});

	tabBox.add(
        new Jx.Button.Tab({
            label: 'Dashboard',
            image: 'images/star.png',
            content: 'here be dashboard'
        }),
        new Jx.Button.Tab({
            label: 'Admin',
            image: 'images/page_white_code.png',
            content: 'here be admin'
        }),
        new Jx.Button.Tab({
            active: true,
            label: 'Content',
            image: 'images/page_white_world.png',
            content: 'content'
        }),
        new Jx.Button.Tab({
            label: 'Editor',
            content: 'soll das hier hin?'
        })
    );

	
	
	
	
});

function debug(debugobj){
	if(typeof console !== undefined) {
		if(typeof console.log !== undefined) {
			console.log (debugobj);
		}
	}

}


function drawPanelLeft() {
}