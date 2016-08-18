/* (  this is comment 1 ) */
 function NewObject(prefix) {
 var count=0;
 this.SayHello=function(msg) {
 count++;
 /* (  this is comment 2 ) */
 alert(prefix+msg);
 };
 this.GetCount=function() {
 return count;
 };
 };
 var obj=new NewObject("Message : ");
 /* ( this is comment 3 comment continuation coment ending ) */
 obj.SayHello("You are welcome.");

