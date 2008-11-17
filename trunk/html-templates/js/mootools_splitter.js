/*
 	File:	mootools_splitter-0.2.js
	Title: 	Mootools PaneSplit Plugin
	Author:	gibbon@comspace.de
		Original Version: kae verens, http://verens.com/archives/2007/07/25/a-few-splitter-enhancements/
	Date:	2008-11-08



updated for mootools 1.2 by gibbon@comspace.de
	- added parameter: hasIframes (boolean)
		in case an iframe blocks the document.mousemove event.
	- added parameter: oncomplete (string)
		calls function with that name.
	- added classes to Handles
		mootoolsSplitterHandle0 ~ vertical bars
		mootoolsSplitterHandle1 ~ horizontal bars
*/
var Splitter=new Class({
	initialize:function(parent,parameters){
		if(!parameters)parameters={};
		if(parent){
			$(parent).setStyles({
				'margin':0,
				'padding':0
			});
			var w=parent.offsetWidth,h=parent.offsetHeight;
			if(parent===document.body || !parent.tagName){
				h=$pick(window.innerHeight,document.body.clientHeight);
				document.body.setStyle('overflow','hidden');
			}
			h=h-parseInt(parent.getStyle('border-top-width'))-parseInt(parent.getStyle('border-bottom-width'));
			w=w-parseInt(parent.getStyle('border-left-width'))-parseInt(parent.getStyle('border-right-width'));
		}
		else{
			var w=0,h=0;
		}
		var wrapper=new Element('div',{
			styles:{
				'position':'relative',
				'width':w,
				'height':h
			}
		});
		$extend(wrapper,{
			addWidget:Splitter__addWidget,
			parentResized:Splitter__parentResized,
			setSizes:Splitter__setSizes,
			sizes:Splitter__sizes
		});
		wrapper.handleWidth=$pick(parameters.handleWidth,4);
		wrapper.minimumSize=0;
		wrapper.orientation=$pick(parameters.orientation,0); // 0 is horizontal. otherwise, vertical
		wrapper.hasIframe=$pick(parameters.hasIframe,false); // false by default
		wrapper.oncomplete=$pick(parameters.oncomplete,''); // empty by default
		wrapper.widgets=[];
		wrapper.handles=[];
		wrapper.addClass('splitter');
		if(parent)parent.appendChild(wrapper);
		window.addEvent('resize',function(){
			var children=parent.getChildren();//$ES('*');
			children.each(function(child){
				if(child.parentResized)child.parentResized();
			});
		});
		return wrapper;
	}
});
function Splitter__addWidget(widget,parameters){
	if(!parameters)parameters={};
	var numWidgets=this.widgets.length;
	var orientation=this.orientation;
	var hasIframe = this.hasIframe;
	var oncomplete = this.oncomplete;
	var handle=new Element('div',{
		'class': 'mootoolsSplitterHandle'+orientation,
		'styles':{
			'background-color':'#aaa',
			'border':'none',
			'position':'absolute',
			'font-size':'0'
		}
	});
	handle.setStyles(orientation?{
		'border-width':'0',
		'cursor':'n-resize',
		'height':this.handleWidth,
		'width':this.offsetWidth
	}:{
		'border-width':'0',
		'cursor':'e-resize',
		'width':this.handleWidth,
		'height':this.offsetHeight
	});
	handle.num=numWidgets;
	handle.addEvent('mousedown',function(mousedownEvent){
		var parent=this.parentNode;
		var orientation=parent.orientation;
		var pseudoHandle=new Element('div',{
			'id': 'pseudoHandle',
			'styles':{
				'position':'absolute',
				'left':this.offsetLeft,
				'top':this.offsetTop,
				'border':'1px dashed #000',
				'font-size':'0'
			}
		});
		//console.log(hasIframe);
		if(hasIframe==true) {
			var antiIframe = new Element('div',{
				'id': 'antiIframe',
				'styles':{
					'position':'absolute',
					'z-index': '900000',
					//'background':'#fff',
					//'opacity':0.01,
					'left':0,
					'top':0,
					'bottom':0,
					'right':0
				}
			});
			document.body.appendChild(antiIframe);
		}
		parent.appendChild(pseudoHandle);
		pseudoHandle.setStyles(orientation?{
			'height':parent.handleWidth-2,
			'width':this.offsetWidth-2
		}:{
			'width':parent.handleWidth-2,
			'height':this.offsetHeight-2
		});
		var xoffset=parent.getPosition().x;
		var yoffset=parent.getPosition().y;
		var min=0;
		if(orientation){
			var x=this.offsetTop;
			var max=parent.offsetHeight-parent.handleWidth;
		}
		else{
			var x=this.offsetLeft;
			var max=parent.offsetWidth-parent.handleWidth;
		}
		if(this.num>1)min=(orientation?parent.handles[this.num-1].offsetTop:parent.handles[this.num-1].offsetLeft)+parent.handleWidth;
		if(this.num<parent.handles.length-1)max=(orientation?parent.handles[this.num+1].offsetTop:parent.handles[this.num+1].offsetLeft)-parent.handleWidth;

		var mouseup=function(e){
			var diff=x-(orientation?handle.offsetTop:handle.offsetLeft);
			var sizes=handle.parentNode.sizes();
			sizes[handle.num-1]+=diff;
			sizes[handle.num]-=diff;
			handle.parentNode.setSizes(sizes);
			$('pseudoHandle').destroy();
			$$('#antiIframe').each(function(el){el.destroy()});
			document.removeEvent('mouseup',mouseup);
			document.removeEvent('mousemove',mousemove);
			if(oncomplete!='')eval(oncomplete+'(sizes)');
		};
		var mousemove=function(e){
			var e=new Event(e),p={x:0,y:0};
			if(window.ie)try{document.selection.empty();}catch(err){};
			x=orientation?e.page.y-yoffset-p.y:e.page.x-xoffset-p.x;
			if(x<min)x=min;
			if(x>max)x=max;
			var dir=orientation?'top':'left';
			pseudoHandle.setStyle(dir,x);
						var diff=x-(orientation?handle.offsetTop:handle.offsetLeft);
			var sizes=handle.parentNode.sizes();
			sizes[handle.num-1]+=diff;
			sizes[handle.num]-=diff;
			handle.parentNode.setSizes(sizes);
			$$('textarea#main_edit')[0].focus();
		};

		document.addEvent('mousemove',mousemove);
		document.addEvent('mouseup',mouseup);
	});
	
	
	
	
	
	if(!numWidgets){
		handle.setStyle('display','none');
	}
	var widgetWrapper=new Element('div',{
		'class':'panel',
		'styles':{
			'position':'absolute',
			'height':this.offsetHeight,
			'width':this.offsetWidth,
			'overflow':'auto'
		}
	});
	var sizes=[];
	var w=0;
	if(numWidgets)w+=numWidgets*this.handleWidth;
	for(var i=0;i<numWidgets;++i){
		var panel=this.widgets[i];
		if(orientation){
			panel.setStyle('height',Math.floor(panel.offsetHeight*(numWidgets/(numWidgets+1))));
			w+=panel.offsetHeight;
			sizes.push(panel.offsetHeight);
		}
		else{
			panel.setStyle('width',Math.floor(panel.offsetWidth*(numWidgets/(numWidgets+1))));
			w+=panel.offsetWidth;
			sizes.push(panel.offsetWidth);
		}
	}
	sizes.push((orientation?this.offsetHeight:this.offsetWidth)-w);

	widgetWrapper.minimumSize=$pick(parameters.minimumSize,0);
	this.minimumSize+=widgetWrapper.minimumSize;
	widgetWrapper.appendChild(widget);
	this.appendChild(handle);
	this.appendChild(widgetWrapper);
	this.handles.push(handle);
	this.widgets.push(widgetWrapper);
	this.setSizes(sizes);
}
function Splitter__parentResized(){
	var parent=this.parentNode;
	var w=parent.offsetWidth,h=parent.offsetHeight;
	if(parent===document.body){
		h=window.getHeight();
	}
	h=h-parseInt(parent.getStyle('border-top-width'))-parseInt(parent.getStyle('border-bottom-width'));
	w=w-parseInt(parent.getStyle('border-left-width'))-parseInt(parent.getStyle('border-right-width'));
	this.setStyles({
		'width':w,
		'height':h
	});
	this.setSizes(this.sizes());
}
function Splitter__setSizes(sizes){
	if(!this.offsetWidth||!this.offsetHeight)return;
	if(!this.handles.length)return;
	var x=0;
	var w=0;
	for(var i=0;i<sizes.length;++i){
		w+=sizes[i];
	}
	var h=(sizes.length>1)?this.handleWidth*(sizes.length-1):0;
	var maxSize=this.orientation?this.offsetHeight-h:this.offsetWidth-h;
	if(!w){ // panel sizes are all 0
		var panelSize=Math.floor(maxSize/this.handles.length);
		for(var i=this.handles.length-1;i;--i)sizes[i]=panelSize;
		sizes[0]=maxSize-panelSize*(this.handles.length-1);
	}
	else if(w!=maxSize){ // panel sizes don't add up
		var ratio=maxSize/w;
		var sum=0;
		for(var i=this.handles.length-1;i;--i){
			var newSize=Math.floor(sizes[i]*ratio);
			sizes[i]=newSize;
			sum+=newSize;
		}
		sizes[0]=maxSize-sum;
	}
	if(this.minimumSize<maxSize && this.minimumSize){ // check for width constraints
		var found=0,minTotal=0,nonMinArr=[],nonMinTotal=0;
		for(var i=0;i<sizes.length;++i){
			if(this.widgets[i].minimumSize>sizes[i]){
				sizes[i]=this.widgets[i].minimumSize;
				found=1;
				minTotal+=this.widgets[i].minimumSize;
			}
			else{
				nonMinTotal+=sizes[i];
				nonMinArr.push(i);
			}
		}
		if(found){
			var ratio=(maxSize-minTotal)/nonMinTotal;
			for(var i=0;i<nonMinArr.length;++i)sizes[nonMinArr[i]]=Math.floor(sizes[nonMinArr[i]]*ratio);
			return this.setSizes(sizes);
		}
	}
	for(var i=0;i<sizes.length;++i){
		if(i){
			this.handles[i].setStyles(this.orientation?{
				'left':0,
				'width':this.offsetWidth,
				'top':x
			}:{
				'left':x,
				'top':0,
				'height':this.offsetHeight
			});
			x+=this.handleWidth;
		}
		this.widgets[i].setStyles(this.orientation?{
			'top':x,
			'left':0,
			'width':this.offsetWidth,
			'height':sizes[i]
		}:{
			'left':x,
			'top':0,
			'height':this.offsetHeight,
			'width':sizes[i]
		});
		x+=sizes[i];
	}
	var children=this.getChildren('*');//$ES('*',this);
	children.each(function(child){
		if(child.parentResized)child.parentResized();
	});
}
function Splitter__sizes(){
	var sizes=[];
	for(var i=0;i<this.widgets.length;++i)sizes.push(this.orientation?this.widgets[i].offsetHeight:this.widgets[i].offsetWidth);
	return sizes;
}
