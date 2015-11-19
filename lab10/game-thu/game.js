"use strict";

var numberOfBlocks = 9;
var targetBlocks = [];
var trapBlock;
var targetTimer;
var trapTimer;
var instantTimer;


document.observe('dom:loaded', function(){
	$("start").onclick=delayStart;
	$("stop").onclick=stopGame;
});

//delay the startGame function by 3 seconds
function delayStart(){
	$("state").innerHTML="Ready!";
	$("score").innerHTML="0";
	
	startGame.delay(3);
}

function startGame(){
	targetBlocks = [];
	clearInterval(targetTimer);
	clearInterval(trapTimer);
	clearTimeout(instantTimer);
	
	var block=$$(".block");
	for(var i=0;i<block.length;i++){
		block[i].removeClassName('target');
		block[i].removeClassName('trap');
	}
	
	startToCatch();
}

function stopGame(){
	$("state").innerHTML="Stop!";
	$("score").innerHTML="0";
	clearInterval(targetTimer);
	clearInterval(trapTimer);
	clearTimeout(instantTimer);
}

function startToCatch(){
	
	$("state").innerHTML="Catch!";
	targetTimer=setInterval(targetBlock,1000);
	trapTimer=setInterval(trapBlock,3000);
	
	var block=$$(".block");
	for(var i=0;i<block.length;i++){
		block[i].observe("click",touchBlock);		
	}
}

// ex 3. Show Target Block Function
function targetBlock(){	
	var block=$$(".block");
	if(targetBlocks.length>4)
	{	
		alert("You Lose!");
		clearInterval(targetTimer);
		targetBlock=[];
	}
	else
	{
		var check=true;
		
		while(check){
			var myVar=parseInt(Math.random() * block.length);
			check=false;
			
			for(var i=0;i<targetBlocks.length;i++){
				if(myVar==targetBlocks[i] || myVar==trapBlock){
					check=true;
				}
			}
		}
		
		for(var i=0;i<block.length;i++){
			if(block[i].getAttribute("data-index")==myVar){
				block[i].addClassName('target');
				targetBlocks.push(block[i].getAttribute("data-index"));
			}
		}
	}
	
}

//ex 4. Show trapBlock Function
function trapBlock(){
	var check=true;
	var block=$$(".block");
	var myVar=parseInt(Math.random() * block.length);
	
	
	if(targetBlocks.length>4)
	{	
		clearInterval(trapTimer);
		trapBlock=undefined;
	}
	else
	{
		while(check){
				var myVar=parseInt(Math.random() * block.length);
				check=false;
				
				for(var i=0;i<targetBlocks.length;i++){
					if(myVar==targetBlocks[i]){
						check=true;
					}
				}
		}
		
		for(var i=0;i<block.length;i++){
			if(block[i].getAttribute("data-index")==myVar){
				block[i].addClassName('trap');
				trapBlock=block[i].getAttribute("data-index");
			}
		}
	}
	
	removeTrap.delay(2);
}

//remove trap from Blocks
function removeTrap(){
	var block=$$(".block");
	for(var i=0;i<block.length;i++){
		if(block[i].getAttribute("data-index")==trapBlock){
			block[i].removeClassName('trap');
		}
	}
}

//remove Wrong click from Blocks
function removeWrong(){
	var block=$$(".block");
	for(var i=0;i<block.length;i++){
		if(block[i].hasClassName('wrong')){
			block[i].removeClassName('wrong');
		}
	}
}

//function to receive click event and to give score
function touchBlock(){
	var score=parseInt($("score").innerHTML);
	
	if(this.hasClassName('trap'))
	{
		this.removeClassName('trap');
		$("score").innerHTML=score-30;	
	}
	else if(this.hasClassName('target'))
	{
		this.removeClassName('target');
		targetBlocks.splice(targetBlocks.indexOf(this.getAttribute("data-index")),1);
		$("score").innerHTML=score+20;
	}else{
		$("score").innerHTML=score-10;
		this.addClassName('wrong');
		removeWrong.delay(0.1);
	}
	
}