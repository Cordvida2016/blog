(function(j){function d(b,a){return(a=b.trim().split(/\s+/))&&4==a.length?[a[0],a[3],a[2],a[1]].join(" "):b}function f(b){var a=0,g=0;arr=[];for(var c=0;c<b.length;++c){var e=b[c],a=a+("("==e?1:")"==e?-1:0);if(","==e&&0===a||c==b.length-1)arr.push(b.substr(g,c-g+1).trim().trimComma().trim()),g=c+1}return arr}function h(b){return b.match(/left/)?"right":b.match(/right/)?"left":b}function k(b){b.match(/\bleft\b/)?b=b.replace(/\bleft\b/,"right"):b.match(/\bright\b/)&&(b=b.replace(/\bright\b/,"left"));
var a=b.trim().split(/\s+/);a&&(1==a.length&&b.match(/(\d+)([a-z]{2}|%)/))&&(b="right "+b);a&&(2==a.length&&a[0].match(/\d+%/))&&(b=100-parseInt(a[0],10)+"% "+a[1]);pxmatch=a[0].match(/(\-?\d+)px/);a&&(2==a.length&&pxmatch)&&(b=pxmatch[1],b=("0"==b?"0":0>parseInt(b,10)?b.substr(1)+"px":"-"+b+"px")+" "+a[1]);return b}function l(b){return f(b).map(function(a){if("url("==a.substr(0,4))return a;-1!=a.indexOf("gradient")&&(a=a.replace(/(left|right)/g,function(a){return"left"===a?"right":"left"}),a=a.replace(/(\d+deg)/,
function(a){return 180-parseInt(a.replace("deg",""),10)+"deg"}));return a}).join(",")}function n(b){b=b.trim().replace(/\/\*[\s\S]+?\*\//g,"").replace(/[\n\r]/g,"").replace(/\s*([:;,{}])\s*/g,"$1").replace(/\s+/g," ");return b=b.replace(/(([^;:\{\}]+?)\:([^;:\{\}]+?);)/gi,function(a){var b=a.split(":")[0];a=a.split(":")[1].trimSemicolon();var c=/!important/,e=a.match(c);if(!b||!a)return"";b=p[b]||b;a=m[b]?m[b](a):a;!a.match(c)&&e&&(a+="!important");return b+":"+a+";"})}String.prototype.trim||(String.prototype.trim=
function(){return this.replace(/^\s+|\s+$/g,"")});String.prototype.trimComma||(String.prototype.trimComma=function(){return this.replace(/^,+|,+$/g,"")});String.prototype.trimSemicolon||(String.prototype.trimSemicolon=function(){return this.replace(/^;+|;+$/g,"")});var p={"margin-left":"margin-right","margin-right":"margin-left","padding-left":"padding-right","padding-right":"padding-left","border-left":"border-right","border-right":"border-left","border-left-color":"border-right-color","border-right-color":"border-left-color",
"border-left-width":"border-right-width","border-right-width":"border-left-width","border-left-style":"border-right-style","border-right-style":"border-left-style","border-bottom-right-radius":"border-bottom-left-radius","border-bottom-left-radius":"border-bottom-right-radius","border-top-right-radius":"border-top-left-radius","border-top-left-radius":"border-top-right-radius",left:"right",right:"left"},m={padding:d,margin:d,"text-align":h,"float":h,clear:h,direction:function(b){return b.match(/ltr/)?
"rtl":b.match(/rtl/)?"ltr":b},"border-radius":function(b){var a=b.trim().split(/\s+/);return a&&4==a.length?[a[1],a[0],a[3],a[2]].join(" "):a&&3==a.length?[a[1],a[0],a[1],a[2]].join(" "):b},"border-color":d,"border-width":d,"border-style":d,"background-position":k,"box-shadow":function(b){return b=f(b).map(function(a){var b=!1;a=a.split(" ");a.forEach(function(a,e,d){!b&&a.match(/\d/)&&(b=!0,d[e]="0"==a[0]?0:"-"==a[0]?a.substr(1):"-"+a)});return a.join(" ")}).join(",")},background:function(b){return f(b).map(function(a){a=
a.replace(/url\((.*?)\)|none|([^\s]*?gradient.*?\(.+\))/i,l);return a=a.replace(/\s(left|right|center|top|bottom|-?\d+([a-zA-Z]{2}|%?))\s(left|right|center|top|bottom|-?\d+([a-zA-Z]{2}|%?))[;\s]?/i,function(a){var b=0<=a.indexOf(";");a=a.trimSemicolon();return" "+k(a)+(b?";":" ")})}).join(",")},"background-image":l};j.rtl=j.rtl||{convert2RTL:n}})(jQuery);