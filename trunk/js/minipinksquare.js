var MiniPinkSquare = new Class({

	initialize: function()
    {
		this.dataUrl 	= 'handleRequest.php';
	},
	
	init: function(){
		this.initCrateContentClass();
	},
	
	initCrateContentClass: function(){
		$('addContentClass').addEvent('click', function(e){
			e.stop();
			if($('createContentClass').style.display == 'none')
				$('createContentClass').style.display = 'block';
			else
				$('createContentClass').style.display = 'none';
		});
		
		var mps = this;
		$('createContentClass').addEvent('submit', function(e){
			e.stop();
				
			var myRequest = new Request.JSON({	
				method: 	'post', 
				url: 		'handleRequest.php'
			});
			
			myRequest.addEvent('onComplete', function(json){
				if(!json.error){
					this.addContentClass(json.id);
					alert('success');
				}else{
					alert('Error:\n'+json.msg);
				}
			}.bind(this));
			myRequest.send(e.target.toQueryString());
		}.bind(this));
	},
	
	getRequest: function(method, params){
		params.method = method;
		var myRequest = new Request.JSON({	
			method: 	'post', 
			url: 		'handleRequest.php',
			data:		params
		});
	
		return myRequest
	},
	
	getAllContentClass: function(){
		var req = this.getRequest('getAllContentClass', {});
		req.addEvent('onComplete', this.buildContentClasses.bind(this));	
		req.send();
	},
	
	buildContentClasses: function(json){
		for(var i=0;i<json.length;i++){
			this.addContentClass(json[i].id, json[i].name);
		}
	},
	
	addContentClass: function(id, name){
		if(name == null){
			var myRequest = new Request.JSON({	
				method: 	'post', 
				url: 		'handleRequest.php',
				data:		{method: 'getContentClass', id: id},
				async:		false
			});
			myRequest.send();
			name = myRequest.response.json.name;
		}
		
		var button = new Element('button', {'text': 'del'}).addEvent('click', function(e){
			this.delContentClass(id);
		}.bind(this));		
		var el = new Element('li', {'id': 'contentclass_'+id,'text': name});
		el.grab(button);
		$('contentclasses').grab(el);
	},
	
	delContentClass: function(id){
		var req = this.getRequest('delContentClass', {'id': id});
		req.addEvent('onComplete', function(response){
			if(!response.error){
				$('contentclass_'+id).destroy();
				alert('erfolgreich gelöscht!')
			}else{
				alert('ContentClass mit der id '+id+' konnte nicht gelöscht werden');
			}
		});	
		req.send();
	}

});

var mps = new MiniPinkSquare();
window.addEvent('domready', function(){	
	mps.init();
	mps.getAllContentClass();	
});