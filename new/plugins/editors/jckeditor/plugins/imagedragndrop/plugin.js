/*------------------------------------------------------------------------
# Copyright (C) 2005-2012 WebxSolution Ltd. All Rights Reserved.
# @license - GPLv2.0
# Author: WebxSolution Ltd
# Websites:  http://www.webxsolution.com
# Terms of Use: An extension that is derived from the JoomlaCK editor will only be allowed under the following conditions: http://joomlackeditor.com/terms-of-use
# ------------------------------------------------------------------------*/ 
(function(){if(typeof a=="undefined"){function a(a){var b="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";var c={strlen:a.length%4!=0,chars:(new RegExp("[^"+b+"]")).test(a),equals:/=/.test(a)&&(/=[^=]/.test(a)||/={3}/.test(a))};if(c.strlen||c.chars||c.equals)throw new Error("Invalid base64 data");var d=[];var e=0;while(e<a.length){var f=b.indexOf(a.charAt(e++));var g=b.indexOf(a.charAt(e++));var h=b.indexOf(a.charAt(e++));var i=b.indexOf(a.charAt(e++));var j=(f<<18)+(g<<12)+((h&63)<<6)+(i&63);var k=(j&255<<16)>>16;var l=h==64?-1:(j&255<<8)>>8;var m=i==64?-1:j&255;d[d.length]=String.fromCharCode(k);if(l>=0)d[d.length]=String.fromCharCode(l);if(m>=0)d[d.length]=String.fromCharCode(m)}return d.join("")}}if(!XMLHttpRequest.prototype.sendAsBinary){XMLHttpRequest.prototype.sendAsBinary=function(a){function b(a){return a.charCodeAt(0)&255}var c=Array.prototype.map.call(a,b);var d=new Uint8Array(c);this.send(d.buffer)}}CKEDITOR.plugins.add("imagedragndrop",{init:function(a){var b=a.config.EnableImageDragndrop;var c=function(c){if(!b)return;var d=c.data;var e=d.$.dataTransfer;if(!e)return;if(!e.files||!e.files.length)return;d.preventDefault(true);var e=d.$.dataTransfer;var f=e.files[0];if(!f&&!f.filename)return;var g=CKEDITOR.tools.getNextId();var h=a.document.createElement("img");h.setAttributes({id:g,alt:""});a.getCommand("source").disable();var i=a.config.filebrowserImageUploadUrl||a.plugins.jfilebrowser._commandUrl(a,"QuickUpload",{type:"Images"});var j=i+"&client="+a.config.client+"&CKEditor="+a.name+"&CKEditorFuncNum=2&langCode="+a.langCode+"&dragndrop=1";if(window.FileReader){var k=new FileReader;k.onload=function(b){h.setAttribute("src",b.target.result);a.insertElement(h);var c=new XMLHttpRequest;c.open("POST",j);c.onload=function(){var b=this.responseText.match(/(0|2|201),\s*'(.*?)',/)[2];var c=a.document.getById(g);if(c){c.setAttribute("_cke_saved_src",b);c.setAttribute("src",b);c.removeAttribute("id")}a.getCommand("source").enable()};var d="---------------------------1966284435497298061834782736";var e="\r\n";var i="--"+d;i+=e+'Content-Disposition: form-data; name="upload"';var k=h.$.src.replace(/data:image\/(png|jpeg|gif);base64,/,"");var l=window.atob(k);i+='; filename="'+f.name+'"'+e+"Content-type: "+f.type;i+=e+e+l+e+"--"+d;i+="--";c.setRequestHeader("Content-Type","multipart/form-data; boundary="+d);c.sendAsBinary(i);delete h};k.readAsDataURL(f)}else if(window.FormData){var l=new FormData;var m=new XMLHttpRequest;a.insertElement(h);m.abort();m.open("POST",j);m.setRequestHeader("Cache-Control","no-cache");m.onload=function(){var b=this.responseText.match(/(0|2|201),\s*'(.*?)',/);if(b){var c=b[2];var d=a.document.getById(g);if(d){d.setAttribute("_cke_saved_src",c);d.setAttribute("src",c);d.removeAttribute("id")}a.getCommand("source").enable()}else{var e=new FormData;var h=new XMLHttpRequest;h.abort();h.open("POST",j);h.setRequestHeader("Cache-Control","no-cache");h.onload=function(){var b=this.responseText.match(/(0|2|201),\s*'(.*?)',/),c=a.document.getById(g);if(c){if(b){var d=b[2];c.setAttribute("_cke_saved_src",d);c.setAttribute("src",d);c.removeAttribute("id")}else{c.remove()}}a.getCommand("source").enable()};CKEDITOR.tools.setTimeout(function(){e.append("upload",f);h.send(e)},50)}};l.append("upload",f);m.send(l)}};var d=function(a){var b=a.data;if(!a.$)return;var c=a.$.dataTransfer;if(!c)return;b.preventDefault(true);if(b.$.dataTransfer)b.$.dataTransfer.dropEffect="copy";return false};a.on("contentDom",function(){a.document.on("ondragenter",d);a.document.on("dragover",d);a.document.on("drop",c);if(CKEDITOR.env.ie){a.document.getBody().on("ondragenter",d);a.document.getBody().on("dragover",d);a.document.getBody().on("drop",c)}})}})})()