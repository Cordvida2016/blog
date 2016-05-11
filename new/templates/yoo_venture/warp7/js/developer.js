/* Copyright (C) YOOtheme GmbH, http://www.gnu.org/licenses/gpl.html GNU/GPL */

(function(a){var d;a.each(files,function(f,b){if(!d){var e=a("head [data-file='"+b.target+"']");e.length&&a.less.getCSS(b.source,{compress:!0}).done(function(c){b.target.match(/-rtl\.css/i)&&(c=a.rtl.convert2RTL(c));e.html(c)}).fail(function(){d=!0})}})})(jQuery);
