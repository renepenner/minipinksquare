var MiniPinkSquare = new Class({

	initialize: function()
    {
		this.dataUrl 	= 'handleRequest.php';
	},
	
	init: function(){
		this.initCrateContentClass();
	},
	
	initCrateContentClass: function(){
		$('createContentClass').addEvent('submit', function(e) {
			e.stop();
			console.log(this);
			this.set('send', {onComplete: function(response) { 
				console.log(response);
			}});
			this.send();

			
			//var el = new Element('li', {'text': json[i].name});
			//$('contentclasses').grab(el);
		});
	},
	
	getRequest: function(method, params){
		var params = {method: method};		
		var myRequest = new Request.JSON({	
			method: 	'post', 
			url: 		'handleRequest.php',
			data:		params
		});
	
		return myRequest
	},
	
	getAllContentClass: function(){
		var req = this.getRequest('getAllContentClass', {});
		req.addEvent('onComplete', this.buildContentClasses);	
		req.send();
	},
	
	buildContentClasses: function(json){
		for(var i=0;i<json.length;i++){
			var el = new Element('li', {'text': json[i].name});
			$('contentclasses').grab(el);
		}
	}

});

var mps = new MiniPinkSquare();
window.addEvent('domready', function(){	
	mps.init();
	mps.getAllContentClass();	
});