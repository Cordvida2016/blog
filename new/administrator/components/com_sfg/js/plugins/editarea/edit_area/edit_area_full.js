function EAL() {
	this.version = "0.7.2.3";
	date = new Date();
	this.start_time = date.getTime();
	this.win = "loading";
	this.error = false;
	this.baseURL = "";
	this.template = "";
	this.lang = new Object();
	this.load_syntax = new Object();
	this.syntax = new Object();
	this.loadedFiles = new Array();
	this.waiting_loading = new Object();
	this.scripts_to_load = new Array();
	this.sub_scripts_to_load = new Array();
	this.resize = new Array();
	this.hidden = new Object();
	this.default_settings = {debug:false ,smooth_selection:true ,font_size:"10" ,font_family:"monospace" ,start_highlight:false ,autocompletion:false ,toolbar:"search,go_to_line,fullscreen,|,undo,redo,|,select_font,|,change_smooth_selection,highlight,reset_highlight,|,help" ,begin_toolbar:"" ,end_toolbar:"" ,is_multi_files:false ,allow_resize:"both" ,show_line_colors:false ,min_width:400 ,min_height:125 ,replace_tab_by_spaces:false ,allow_toggle:true ,language:"en" ,syntax:"" ,syntax_selection_allow:"basic,brainfuck,c,coldfusion,cpp,css,html,js,pas,perl,php,python,ruby,robotstxt,sql,tsql,vb,xml" ,display:"onload" ,max_undo:30 ,browsers:"known" ,plugins:"" ,gecko_spellcheck:false ,fullscreen:false ,is_editable:true ,wrap_text:false ,load_callback:"" ,save_callback:"" ,change_callback:"" ,submit_callback:"" ,EA_init_callback:"" ,EA_delete_callback:"" ,EA_load_callback:"" ,EA_unload_callback:"" ,EA_toggle_on_callback:"" ,EA_toggle_off_callback:"" ,EA_file_switch_on_callback:"" ,EA_file_switch_off_callback:"" ,EA_file_close_callback:"" };
	
	this.advanced_buttons = [
		['new_document','newdocument.gif','new_document',false],
		['search','search.gif','show_search',false],
		['go_to_line','go_to_line.gif','go_to_line',false],
		['undo','undo.gif','undo',true],
		['redo','redo.gif','redo',true],
		['change_smooth_selection','smooth_selection.gif','change_smooth_selection_mode',true],
		['reset_highlight','reset_highlight.gif','resync_highlight',true],
		['highlight','highlight.gif','change_highlight',true],
		['help','help.gif','show_help',false],
		['save','save.gif','save',false],
		['load','load.gif','load',false],
		['fullscreen','fullscreen.gif','toggle_full_screen',false],
		['autocompletion','autocompletion.gif','toggle_autocompletion',true]
	];
	ua = navigator.userAgent;
	this.nav = new Object();
	this.nav['isMacOS'] = (ua.indexOf('Mac OS') != -1);
	this.nav['isIE'] = (navigator.appName == "Microsoft Internet Explorer");
	if (this.nav['isIE']) {
		this.nav['isIE'] = ua.replace(/^.*?MSIE ([0-9\.]*).*$/, "$1");
		/*if(this.nav['isIE'] >= 9){
			this.nav['isIE'] = false;
			this.nav['isFirefox'] = 3.6;
		}*/
		if (this.nav['isIE'] < 6)this.has_error();
	}
	if (this.nav['isNS'] = ua.indexOf('Netscape/') != -1) {
		this.nav['isNS'] = ua.substr(ua.indexOf('Netscape/') + 9);
		if (this.nav['isNS'] < 8 || !this.nav['isIE'])this.has_error();
	}
	if (this.nav['isOpera'] = (ua.indexOf('Opera') != -1)) {
		this.nav['isOpera'] = ua.replace(/^.*?Opera.*?([0-9\.]+).*$/i, "$1");
		if (this.nav['isOpera'] < 9)this.has_error();
		this.nav['isIE'] = false;
	}
	this.nav['isGecko'] = (ua.indexOf('Gecko') != -1);
	if (this.nav['isFirefox'] = (ua.indexOf('Firefox') != -1))this.nav['isFirefox'] = ua.replace(/^.*?Firefox.*?([0-9\.]+).*$/i, "$1");
	if (this.nav['isIceweasel'] = (ua.indexOf('Iceweasel') != -1))this.nav['isFirefox'] = this.nav['isIceweasel'] = ua.replace(/^.*?Iceweasel.*?([0-9\.]+).*$/i, "$1");
	if (this.nav['GranParadiso'] = (ua.indexOf('GranParadiso') != -1))this.nav['isFirefox'] = this.nav['isGranParadiso'] = ua.replace(/^.*?GranParadiso.*?([0-9\.]+).*$/i, "$1");
	if (this.nav['BonEcho'] = (ua.indexOf('BonEcho') != -1))this.nav['isFirefox'] = this.nav['isBonEcho'] = ua.replace(/^.*?BonEcho.*?([0-9\.]+).*$/i, "$1");
	if (this.nav['isCamino'] = (ua.indexOf('Camino') != -1))this.nav['isCamino'] = ua.replace(/^.*?Camino.*?([0-9\.]+).*$/i, "$1");
	if (this.nav['isChrome'] = (ua.indexOf('Chrome') != -1))this.nav['isChrome'] = ua.replace(/^.*?Chrome.*?([0-9\.]+).*$/i, "$1");
	if (this.nav['isSafari'] = (ua.indexOf('Safari') != -1))this.nav['isSafari'] = ua.replace(/^.*?Version\/([0-9]+\.[0-9]+).*$/i, "$1");
	if (this.nav['isIE'] >= 6 || this.nav['isOpera'] >= 9 || this.nav['isFirefox'] || this.nav['isChrome'] || this.nav['isCamino'] || this.nav['isSafari'] >= 3)this.nav['isValidBrowser'] = true;
	else this.nav['isValidBrowser'] = false;
	this.set_base_url();
	for (var i = 0; i < this.scripts_to_load.length; i++) {
		setTimeout("eAL.load_script('" + this.baseURL + this.scripts_to_load[i] + ".js');", 1);
		this.waiting_loading[this.scripts_to_load[i] + ".js"] = false;
	}
	this.add_event(window, "load", EAL.prototype.window_loaded);
	
	
	if(this.nav['isIE'] && this.nav['isIE']>=9){
		this.default_settings.replace_tab_by_spaces = 4;
	}
	
}
;
EAL.prototype = {has_error:function() {
	this.error = true;
	for (var i in EAL.prototype) {
		EAL.prototype[i] = function() {
		};
	}
},window_loaded:function() {
	eAL.win = "loaded";
	if (document.forms) {
		for (var i = 0; i < document.forms.length; i++) {
			var form = document.forms[i];
			form.edit_area_replaced_submit = null;
			try {
				form.edit_area_replaced_submit = form.onsubmit;
				form.onsubmit = "";
			} catch (e) {
			}
			eAL.add_event(form, "submit", EAL.prototype.submit);
			eAL.add_event(form, "reset", EAL.prototype.reset);
		}
	}
	eAL.add_event(window, "unload", function() {
		for (var i in eAs) {
			eAL.delete_instance(i);
		}
	});
},init_ie_textarea:function(id) {
	var t = document.getElementById(id);
	try {
		if (t && typeof(t.focused) == "undefined") {
			t.focus();
			t.focused = true;
			t.selectionStart = t.selectionEnd = 0;
			get_IE_selection(t);
			eAL.add_event(t, "focus", IE_textarea_focus);
			eAL.add_event(t, "blur", IE_textarea_blur);
		}
	} catch(ex) {
	}
},init:function(settings) {
	if (!settings["id"])this.has_error();
	if (this.error)return;
	if (eAs[settings["id"]])eAL.delete_instance(settings["id"]);
	for (var i in this.default_settings) {
		if (typeof(settings[i]) == "undefined")settings[i] = this.default_settings[i];
	}
	if (settings["browsers"] == "known" && this.nav['isValidBrowser'] == false) {
		return;
	}
	if (settings["begin_toolbar"].length > 0)settings["toolbar"] = settings["begin_toolbar"] + "," + settings["toolbar"];
	if (settings["end_toolbar"].length > 0)settings["toolbar"] = settings["toolbar"] + "," + settings["end_toolbar"];
	settings["tab_toolbar"] = settings["toolbar"].replace(/ /g, "").split(",");
	settings["plugins"] = settings["plugins"].replace(/ /g, "").split(",");
	for (var i = 0; i < settings["plugins"].length; i++) {
		if (settings["plugins"][i].length == 0)settings["plugins"].splice(i, 1);
	}
	this.get_template();
	this.load_script(this.baseURL + "langs/" + settings["language"] + ".js");
	if (settings["syntax"].length > 0) {
		settings["syntax"] = settings["syntax"].toLowerCase();
		this.load_script(this.baseURL + "reg_syntax/" + settings["syntax"] + ".js");
	}
	eAs[settings["id"]] = {"settings":settings};
	eAs[settings["id"]]["displayed"] = false;
	eAs[settings["id"]]["hidden"] = false;
	eAL.start(settings["id"]);
},delete_instance:function(id) {
	eAL.execCommand(id, "EA_delete");
	if (window.frames["frame_" + id] && window.frames["frame_" + id].editArea) {
		if (eAs[id]["displayed"])eAL.toggle(id, "off");
		window.frames["frame_" + id].editArea.execCommand("EA_unload");
	}
	var span = document.getElementById("EditAreaArroundInfos_" + id);
	if (span)span.parentNode.removeChild(span);
	var iframe = document.getElementById("frame_" + id);
	if (iframe) {
		iframe.parentNode.removeChild(iframe);
		try {
			delete window.frames["frame_" + id];
		} catch (e) {
		}
	}
	delete eAs[id];
},start:function(id) {
	if (this.win != "loaded") {
		setTimeout("eAL.start('" + id + "');", 50);
		return;
	}
	for (var i in eAL.waiting_loading) {
		if (eAL.waiting_loading[i] != "loaded" && typeof(eAL.waiting_loading[i]) != "function") {
			setTimeout("eAL.start('" + id + "');", 50);
			return;
		}
	}
	if (!eAL.lang[eAs[id]["settings"]["language"]] || (eAs[id]["settings"]["syntax"].length > 0 && !eAL.load_syntax[eAs[id]["settings"]["syntax"]])) {
		setTimeout("eAL.start('" + id + "');", 50);
		return;
	}
	if (eAs[id]["settings"]["syntax"].length > 0)eAL.init_syntax_regexp();
	if (!document.getElementById("EditAreaArroundInfos_" + id) && (eAs[id]["settings"]["debug"] || eAs[id]["settings"]["allow_toggle"])) {
		var span = document.createElement("span");
		span.id = "EditAreaArroundInfos_" + id;
		var html = "";
		if (eAs[id]["settings"]["allow_toggle"]) {
			checked = (eAs[id]["settings"]["display"] == "onload") ? "checked" : "";
			html += "<div id='edit_area_toggle_" + i + "'>";
			html += "<input id='edit_area_toggle_checkbox_" + id + "' class='toggle_" + id + "' type='checkbox' onclick='eAL.toggle(\"" + id + "\");' accesskey='e' " + checked + " />";
			html += "<label for='edit_area_toggle_checkbox_" + id + "'>{$toggle}</label></div>";
		}
		if (eAs[id]["settings"]["debug"])html += "<textarea id='edit_area_debug_" + id + "' style='z-index:20;width:100%;height:120px;overflow:auto;border:solid black 1px;'></textarea><br />";
		html = eAL.translate(html, eAs[id]["settings"]["language"]);
		span.innerHTML = html;
		var father = document.getElementById(id).parentNode;
		var next = document.getElementById(id).nextSibling;
		if (next == null)father.appendChild(span);
		else father.insertBefore(span, next);
	}
	if (!eAs[id]["initialized"]) {
		this.execCommand(id, "EA_init");
		if (eAs[id]["settings"]["display"] == "later") {
			eAs[id]["initialized"] = true;
			return;
		}
	}
	if (this.nav['isIE']) {
		eAL.init_ie_textarea(id);
	}
	var html_toolbar_content = "";
	area = eAs[id];
	for (var i = 0; i < area["settings"]["tab_toolbar"].length; i++) {
		html_toolbar_content += this.get_control_html(area["settings"]["tab_toolbar"][i], area["settings"]["language"]);
	}
	if (!this.iframe_script) {
		this.iframe_script = "";
		for (var i = 0; i < this.sub_scripts_to_load.length; i++)this.iframe_script += '<script language="javascript" type="text/javascript" src="' + this.baseURL + this.sub_scripts_to_load[i] + '.js"></script>';
	}
	for (var i = 0; i < area["settings"]["plugins"].length; i++) {
		if (!eAL.all_plugins_loaded)this.iframe_script += '<script language="javascript" type="text/javascript" src="' + this.baseURL + 'plugins/' + area["settings"]["plugins"][i] + '/' + area["settings"]["plugins"][i] + '.js"></script>';
		this.iframe_script += '<script language="javascript" type="text/javascript" src="' + this.baseURL + 'plugins/' + area["settings"]["plugins"][i] + '/langs/' + area["settings"]["language"] + '.js"></script>';
	}
	if (!this.iframe_css) {
		this.iframe_css = "<link href='" + this.baseURL + "edit_area.css' rel='stylesheet' type='text/css' />";
	}
	var template = this.template.replace(/\[__BASEURL__\]/g, this.baseURL);
	template = template.replace("[__TOOLBAR__]", html_toolbar_content);
	template = this.translate(template, area["settings"]["language"], "template");
	template = template.replace("[__CSSRULES__]", this.iframe_css);
	template = template.replace("[__JSCODE__]", this.iframe_script);
	template = template.replace("[__EA_VERSION__]", this.version);
	area.textarea = document.getElementById(area["settings"]["id"]);
	eAs[area["settings"]["id"]]["textarea"] = area.textarea;
	if (typeof(window.frames["frame_" + area["settings"]["id"]]) != 'undefined')delete window.frames["frame_" + area["settings"]["id"]];
	var father = area.textarea.parentNode;
	var content = document.createElement("iframe");
	content.name = "frame_" + area["settings"]["id"];
	content.id = "frame_" + area["settings"]["id"];
	content.style.borderWidth = "0px";
	setAttribute(content, "frameBorder", "0");
	content.style.overflow = "hidden";
	content.style.display = "none";
	var next = area.textarea.nextSibling;
	if (next == null)father.appendChild(content);
	else father.insertBefore(content, next);
	var frame = window.frames["frame_" + area["settings"]["id"]];
	frame.document.open();
	frame.eAs = eAs;
	frame.area_id = area["settings"]["id"];
	frame.document.area_id = area["settings"]["id"];
	frame.document.write(template);
	frame.document.close();
},toggle:function(id, toggle_to) {
	if (!toggle_to)toggle_to = (eAs[id]["displayed"] == true) ? "off" : "on";
	if (eAs[id]["displayed"] == true && toggle_to == "off") {
		this.toggle_off(id);
	}
	else if (eAs[id]["displayed"] == false && toggle_to == "on") {
		this.toggle_on(id);
	}
	return false;
},toggle_off:function(id) {
	if (window.frames["frame_" + id]) {
		var frame = window.frames["frame_" + id];
		if (frame.editArea.fullscreen['isFull'])frame.editArea.toggle_full_screen(false);
		eAs[id]["displayed"] = false;
		eAs[id]["textarea"].wrap = "off";
		setAttribute(eAs[id]["textarea"], "wrap", "off");
		var parNod = eAs[id]["textarea"].parentNode;
		var nxtSib = eAs[id]["textarea"].nextSibling;
		parNod.removeChild(eAs[id]["textarea"]);
		parNod.insertBefore(eAs[id]["textarea"], nxtSib);
		eAs[id]["textarea"].value = frame.editArea.textarea.value;
		var selStart = frame.editArea.last_selection["selectionStart"];
		var selEnd = frame.editArea.last_selection["selectionEnd"];
		var scrollTop = frame.document.getElementById("result").scrollTop;
		var scrollLeft = frame.document.getElementById("result").scrollLeft;
		document.getElementById("frame_" + id).style.display = 'none';
		eAs[id]["textarea"].style.display = "inline";
		eAs[id]["textarea"].focus();
		if (this.nav['isIE']) {
			eAs[id]["textarea"].selectionStart = selStart;
			eAs[id]["textarea"].selectionEnd = selEnd;
			eAs[id]["textarea"].focused = true;
			set_IE_selection(eAs[id]["textarea"]);
		}
		else {
			if (this.nav['isOpera']) {
				eAs[id]["textarea"].setSelectionRange(0, 0);
			}
			try {
				eAs[id]["textarea"].setSelectionRange(selStart, selEnd);
			} catch(e) {
			}
			;
		}
		eAs[id]["textarea"].scrollTop = scrollTop;
		eAs[id]["textarea"].scrollLeft = scrollLeft;
		frame.editArea.execCommand("toggle_off");
	}
},toggle_on:function(id) {
	if (window.frames["frame_" + id]) {
		var frame = window.frames["frame_" + id];
		area = window.frames["frame_" + id].editArea;
		area.textarea.value = eAs[id]["textarea"].value;
		var selStart = 0;
		var selEnd = 0;
		var scrollTop = 0;
		var scrollLeft = 0;
		if (eAs[id]["textarea"].use_last == true) {
			var selStart = eAs[id]["textarea"].last_selectionStart;
			var selEnd = eAs[id]["textarea"].last_selectionEnd;
			var scrollTop = eAs[id]["textarea"].last_scrollTop;
			var scrollLeft = eAs[id]["textarea"].last_scrollLeft;
			eAs[id]["textarea"].use_last = false;
		}
		else {
			try {
				var selStart = eAs[id]["textarea"].selectionStart;
				var selEnd = eAs[id]["textarea"].selectionEnd;
				var scrollTop = eAs[id]["textarea"].scrollTop;
				var scrollLeft = eAs[id]["textarea"].scrollLeft;
			} catch(ex) {
			}
		}
		this.set_editarea_size_from_textarea(id, document.getElementById("frame_" + id));
		eAs[id]["textarea"].style.display = "none";
		document.getElementById("frame_" + id).style.display = "inline";
		area.execCommand("focus");
		eAs[id]["displayed"] = true;
		area.execCommand("update_size");
		window.frames["frame_" + id].document.getElementById("result").scrollTop = scrollTop;
		window.frames["frame_" + id].document.getElementById("result").scrollLeft = scrollLeft;
		area.area_select(selStart, selEnd - selStart);
		area.execCommand("toggle_on");
	}
	else {
		var elem = document.getElementById(id);
		elem.last_selectionStart = elem.selectionStart;
		elem.last_selectionEnd = elem.selectionEnd;
		elem.last_scrollTop = elem.scrollTop;
		elem.last_scrollLeft = elem.scrollLeft;
		elem.use_last = true;
		eAL.start(id);
	}
},set_editarea_size_from_textarea:function(id, frame) {
	var elem = document.getElementById(id);
	var width = Math.max(eAs[id]["settings"]["min_width"], elem.offsetWidth) + "px";
	var height = Math.max(eAs[id]["settings"]["min_height"], elem.offsetHeight) + "px";
	if (elem.style.width.indexOf("%") != -1)width = elem.style.width;
	if (elem.style.height.indexOf("%") != -1)height = elem.style.height;
	frame.style.width = width;
	frame.style.height = height;
},set_base_url:function() {
	if (!this.baseURL) {
		var elements = document.getElementsByTagName('script');
		for (var i = 0; i < elements.length; i++) {
			if (elements[i].src && elements[i].src.match(/edit_area_[^\\\/]*$/i)) {
				var src = elements[i].src;
				src = src.substring(0, src.lastIndexOf('/'));
				this.baseURL = src;
				this.file_name = elements[i].src.substr(elements[i].src.lastIndexOf("/") + 1);
				break;
			}
		}
	}
	var documentBasePath = document.location.href;
	if (documentBasePath.indexOf('?') != -1)documentBasePath = documentBasePath.substring(0, documentBasePath.indexOf('?'));
	var documentURL = documentBasePath;
	documentBasePath = documentBasePath.substring(0, documentBasePath.lastIndexOf('/'));
	if (this.baseURL.indexOf('://') == -1 && this.baseURL.charAt(0) != '/') {
		this.baseURL = documentBasePath + "/" + this.baseURL;
	}
	this.baseURL += "/";
},get_button_html:function(id, img, exec, isFileSpecific, baseURL) {
	if (!baseURL)baseURL = this.baseURL;
	var cmd = 'editArea.execCommand(\'' + exec + '\')';
	html = '<a id="a_' + id + '" href="javascript:' + cmd + '" onclick="' + cmd + ';return false;" onmousedown="return false;" target="_self" fileSpecific="' + (isFileSpecific ? 'yes' : 'no') + '">';
	html += '<img id="' + id + '" src="' + baseURL + 'images/' + img + '" title="{$' + id + '}" width="20" height="20" class="editAreaButtonNormal" onmouseover="editArea.switchClass(this,\'editAreaButtonOver\');" onmouseout="editArea.restoreClass(this);" onmousedown="editArea.restoreAndSwitchClass(this,\'editAreaButtonDown\');" /></a>';
	return html;
},get_control_html:function(button_name, lang) {
	for (var i = 0; i < this.advanced_buttons.length; i++) {
		var but = this.advanced_buttons[i];
		if (but[0] == button_name) {
			return this.get_button_html(but[0], but[1], but[2], but[3]);
		}
	}
	switch (button_name) {
		case "*":
		case "return":
			return "<br />";
		case "|":
		case "separator":
			return '<img src="' + this.baseURL + 'images/spacer.gif" width="1" height="15" class="editAreaSeparatorLine">';
		case "select_font":
			html = "<select id='area_font_size' onchange='javascript:editArea.execCommand(\"change_font_size\")' fileSpecific='yes'>" + "<option value='-1'>{$font_size}</option>" + "<option value='8'>8 pt</option>" + "<option value='9'>9 pt</option>" + "<option value='10'>10 pt</option>" + "<option value='11'>11 pt</option>" + "<option value='12'>12 pt</option>" + "<option value='14'>14 pt</option>" + "</select>";
			return html;
		case "syntax_selection":
			var html = "<select id='syntax_selection' onchange='javascript:editArea.execCommand(\"change_syntax\",this.value)' fileSpecific='yes'>";
			html += "<option value='-1'>{$syntax_selection}</option>";
			html += "</select>";
			return html;
	}
	return "<span id='tmp_tool_" + button_name + "'>[" + button_name + "]</span>";
},get_template:function() {
	if (this.template == "") {
		var xhr_object = null;
		if (window.XMLHttpRequest)xhr_object = new XMLHttpRequest();
		else if (window.ActiveXObject)xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
		else {
			alert("XMLHTTPRequest not supported. EditArea not loaded");
			return;
		}
		xhr_object.open("GET", this.baseURL + "template.html", false);
		xhr_object.send(null);
		if (xhr_object.readyState == 4)this.template = xhr_object.responseText;
		else this.has_error();
	}
},translate:function(text, lang, mode) {
	if (mode == "word")text = eAL.get_word_translation(text, lang);
	else if (mode = "template") {
		eAL.current_language = lang;
		text = text.replace(/\{\$([^\}]+)\}/gm, eAL.translate_template);
	}
	return text;
},translate_template:function() {
	return eAL.get_word_translation(EAL.prototype.translate_template.arguments[1], eAL.current_language);
},get_word_translation:function(val, lang) {
	for (var i in eAL.lang[lang]) {
		if (i == val)return eAL.lang[lang][i];
	}
	return "_" + val;
},load_script:function(url) {
	if (this.loadedFiles[url])return;
	try {
		var script = document.createElement("script");
		script.type = "text/javascript";
		script.src = url;
		script.charset = "UTF-8";
		var head = document.getElementsByTagName("head");
		head[0].appendChild(script);
	} catch(e) {
		document.write('<sc' + 'ript language="javascript" type="text/javascript" src="' + url + '" charset="UTF-8"></sc' + 'ript>');
	}
	this.loadedFiles[url] = true;
},add_event:function(obj, name, handler) {
	if (obj.attachEvent) {
		obj.attachEvent("on" + name, handler);
	}
	else {
		obj.addEventListener(name, handler, false);
	}
},remove_event:function(obj, name, handler) {
	if (obj.detachEvent)obj.detachEvent("on" + name, handler);
	else obj.removeEventListener(name, handler, false);
},reset:function(e) {
	var formObj = eAL.nav['isIE'] ? window.event.srcElement : e.target;
	if (formObj.tagName != 'FORM')formObj = formObj.form;
	for (var i in eAs) {
		var is_child = false;
		for (var x = 0; x < formObj.elements.length; x++) {
			if (formObj.elements[x].id == i)is_child = true;
		}
		if (window.frames["frame_" + i] && is_child && eAs[i]["displayed"] == true) {
			var exec = 'window.frames["frame_' + i + '"].editArea.textarea.value=document.getElementById("' + i + '").value;';
			exec += 'window.frames["frame_' + i + '"].editArea.execCommand("focus");';
			exec += 'window.frames["frame_' + i + '"].editArea.check_line_selection();';
			exec += 'window.frames["frame_' + i + '"].editArea.execCommand("reset");';
			window.setTimeout(exec, 10);
		}
	}
	return;
},submit:function(e) {
	var formObj = eAL.nav['isIE'] ? window.event.srcElement : e.target;
	if (formObj.tagName != 'FORM')formObj = formObj.form;
	for (var i in eAs) {
		var is_child = false;
		for (var x = 0; x < formObj.elements.length; x++) {
			if (formObj.elements[x].id == i)is_child = true;
		}
		if (is_child) {
			if (window.frames["frame_" + i] && eAs[i]["displayed"] == true)document.getElementById(i).value = window.frames["frame_" + i].editArea.textarea.value;
			eAL.execCommand(i, "EA_submit");
		}
	}
	if (typeof(formObj.edit_area_replaced_submit) == "function") {
		res = formObj.edit_area_replaced_submit();
		if (res == false) {
			if (eAL.nav['isIE'])return false;
			else e.preventDefault();
		}
	}
	return;
},getValue:function(id) {
	if (window.frames["frame_" + id] && eAs[id]["displayed"] == true) {
		return window.frames["frame_" + id].editArea.textarea.value;
	}
	else if (elem = document.getElementById(id)) {
		return elem.value;
	}
	return false;
},setValue:function(id, new_val) {
	if (window.frames["frame_" + id] && eAs[id]["displayed"] == true) {
		window.frames["frame_" + id].editArea.textarea.value = new_val;
		window.frames["frame_" + id].editArea.execCommand("focus");
		window.frames["frame_" + id].editArea.check_line_selection(false);
		window.frames["frame_" + id].editArea.execCommand("onchange");
	}
	else if (elem = document.getElementById(id)) {
		elem.value = new_val;
	}
},getSelectionRange:function(id) {
	var sel = {"start":0,"end":0};
	if (window.frames["frame_" + id] && eAs[id]["displayed"] == true) {
		var editArea = window.frames["frame_" + id].editArea;
		sel["start"] = editArea.textarea.selectionStart;
		sel["end"] = editArea.textarea.selectionEnd;
	}
	else if (elem = document.getElementById(id)) {
		sel = getSelectionRange(elem);
	}
	return sel;
},setSelectionRange:function(id, new_start, new_end) {
	if (window.frames["frame_" + id] && eAs[id]["displayed"] == true) {
		window.frames["frame_" + id].editArea.area_select(new_start, new_end - new_start);
		if (!this.nav['isIE']) {
			window.frames["frame_" + id].editArea.check_line_selection(false);
			window.frames["frame_" + id].editArea.scroll_to_view();
		}
	}
	else if (elem = document.getElementById(id)) {
		setSelectionRange(elem, new_start, new_end);
	}
},getSelectedText:function(id) {
	var sel = this.getSelectionRange(id);
	return this.getValue(id).substring(sel["start"], sel["end"]);
},setSelectedText:function(id, new_val) {
	new_val = new_val.replace(/\r/g, "");
	var sel = this.getSelectionRange(id);
	var text = this.getValue(id);
	if (window.frames["frame_" + id] && eAs[id]["displayed"] == true) {
		var scrollTop = window.frames["frame_" + id].document.getElementById("result").scrollTop;
		var scrollLeft = window.frames["frame_" + id].document.getElementById("result").scrollLeft;
	}
	else {
		var scrollTop = document.getElementById(id).scrollTop;
		var scrollLeft = document.getElementById(id).scrollLeft;
	}
	text = text.substring(0, sel["start"]) + new_val + text.substring(sel["end"]);
	this.setValue(id, text);
	var new_sel_end = sel["start"] + new_val.length;
	this.setSelectionRange(id, sel["start"], new_sel_end);
	if (new_val != this.getSelectedText(id).replace(/\r/g, "")) {
		this.setSelectionRange(id, sel["start"], new_sel_end + new_val.split("\n").length - 1);
	}
	if (window.frames["frame_" + id] && eAs[id]["displayed"] == true) {
		window.frames["frame_" + id].document.getElementById("result").scrollTop = scrollTop;
		window.frames["frame_" + id].document.getElementById("result").scrollLeft = scrollLeft;
		window.frames["frame_" + id].editArea.execCommand("onchange");
	}
	else {
		document.getElementById(id).scrollTop = scrollTop;
		document.getElementById(id).scrollLeft = scrollLeft;
	}
},insertTags:function(id, open_tag, close_tag) {
	var old_sel = this.getSelectionRange(id);
	text = open_tag + this.getSelectedText(id) + close_tag;
	eAL.setSelectedText(id, text);
	var new_sel = this.getSelectionRange(id);
	if (old_sel["end"] > old_sel["start"])this.setSelectionRange(id, new_sel["end"], new_sel["end"]);
	else this.setSelectionRange(id, old_sel["start"] + open_tag.length, old_sel["start"] + open_tag.length);
},hide:function(id) {
	if (document.getElementById(id) && !this.hidden[id]) {
		this.hidden[id] = new Object();
		this.hidden[id]["selectionRange"] = this.getSelectionRange(id);
		if (document.getElementById(id).style.display != "none") {
			this.hidden[id]["scrollTop"] = document.getElementById(id).scrollTop;
			this.hidden[id]["scrollLeft"] = document.getElementById(id).scrollLeft;
		}
		if (window.frames["frame_" + id]) {
			this.hidden[id]["toggle"] = eAs[id]["displayed"];
			if (window.frames["frame_" + id] && eAs[id]["displayed"] == true) {
				var scrollTop = window.frames["frame_" + id].document.getElementById("result").scrollTop;
				var scrollLeft = window.frames["frame_" + id].document.getElementById("result").scrollLeft;
			}
			else {
				var scrollTop = document.getElementById(id).scrollTop;
				var scrollLeft = document.getElementById(id).scrollLeft;
			}
			this.hidden[id]["scrollTop"] = scrollTop;
			this.hidden[id]["scrollLeft"] = scrollLeft;
			if (eAs[id]["displayed"] == true)eAL.toggle_off(id);
		}
		var span = document.getElementById("EditAreaArroundInfos_" + id);
		if (span) {
			span.style.display = 'none';
		}
		document.getElementById(id).style.display = "none";
	}
},show:function(id) {
	if ((elem = document.getElementById(id)) && this.hidden[id]) {
		elem.style.display = "inline";
		elem.scrollTop = this.hidden[id]["scrollTop"];
		elem.scrollLeft = this.hidden[id]["scrollLeft"];
		var span = document.getElementById("EditAreaArroundInfos_" + id);
		if (span) {
			span.style.display = 'inline';
		}
		if (window.frames["frame_" + id]) {
			elem.style.display = "inline";
			if (this.hidden[id]["toggle"] == true)eAL.toggle_on(id);
			scrollTop = this.hidden[id]["scrollTop"];
			scrollLeft = this.hidden[id]["scrollLeft"];
			if (window.frames["frame_" + id] && eAs[id]["displayed"] == true) {
				window.frames["frame_" + id].document.getElementById("result").scrollTop = scrollTop;
				window.frames["frame_" + id].document.getElementById("result").scrollLeft = scrollLeft;
			}
			else {
				elem.scrollTop = scrollTop;
				elem.scrollLeft = scrollLeft;
			}
		}
		sel = this.hidden[id]["selectionRange"];
		this.setSelectionRange(id, sel["start"], sel["end"]);
		delete this.hidden[id];
	}
},getCurrentFile:function(id) {
	return this.execCommand(id, 'get_file', this.execCommand(id, 'curr_file'));
},getFile:function(id, file_id) {
	return this.execCommand(id, 'get_file', file_id);
},getAllFiles:function(id) {
	return this.execCommand(id, 'get_all_files()');
},openFile:function(id, file_infos) {
	return this.execCommand(id, 'open_file', file_infos);
},closeFile:function(id, file_id) {
	return this.execCommand(id, 'close_file', file_id);
},setFileEditedMode:function(id, file_id, to) {
	var reg1 = new RegExp('\\\\', 'g');
	var reg2 = new RegExp('"', 'g');
	return this.execCommand(id, 'set_file_edited_mode("' + file_id.replace(reg1, '\\\\').replace(reg2, '\\"') + '",' + to + ')');
},execCommand:function(id, cmd, fct_param) {
	switch (cmd) {
		case "EA_init":
			if (eAs[id]['settings']["EA_init_callback"].length > 0)eval(eAs[id]['settings']["EA_init_callback"] + "('" + id + "');");
			break;
		case "EA_delete":
			if (eAs[id]['settings']["EA_delete_callback"].length > 0)eval(eAs[id]['settings']["EA_delete_callback"] + "('" + id + "');");
			break;
		case "EA_submit":
			if (eAs[id]['settings']["submit_callback"].length > 0)eval(eAs[id]['settings']["submit_callback"] + "('" + id + "');");
			break;
	}
	if (window.frames["frame_" + id] && window.frames["frame_" + id].editArea) {
		if (fct_param != undefined)return eval('window.frames["frame_' + id + '"].editArea.' + cmd + '(fct_param);');
		else return eval('window.frames["frame_' + id + '"].editArea.' + cmd + ';');
	}
	return false;
}};
var eAL = new EAL();
var eAs = new Object();
function getAttribute(elm, aname) {
	try {
		var avalue = elm.getAttribute(aname);
	} catch(exept) {
	}
	if (! avalue) {
		for (var i = 0; i < elm.attributes.length; i ++) {
			var taName = elm.attributes [i].name.toLowerCase();
			if (taName == aname) {
				avalue = elm.attributes [i].value;
				return avalue;
			}
		}
	}
	return avalue;
}
;
function setAttribute(elm, attr, val) {
	if (attr == "class") {
		elm.setAttribute("className", val);
		elm.setAttribute("class", val);
	}
	else {
		elm.setAttribute(attr, val);
	}
}
;
function getChildren(elem, elem_type, elem_attribute, elem_attribute_match, option, depth) {
	if (!option)var option = "single";
	if (!depth)var depth = -1;
	if (elem) {
		var children = elem.childNodes;
		var result = null;
		var results = new Array();
		for (var x = 0; x < children.length; x++) {
			strTagName = new String(children[x].tagName);
			children_class = "?";
			if (strTagName != "undefined") {
				child_attribute = getAttribute(children[x], elem_attribute);
				if ((strTagName.toLowerCase() == elem_type.toLowerCase() || elem_type == "") && (elem_attribute == "" || child_attribute == elem_attribute_match)) {
					if (option == "all") {
						results.push(children[x]);
					}
					else {
						return children[x];
					}
				}
				if (depth != 0) {
					result = getChildren(children[x], elem_type, elem_attribute, elem_attribute_match, option, depth - 1);
					if (option == "all") {
						if (result.length > 0) {
							results = results.concat(result);
						}
					}
					else if (result != null) {
						return result;
					}
				}
			}
		}
		if (option == "all")return results;
	}
	return null;
}
;
function isChildOf(elem, parent) {
	if (elem) {
		if (elem == parent)return true;
		while (elem.parentNode != 'undefined') {
			return isChildOf(elem.parentNode, parent);
		}
	}
	return false;
}
;
function getMouseX(e) {
	if (e != null && typeof(e.pageX) != "undefined") {
		return e.pageX;
	}
	else {
		return (e != null ? e.x : event.x) + document.documentElement.scrollLeft;
	}
}
;
function getMouseY(e) {
	if (e != null && typeof(e.pageY) != "undefined") {
		return e.pageY;
	}
	else {
		return (e != null ? e.y : event.y) + document.documentElement.scrollTop;
	}
}
;
function calculeOffsetLeft(r) {
	return calculeOffset(r, "offsetLeft")
}
;
function calculeOffsetTop(r) {
	return calculeOffset(r, "offsetTop")
}
;
function calculeOffset(element, attr) {
	var offset = 0;
	while (element) {
		offset += element[attr];
		element = element.offsetParent
	}
	return offset;
}
;
function get_css_property(elem, prop) {
	if (document.defaultView) {
		return document.defaultView.getComputedStyle(elem, null).getPropertyValue(prop);
	}
	else if (elem.currentStyle) {
		var prop = prop.replace(/-\D/gi, function(sMatch) {
			return sMatch.charAt(sMatch.length - 1).toUpperCase();
		});
		return elem.currentStyle[prop];
	}
	else return null;
}
var move_current_element;
function start_move_element(e, id, frame) {
	var elem_id = (e.target || e.srcElement).id;
	if (id)elem_id = id;
	if (!frame)frame = window;
	if (frame.event)e = frame.event;
	move_current_element = frame.document.getElementById(elem_id);
	move_current_element.frame = frame;
	frame.document.onmousemove = move_element;
	frame.document.onmouseup = end_move_element;
	mouse_x = getMouseX(e);
	mouse_y = getMouseY(e);
	move_current_element.start_pos_x = mouse_x - (move_current_element.style.left.replace("px", "") || calculeOffsetLeft(move_current_element));
	move_current_element.start_pos_y = mouse_y - (move_current_element.style.top.replace("px", "") || calculeOffsetTop(move_current_element));
	return false;
}
;
function end_move_element(e) {
	move_current_element.frame.document.onmousemove = "";
	move_current_element.frame.document.onmouseup = "";
	move_current_element = null;
}
;
function move_element(e) {
	if (move_current_element.frame && move_current_element.frame.event)e = move_current_element.frame.event;
	var mouse_x = getMouseX(e);
	var mouse_y = getMouseY(e);
	var new_top = mouse_y - move_current_element.start_pos_y;
	var new_left = mouse_x - move_current_element.start_pos_x;
	var max_left = move_current_element.frame.document.body.offsetWidth - move_current_element.offsetWidth;
	max_top = move_current_element.frame.document.body.offsetHeight - move_current_element.offsetHeight;
	new_top = Math.min(Math.max(0, new_top), max_top);
	new_left = Math.min(Math.max(0, new_left), max_left);
	move_current_element.style.top = new_top + "px";
	move_current_element.style.left = new_left + "px";
	return false;
}
;
var nav = eAL.nav;
function getSelectionRange(textarea) {
	return {"start":textarea.selectionStart,"end":textarea.selectionEnd};
}
;
function setSelectionRange(textarea, start, end) {
	textarea.focus();
	start = Math.max(0, Math.min(textarea.value.length, start));
	end = Math.max(start, Math.min(textarea.value.length, end));
	if (nav['isOpera']) {
		textarea.selectionEnd = 1;
		textarea.selectionStart = 0;
		textarea.selectionEnd = 1;
		textarea.selectionStart = 0;
	}
	textarea.selectionStart = start;
	textarea.selectionEnd = end;
	if (nav['isIE'])set_IE_selection(textarea);
}
;
function get_IE_selection(textarea) {
	if (textarea && textarea.focused) {
		if (!textarea.ea_line_height) {
			var div = document.createElement("div");
			div.style.fontFamily = get_css_property(textarea, "font-family");
			div.style.fontSize = get_css_property(textarea, "font-size");
			div.style.visibility = "hidden";
			div.innerHTML = "0";
			document.body.appendChild(div);
			textarea.ea_line_height = div.offsetHeight;
			document.body.removeChild(div);
		}
		var range = document.selection.createRange();
		var stored_range = range.duplicate();
		stored_range.moveToElementText(textarea);
		stored_range.setEndPoint('EndToEnd', range);
		if (stored_range.parentElement() == textarea) {
			var elem = textarea;
			var scrollTop = 0;
			while (elem.parentNode) {
				scrollTop += elem.scrollTop;
				elem = elem.parentNode;
			}
			var relative_top = range.offsetTop - calculeOffsetTop(textarea) + scrollTop;
			var line_start = Math.round((relative_top / textarea.ea_line_height) + 1);
			var line_nb = Math.round(range.boundingHeight / textarea.ea_line_height);
			var range_start = stored_range.text.length - range.text.length;
			var tab = textarea.value.substr(0, range_start).split("\n");
			range_start += (line_start - tab.length) * 2;
			textarea.selectionStart = range_start;
			var range_end = textarea.selectionStart + range.text.length;
			tab = textarea.value.substr(0, range_start + range.text.length).split("\n");
			range_end += (line_start + line_nb - 1 - tab.length) * 2;
			textarea.selectionEnd = range_end;
		}
	}
	setTimeout("get_IE_selection(document.getElementById('" + textarea.id + "'));", 50);
}
;
function IE_textarea_focus() {
	event.srcElement.focused = true;
}
function IE_textarea_blur() {
	event.srcElement.focused = false;
}
function set_IE_selection(textarea) {
	if (!window.closed) {
		var nbLineStart = textarea.value.substr(0, textarea.selectionStart).split("\n").length - 1;
		var nbLineEnd = textarea.value.substr(0, textarea.selectionEnd).split("\n").length - 1;
		var range = document.selection.createRange();
		range.moveToElementText(textarea);
		range.setEndPoint('EndToStart', range);
		range.moveStart('character', textarea.selectionStart - nbLineStart);
		range.moveEnd('character', textarea.selectionEnd - nbLineEnd - (textarea.selectionStart - nbLineStart));
		range.select();
	}
}
;
eAL.waiting_loading["elements_functions.js"] = "loaded";
EAL.prototype.start_resize_area = function() {
	document.onmouseup = eAL.end_resize_area;
	document.onmousemove = eAL.resize_area;
	eAL.toggle(eAL.resize["id"]);
	var textarea = eAs[eAL.resize["id"]]["textarea"];
	var div = document.getElementById("edit_area_resize");
	if (!div) {
		div = document.createElement("div");
		div.id = "edit_area_resize";
		div.style.border = "dashed #888888 1px";
	}
	var width = textarea.offsetWidth - 2;
	var height = textarea.offsetHeight - 2;
	div.style.display = "block";
	div.style.width = width + "px";
	div.style.height = height + "px";
	var father = textarea.parentNode;
	father.insertBefore(div, textarea);
	textarea.style.display = "none";
	eAL.resize["start_top"] = calculeOffsetTop(div);
	eAL.resize["start_left"] = calculeOffsetLeft(div);
};
EAL.prototype.end_resize_area = function(e) {
	document.onmouseup = "";
	document.onmousemove = "";
	var div = document.getElementById("edit_area_resize");
	var textarea = eAs[eAL.resize["id"]]["textarea"];
	var width = Math.max(eAs[eAL.resize["id"]]["settings"]["min_width"], div.offsetWidth - 4);
	var height = Math.max(eAs[eAL.resize["id"]]["settings"]["min_height"], div.offsetHeight - 4);
	if (eAL.nav['isIE'] == 6) {
		width -= 2;
		height -= 2;
	}
	textarea.style.width = width + "px";
	textarea.style.height = height + "px";
	div.style.display = "none";
	textarea.style.display = "inline";
	textarea.selectionStart = eAL.resize["selectionStart"];
	textarea.selectionEnd = eAL.resize["selectionEnd"];
	eAL.toggle(eAL.resize["id"]);
	return false;
};
EAL.prototype.resize_area = function(e) {
	var allow = eAs[eAL.resize["id"]]["settings"]["allow_resize"];
	if (allow == "both" || allow == "y") {
		new_y = getMouseY(e);
		var new_height = Math.max(20, new_y - eAL.resize["start_top"]);
		document.getElementById("edit_area_resize").style.height = new_height + "px";
	}
	if (allow == "both" || allow == "x") {
		new_x = getMouseX(e);
		var new_width = Math.max(20, new_x - eAL.resize["start_left"]);
		document.getElementById("edit_area_resize").style.width = new_width + "px";
	}
	return false;
};
eAL.waiting_loading["resize_area.js"] = "loaded";
EAL.prototype.get_regexp = function(text_array) {
	res = "(\\b)(";
	for (i = 0; i < text_array.length; i++) {
		if (i > 0)res += "|";
		res += this.get_escaped_regexp(text_array[i]);
	}
	res += ")(\\b)";
	reg = new RegExp(res);
	return res;
};
EAL.prototype.get_escaped_regexp = function(str) {
	return str.replace(/(\.|\?|\*|\+|\\|\(|\)|\[|\]|\}|\{|\$|\^|\|)/g, "\\$1");
};
EAL.prototype.init_syntax_regexp = function() {
	var lang_style = new Object();
	for (var lang in this.load_syntax) {
		if (!this.syntax[lang]) {
			this.syntax[lang] = new Object();
			this.syntax[lang]["keywords_reg_exp"] = new Object();
			this.keywords_reg_exp_nb = 0;
			if (this.load_syntax[lang]['KEYWORDS']) {
				param = "g";
				if (this.load_syntax[lang]['KEYWORD_CASE_SENSITIVE'] === false)param += "i";
				for (var i in this.load_syntax[lang]['KEYWORDS']) {
					if (typeof(this.load_syntax[lang]['KEYWORDS'][i]) == "function")continue;
					this.syntax[lang]["keywords_reg_exp"][i] = new RegExp(this.get_regexp(this.load_syntax[lang]['KEYWORDS'][i]), param);
					this.keywords_reg_exp_nb++;
				}
			}
			if (this.load_syntax[lang]['OPERATORS']) {
				var str = "";
				var nb = 0;
				for (var i in this.load_syntax[lang]['OPERATORS']) {
					if (typeof(this.load_syntax[lang]['OPERATORS'][i]) == "function")continue;
					if (typeof(this.load_syntax[lang]['OPERATORS'][i].replace) != 'function') continue;
					if (nb > 0)str += "|";
					str += this.get_escaped_regexp(this.load_syntax[lang]['OPERATORS'][i]);
					nb++;
				}
				if (str.length > 0)this.syntax[lang]["operators_reg_exp"] = new RegExp("(" + str + ")", "g");
			}
			if (this.load_syntax[lang]['DELIMITERS']) {
				var str = "";
				var nb = 0;
				for (var i in this.load_syntax[lang]['DELIMITERS']) {
					if (typeof(this.load_syntax[lang]['DELIMITERS'][i]) == "function")continue;
					if (typeof(this.load_syntax[lang]['DELIMITERS'][i].replace) != 'function') continue;
					if (nb > 0)str += "|";
					str += this.get_escaped_regexp(this.load_syntax[lang]['DELIMITERS'][i]);
					nb++;
				}
				if (str.length > 0)this.syntax[lang]["delimiters_reg_exp"] = new RegExp("(" + str + ")", "g");
			}
			var syntax_trace = new Array();
			this.syntax[lang]["quotes"] = new Object();
			var quote_tab = new Array();
			if (this.load_syntax[lang]['QUOTEMARKS']) {
				for (var i in this.load_syntax[lang]['QUOTEMARKS']) {
					if (typeof(this.load_syntax[lang]['QUOTEMARKS'][i]) == "function")continue;
					if (typeof(this.load_syntax[lang]['QUOTEMARKS'][i].replace) != 'function') continue;
					var x = this.get_escaped_regexp(this.load_syntax[lang]['QUOTEMARKS'][i]);
					this.syntax[lang]["quotes"][x] = x;
					quote_tab[quote_tab.length] = "(" + x + "(?:[^" + x + "\\\\]*(\\\\\\\\)*(\\\\" + x + "?)?)*(" + x + "|$))";
					syntax_trace.push(x);
				}
			}
			this.syntax[lang]["comments"] = new Object();
			if (this.load_syntax[lang]['COMMENT_SINGLE']) {
				for (var i in this.load_syntax[lang]['COMMENT_SINGLE']) {
					if (typeof(this.load_syntax[lang]['COMMENT_SINGLE'][i]) == "function")continue;
					var x = this.get_escaped_regexp(this.load_syntax[lang]['COMMENT_SINGLE'][i]);
					quote_tab[quote_tab.length] = "(" + x + "(.|\\r|\\t)*(\\n|$))";
					syntax_trace.push(x);
					this.syntax[lang]["comments"][x] = "\n";
				}
			}
			if (this.load_syntax[lang]['COMMENT_MULTI']) {
				for (var i in this.load_syntax[lang]['COMMENT_MULTI']) {
					if (typeof(this.load_syntax[lang]['COMMENT_MULTI'][i]) == "function")continue;
					var start = this.get_escaped_regexp(i);
					var end = this.get_escaped_regexp(this.load_syntax[lang]['COMMENT_MULTI'][i]);
					quote_tab[quote_tab.length] = "(" + start + "(.|\\n|\\r)*?(" + end + "|$))";
					syntax_trace.push(start);
					syntax_trace.push(end);
					this.syntax[lang]["comments"][i] = this.load_syntax[lang]['COMMENT_MULTI'][i];
				}
			}
			if (quote_tab.length > 0)this.syntax[lang]["comment_or_quote_reg_exp"] = new RegExp("(" + quote_tab.join("|") + ")", "gi");
			if (syntax_trace.length > 0)this.syntax[lang]["syntax_trace_regexp"] = new RegExp("((.|\n)*?)(\\\\*(" + syntax_trace.join("|") + "|$))", "gmi");
			if (this.load_syntax[lang]['SCRIPT_DELIMITERS']) {
				this.syntax[lang]["script_delimiters"] = new Object();
				for (var i in this.load_syntax[lang]['SCRIPT_DELIMITERS']) {
					if (typeof(this.load_syntax[lang]['SCRIPT_DELIMITERS'][i]) == "function")continue;
					this.syntax[lang]["script_delimiters"][i] = this.load_syntax[lang]['SCRIPT_DELIMITERS'];
				}
			}
			this.syntax[lang]["custom_regexp"] = new Object();
			if (this.load_syntax[lang]['REGEXPS']) {
				for (var i in this.load_syntax[lang]['REGEXPS']) {
					if (typeof(this.load_syntax[lang]['REGEXPS'][i]) == "function")continue;
					var val = this.load_syntax[lang]['REGEXPS'][i];
					if (!this.syntax[lang]["custom_regexp"][val['execute']])this.syntax[lang]["custom_regexp"][val['execute']] = new Object();
					this.syntax[lang]["custom_regexp"][val['execute']][i] = {'regexp':new RegExp(val['search'], val['modifiers']),'class':val['class']};
				}
			}
			if (this.load_syntax[lang]['STYLES']) {
				lang_style[lang] = new Object();
				for (var i in this.load_syntax[lang]['STYLES']) {
					if (typeof(this.load_syntax[lang]['STYLES'][i]) == "function")continue;
					if (typeof(this.load_syntax[lang]['STYLES'][i]) != "string") {
						for (var j in this.load_syntax[lang]['STYLES'][i]) {
							lang_style[lang][j] = this.load_syntax[lang]['STYLES'][i][j];
						}
					}
					else {
						lang_style[lang][i] = this.load_syntax[lang]['STYLES'][i];
					}
				}
			}
			var style = "";
			for (var i in lang_style[lang]) {
				if (lang_style[lang][i].length > 0) {
					style += "." + lang + " ." + i.toLowerCase() + " span{" + lang_style[lang][i] + "}\n";
					style += "." + lang + " ." + i.toLowerCase() + "{" + lang_style[lang][i] + "}\n";
				}
			}
			this.syntax[lang]["styles"] = style;
		}
	}
};
eAL.waiting_loading["reg_syntax.js"] = "loaded";
var editAreaLoader = eAL;
var editAreas = eAs;
EditAreaLoader = EAL;
editAreaLoader.iframe_script = "<script type='text/javascript'> Ã EA(){Á.error=Ì;Á.inlinePopup=new Array({popup_id:\"area_search_replace\",icon_id:\"search\"},{popup_id:\"edit_area_help\",icon_id:\"help\"});Á.plugins=new Object();Á.line_number=0;Á.nav=È.eAL.nav;Á.É=new Object();Á.last_text_to_highlight=\"\";Á.last_hightlighted_text=\"\";Á.syntax_list=new Array();Á.allready_used_syntax=new Object();Á.check_line_selection_timer=50;Á.ÂFocused=Ì;Á.highlight_selection_line=null;Á.previous=new Array();Á.next=new Array();Á.last_undo=\"\";Á.files=new Object();Á.filesIdAssoc=new Object();Á.curr_file='';Á.assocBracket=new Object();Á.revertAssocBracket=new Object();Á.assocBracket[\"(\"]=\")\";Á.assocBracket[\"{\"]=\"}\";Á.assocBracket[\"[\"]=\"]\";for(var index in Á.assocBracket){Á.revertAssocBracket[Á.assocBracket[index]]=index;}Á.is_editable=Ë;Á.lineHeight=16;Á.tab_nb_char=8;if(Á.nav['isOpera'])Á.tab_nb_char=6;Á.is_tabbing=Ì;Á.fullscreen={'isFull':Ì};Á.isResizing=Ì;Á.id=area_id;Á.Å=eAs[Á.id][\"Å\"];if((\"\"+Á.Å['replace_tab_by_spaces']).match(/^[0-9]+$/)){Á.tab_nb_char=Á.Å['replace_tab_by_spaces'];Á.tabulation=\"\";for(var i=0;i<Á.tab_nb_char;i++)Á.tabulation+=\" \";}\nelse{Á.tabulation=\"\t\";}if(Á.Å[\"syntax_selection_allow\"]&&Á.Å[\"syntax_selection_allow\"].Æ>0)Á.syntax_list=Á.Å[\"syntax_selection_allow\"].replace(/ /g,\"\").split(\",\");if(Á.Å['syntax'])Á.allready_used_syntax[Á.Å['syntax']]=Ë;};EA.Ä.update_size=Ã(){if(eAs[eA.id]&&eAs[eA.id][\"displayed\"]==Ë){if(eA.fullscreen['isFull']){È.document.getElementById(\"frame_\"+eA.id).Ç.width=È.document.getElementsByTagName(\"html\")[0].clientWidth+\"px\";È.document.getElementById(\"frame_\"+eA.id).Ç.height=È.document.getElementsByTagName(\"html\")[0].clientHeight+\"px\";}if(eA.tab_browsing_area.Ç.display=='block'&&!eA.nav['isIE']){eA.tab_browsing_area.Ç.height=\"0px\";eA.tab_browsing_area.Ç.height=(eA.result.offsetTop-eA.tab_browsing_area.offsetTop -1)+\"px\";}var height=document.body.offsetHeight-eA.get_all_toolbar_height()-4;eA.result.Ç.height=height +\"px\";var width=document.body.offsetWidth -2;eA.result.Ç.width=width+\"px\";for(var i=0;i<eA.inlinePopup.Æ;i++){var popup=$(eA.inlinePopup[i][\"popup_id\"]);var max_left=document.body.offsetWidth-popup.offsetWidth;var max_top=document.body.offsetHeight-popup.offsetHeight;if(popup.offsetTop>max_top)popup.Ç.top=max_top+\"px\";if(popup.offsetLeft>max_left)popup.Ç.left=max_left+\"px\";}}};EA.Ä.init=Ã(){Á.Â=$(\"Â\");Á.container=$(\"container\");Á.result=$(\"result\");Á.content_highlight=$(\"content_highlight\");Á.selection_field=$(\"selection_field\");Á.processing_screen=$(\"processing\");Á.editor_area=$(\"editor\");Á.tab_browsing_area=$(\"tab_browsing_area\");if(!Á.Å['is_editable'])Á.set_editable(Ì);Á.set_show_line_colors(Á.Å['show_line_colors'] );if(syntax_selec=$(\"syntax_selection\")){for(var i=0;i<Á.syntax_list.Æ;i++){var syntax=Á.syntax_list[i];var option=document.createElement(\"option\");option.Ê=syntax;if(syntax==Á.Å['syntax'])option.selected=\"selected\";option.innerHTML=Á.get_translation(\"syntax_\"+syntax,\"word\");syntax_selec.appendChild(option);}}spans=È.getChildren($(\"toolbar_1\"),\"span\",\"\",\"\",\"all\",-1);for(var i=0;i<spans.Æ;i++){id=spans[i].id.replace(/tmp_tool_(.*)/,\"$1\");if(id!=spans[i].id){for(var j in Á.plugins){if(typeof(Á.plugins[j].get_control_html)==\"Ã\" ){html=Á.plugins[j].get_control_html(id);if(html!=Ì){html=Á.get_translation(html,\"template\");var new_span=document.createElement(\"span\");new_span.innerHTML=html;var father=spans[i].ÈNode;spans[i].ÈNode.replaceChild(new_span,spans[i]);break;}}}}}Á.Â.Ê=eAs[Á.id][\"Â\"].Ê;if(Á.Å[\"debug\"])Á.debug=È.document.getElementById(\"edit_area_debug_\"+Á.id);if($(\"redo\")!=null)Á.switchClassSticky($(\"redo\"),'editAreaButtonDisabled',Ë);if(typeof(È.eAL.syntax[Á.Å[\"syntax\"]])!=\"undefined\"){for(var i in È.eAL.syntax){Á.add_Ç(È.eAL.syntax[i][\"Çs\"]);}}if(Á.nav['isOpera'])$(\"editor\").onkeypress=keyDown;\nelse $(\"editor\").onkeydown=keyDown;for(var i=0;i<Á.inlinePopup.Æ;i++){if(Á.nav['isIE']||Á.nav['isFirefox'])$(Á.inlinePopup[i][\"popup_id\"]).onkeydown=keyDown;\nelse $(Á.inlinePopup[i][\"popup_id\"]).onkeypress=keyDown;}if(Á.Å[\"allow_resize\"]==\"both\"||Á.Å[\"allow_resize\"]==\"x\"||Á.Å[\"allow_resize\"]==\"y\")Á.allow_resize(Ë);È.eAL.toggle(Á.id,\"on\");Á.change_smooth_selection_mode(eA.smooth_selection);Á.execCommand(\"change_highlight\",Á.Å[\"start_highlight\"]);Á.set_font(eA.Å[\"font_family\"],eA.Å[\"font_size\"]);children=È.getChildren(document.body,\"\",\"selec\",\"none\",\"all\",-1);for(var i=0;i<children.Æ;i++){if(Á.nav['isIE'])children[i].unselectable=Ë;\nelse children[i].onmousedown=Ã(){return Ì};}if(Á.nav['isGecko']){Á.Â.spellcheck=Á.Å[\"gecko_spellcheck\"];}if(Á.nav['isFirefox'] >='3')Á.content_highlight.Ç.borderLeft=\"solid 1px transÈ\";if(Á.nav['isIE']&&Á.nav['isIE']<9){Á.Â.Ç.marginTop=\"-1px\";}if(!Á.nav['isIE'] || Á.nav['isIE']>=9){Á.Â.Ç.marginTop=\"0px\";}if(Á.nav['isSafari'] ){Á.editor_area.Ç.position=\"absolute\";Á.Â.Ç.marginLeft=\"-3px\";Á.Â.Ç.marginTop=\"1px\";}if(Á.nav['isChrome'] ){Á.editor_area.Ç.position=\"absolute\";Á.Â.Ç.marginLeft=\"0px\";Á.Â.Ç.marginTop=\"0px\";}È.eAL.add_event(Á.result,\"click\",Ã(e){if((e.target||e.srcElement)==eA.result){eA.area_select(eA.Â.Ê.Æ,0);}});if(Á.Å['is_multi_files']!=Ì)Á.open_file({'id':Á.curr_file,'text':''});Á.set_wrap_text(Á.Å['wrap_text'] );setTimeout(\"eA.focus();eA.manage_size();eA.execCommand('EA_load');\",10);Á.check_undo();Á.check_line_selection(Ë);Á.scroll_to_view();for(var i in Á.plugins){if(typeof(Á.plugins[i].onload)==\"Ã\")Á.plugins[i].onload();}if(Á.Å['fullscreen']==Ë)Á.toggle_full_screen(Ë);È.eAL.add_event(window,\"resize\",eA.update_size);È.eAL.add_event(È.window,\"resize\",eA.update_size);È.eAL.add_event(top.window,\"resize\",eA.update_size);È.eAL.add_event(window,\"unload\",Ã(){if(eAs[eA.id]&&eAs[eA.id][\"displayed\"])eA.execCommand(\"EA_unload\");});};EA.Ä.manage_size=Ã(onlyOneTime){if(!eAs[Á.id])return Ì;if(eAs[Á.id][\"displayed\"]==Ë&&Á.ÂFocused){var resized=Ì;if(Á.Å['wrap_text']){}\nelse{var area_width=Á.Â.scrollWidth;var area_height=Á.Â.scrollHeight;if(Á.nav['isOpera']){area_width=10000;}}if(Á.Â.previous_scrollWidth!=area_width){Á.container.Ç.width=area_width+\"px\";Á.Â.Ç.width=area_width+\"px\";Á.content_highlight.Ç.width=area_width+\"px\";Á.Â.previous_scrollWidth=area_width;resized=Ë;}var area_height=Á.Â.scrollHeight;if(Á.nav['isOpera']){area_height=Á.É['nb_line']*Á.lineHeight;}if(Á.nav['isGecko']&&Á.smooth_selection&&Á.É[\"nb_line\"])area_height=Á.É[\"nb_line\"]*Á.lineHeight;if(Á.Â.previous_scrollHeight!=area_height){Á.container.Ç.height=(area_height+2)+\"px\";Á.Â.Ç.height=area_height+\"px\";Á.content_highlight.Ç.height=area_height+\"px\";Á.Â.previous_scrollHeight=area_height;resized=Ë;}if(Á.É[\"nb_line\"] >=Á.line_number){var div_line_number=\"\";for(i=Á.line_number+1;i<Á.É[\"nb_line\"]+100;i++){div_line_number+=i+\"<br />\";Á.line_number++;}var span=document.createElement(\"span\");if(Á.nav['isIE'])span.unselectable=Ë;span.innerHTML=div_line_number;$(\"line_number\").appendChild(span);}Á.Â.scrollTop=\"0px\";Á.Â.scrollLeft=\"0px\";if(resized==Ë){Á.scroll_to_view();}}if(!onlyOneTime)setTimeout(\"eA.manage_size();\",100);};EA.Ä.add_event=Ã(obj,name,handler){if (Á.nav['isIE']){obj.attachEvent(\"on\"+name,handler);}\nelse{obj.addEventListener(name,handler,Ì);}};EA.Ä.execCommand=Ã(cmd,param){for(var i in Á.plugins){if(typeof(Á.plugins[i].execCommand)==\"Ã\"){if(!Á.plugins[i].execCommand(cmd,param))return;}}switch(cmd){case \"save\":if(Á.Å[\"save_callback\"].Æ>0)eval(\"È.\"+Á.Å[\"save_callback\"]+\"('\"+Á.id +\"',eA.Â.Ê);\");break;case \"load\":if(Á.Å[\"load_callback\"].Æ>0)eval(\"È.\"+Á.Å[\"load_callback\"]+\"('\"+Á.id +\"');\");break;case \"onchange\":if(Á.Å[\"change_callback\"].Æ>0)eval(\"È.\"+Á.Å[\"change_callback\"]+\"('\"+Á.id +\"');\");break;case \"EA_load\":if(Á.Å[\"EA_load_callback\"].Æ>0)eval(\"È.\"+Á.Å[\"EA_load_callback\"]+\"('\"+Á.id +\"');\");break;case \"EA_unload\":if(Á.Å[\"EA_unload_callback\"].Æ>0)eval(\"È.\"+Á.Å[\"EA_unload_callback\"]+\"('\"+Á.id +\"');\");break;case \"toggle_on\":if(Á.Å[\"EA_toggle_on_callback\"].Æ>0)eval(\"È.\"+Á.Å[\"EA_toggle_on_callback\"]+\"('\"+Á.id +\"');\");break;case \"toggle_off\":if(Á.Å[\"EA_toggle_off_callback\"].Æ>0)eval(\"È.\"+Á.Å[\"EA_toggle_off_callback\"]+\"('\"+Á.id +\"');\");break;case \"re_sync\":if(!Á.do_highlight)break;case \"file_switch_on\":if(Á.Å[\"EA_file_switch_on_callback\"].Æ>0)eval(\"È.\"+Á.Å[\"EA_file_switch_on_callback\"]+\"(param);\");break;case \"file_switch_off\":if(Á.Å[\"EA_file_switch_off_callback\"].Æ>0)eval(\"È.\"+Á.Å[\"EA_file_switch_off_callback\"]+\"(param);\");break;case \"file_close\":if(Á.Å[\"EA_file_close_callback\"].Æ>0)return eval(\"È.\"+Á.Å[\"EA_file_close_callback\"]+\"(param);\");break;default:if(typeof(eval(\"eA.\"+cmd))==\"Ã\"){if(Á.Å[\"debug\"])eval(\"eA.\"+cmd +\"(param);\");\nelse try{eval(\"eA.\"+cmd +\"(param);\");}catch(e){};}}};EA.Ä.get_translation=Ã(word,mode){if(mode==\"template\")return È.eAL.translate(word,Á.Å[\"language\"],mode);\nelse return È.eAL.get_word_translation(word,Á.Å[\"language\"]);};EA.Ä.add_plugin=Ã(plug_name,plug_obj){for(var i=0;i<Á.Å[\"plugins\"].Æ;i++){if(Á.Å[\"plugins\"][i]==plug_name){Á.plugins[plug_name]=plug_obj;plug_obj.baseURL=È.eAL.baseURL+\"plugins/\"+plug_name+\"/\";if(typeof(plug_obj.init)==\"Ã\")plug_obj.init();}}};EA.Ä.load_css=Ã(url){try{link=document.createElement(\"link\");link.type=\"text/css\";link.rel=\"Çsheet\";link.media=\"all\";link.href=url;head=document.getElementsByTagName(\"head\");head[0].appendChild(link);}catch(e){document.write(\"<link href='\"+url +\"' rel='Çsheet' type='text/css' />\");}};EA.Ä.load_script=Ã(url){try{script=document.createElement(\"script\");script.type=\"text/javascript\";script.src =url;script.charset=\"UTF-8\";head=document.getElementsByTagName(\"head\");head[0].appendChild(script);}catch(e){document.write(\"<script type='text/javascript' src='\"+url+\"' charset=\\\"UTF-8\\\"><\"+\"/script>\");}};EA.Ä.add_lang=Ã(language,Ês){if(!È.eAL.lang[language])È.eAL.lang[language]=new Object();for(var i in Ês)È.eAL.lang[language][i]=Ês[i];};Ã $(id){return document.getElementById(id );};var eA=new EA();eA.add_event(window,\"load\",init);Ã init(){setTimeout(\"eA.init();\",10);};	EA.Ä.focus=Ã(){Á.Â.focus();Á.ÂFocused=Ë;};EA.Ä.check_line_selection=Ã(timer_checkup){if(!eAs[Á.id])return Ì;if(!Á.smooth_selection&&!Á.do_highlight){}\nelse if(Á.ÂFocused&&eAs[Á.id][\"displayed\"]==Ë&&Á.isResizing==Ì){infos=Á.get_selection_infos();if(Á.É[\"line_start\"] !=infos[\"line_start\"]||Á.É[\"line_nb\"] !=infos[\"line_nb\"]||infos[\"full_text\"] !=Á.É[\"full_text\"]||Á.reload_highlight){new_top=Á.lineHeight * (infos[\"line_start\"]-1);new_height=Math.max(0,Á.lineHeight * infos[\"line_nb\"]);new_width=Math.max(Á.Â.scrollWidth,Á.container.clientWidth -50);Á.selection_field.Ç.top=new_top+\"px\";Á.selection_field.Ç.width=new_width+\"px\";Á.selection_field.Ç.height=new_height+\"px\";$(\"cursor_pos\").Ç.top=new_top+\"px\";if(Á.do_highlight==Ë){var curr_text=infos[\"full_text\"].split(\"\\n\");var content=\"\";var start=Math.max(0,infos[\"line_start\"]-1);var end=Math.min(curr_text.Æ,infos[\"line_start\"]+infos[\"line_nb\"]-1);for(i=start;i< end;i++){content+=curr_text[i]+\"\\n\";}content=content.replace(/&/g,\"&amp;\");content=content.replace(/</g,\"&lt;\");content=content.replace(/>/g,\"&gt;\");if(Á.nav['isIE']||Á.nav['isOpera']||Á.nav['isFirefox'] >=3)Á.selection_field.innerHTML=\"<pre>\"+content.replace(\"\\n\",\"<br/>\")+\"</pre>\";\nelse Á.selection_field.innerHTML=content;if(Á.reload_highlight||(infos[\"full_text\"] !=Á.last_text_to_highlight&&(Á.É[\"line_start\"]!=infos[\"line_start\"]||Á.show_line_colors||Á.É[\"line_nb\"]!=infos[\"line_nb\"]||Á.É[\"nb_line\"]!=infos[\"nb_line\"])))Á.maj_highlight(infos);}}if(infos[\"line_start\"] !=Á.É[\"line_start\"]||infos[\"curr_pos\"] !=Á.É[\"curr_pos\"]||infos[\"full_text\"].Æ!=Á.É[\"full_text\"].Æ||Á.reload_highlight){var selec_char=infos[\"curr_line\"].charAt(infos[\"curr_pos\"]-1);var no_real_move=Ë;if(infos[\"line_nb\"]==1&&(Á.assocBracket[selec_char]||Á.revertAssocBracket[selec_char])){no_real_move=Ì;if(Á.findEndBracket(infos,selec_char)===Ë){$(\"end_bracket\").Ç.visibility=\"visible\";$(\"cursor_pos\").Ç.visibility=\"visible\";$(\"cursor_pos\").innerHTML=selec_char;$(\"end_bracket\").innerHTML=(Á.assocBracket[selec_char]||Á.revertAssocBracket[selec_char]);}\nelse{$(\"end_bracket\").Ç.visibility=\"hidden\";$(\"cursor_pos\").Ç.visibility=\"hidden\";}}\nelse{$(\"cursor_pos\").Ç.visibility=\"hidden\";$(\"end_bracket\").Ç.visibility=\"hidden\";}Á.displayToCursorPosition(\"cursor_pos\",infos[\"line_start\"],infos[\"curr_pos\"]-1,infos[\"curr_line\"],no_real_move);if(infos[\"line_nb\"]==1&&infos[\"line_start\"]!=Á.É[\"line_start\"])Á.scroll_to_view();}Á.É=infos;}if(timer_checkup){setTimeout(\"eA.check_line_selection(Ë)\",Á.check_line_selection_timer);}};EA.Ä.get_selection_infos=Ã(){if(Á.nav['isIE']&&Á.nav['isIE']<9)Á.getIESelection();start=Á.Â.selectionStart;end=Á.Â.selectionEnd;if(Á.É[\"selectionStart\"]==start&&Á.É[\"selectionEnd\"]==end&&Á.É[\"full_text\"]==Á.Â.Ê)return Á.É;if(Á.tabulation!=\"\t\"&&Á.Â.Ê.indexOf(\"\t\")!=-1){var len=Á.Â.Ê.Æ;Á.Â.Ê=Á.replace_tab(Á.Â.Ê);start=end=start+(Á.Â.Ê.Æ-len);Á.area_select(start,0);}var selections=new Object();selections[\"selectionStart\"]=start;selections[\"selectionEnd\"]=end;selections[\"full_text\"]=Á.Â.Ê;selections[\"line_start\"]=1;selections[\"line_nb\"]=1;selections[\"curr_pos\"]=0;selections[\"curr_line\"]=\"\";selections[\"indexOfCursor\"]=0;selections[\"selec_direction\"]=Á.É[\"selec_direction\"];var splitTab=selections[\"full_text\"].split(\"\\n\");var nbLine=Math.max(0,splitTab.Æ);var nbChar=Math.max(0,selections[\"full_text\"].Æ-(nbLine-1));if(selections[\"full_text\"].indexOf(\"\\r\")!=-1)nbChar=nbChar-(nbLine -1);selections[\"nb_line\"]=nbLine;selections[\"nb_char\"]=nbChar;if(start>0){var str=selections[\"full_text\"].substr(0,start);selections[\"curr_pos\"]=start-str.lastIndexOf(\"\\n\");selections[\"line_start\"]=Math.max(1,str.split(\"\\n\").Æ);}\nelse{selections[\"curr_pos\"]=1;}if(end>start){selections[\"line_nb\"]=selections[\"full_text\"].substring(start,end).split(\"\\n\").Æ;}selections[\"indexOfCursor\"]=Á.Â.selectionStart;selections[\"curr_line\"]=splitTab[Math.max(0,selections[\"line_start\"]-1)];if(selections[\"selectionStart\"]==Á.É[\"selectionStart\"]){if(selections[\"selectionEnd\"]>Á.É[\"selectionEnd\"])selections[\"selec_direction\"]=\"down\";\nelse if(selections[\"selectionEnd\"]==Á.É[\"selectionStart\"])selections[\"selec_direction\"]=Á.É[\"selec_direction\"];}\nelse if(selections[\"selectionStart\"]==Á.É[\"selectionEnd\"]&&selections[\"selectionEnd\"]>Á.É[\"selectionEnd\"]){selections[\"selec_direction\"]=\"down\";}\nelse{selections[\"selec_direction\"]=\"up\";}$(\"nbLine\").innerHTML=nbLine;$(\"nbChar\").innerHTML=nbChar;$(\"linePos\").innerHTML=selections[\"line_start\"];$(\"currPos\").innerHTML=selections[\"curr_pos\"];return selections;};EA.Ä.getIESelection=Ã(){var range=document.selection.createRange();var stored_range=range.duplicate();stored_range.moveToElementText(Á.Â );stored_range.setEndPoint('EndToEnd',range );if(stored_range.ÈElement()!=Á.Â)return;var scrollTop=Á.result.scrollTop+document.body.scrollTop;var relative_top=range.offsetTop-È.calculeOffsetTop(Á.Â)+scrollTop;var line_start=Math.round((relative_top / Á.lineHeight)+1);var line_nb=Math.round(range.boundingHeight / Á.lineHeight);var range_start=stored_range.text.Æ-range.text.Æ;var tab=Á.Â.Ê.substr(0,range_start).split(\"\\n\");range_start+=(line_start-tab.Æ)*2;Á.Â.selectionStart=range_start;var range_end=Á.Â.selectionStart+range.text.Æ;tab=Á.Â.Ê.substr(0,range_start+range.text.Æ).split(\"\\n\");range_end+=(line_start+line_nb-1-tab.Æ)*2;Á.Â.selectionEnd=range_end;};EA.Ä.setIESelection=Ã(){var nbLineStart=Á.Â.Ê.substr(0,Á.Â.selectionStart).split(\"\\n\").Æ-1;var nbLineEnd=Á.Â.Ê.substr(0,Á.Â.selectionEnd).split(\"\\n\").Æ-1;var range=document.selection.createRange();range.moveToElementText(Á.Â );range.setEndPoint('EndToStart',range );range.moveStart('character',Á.Â.selectionStart-nbLineStart);range.moveEnd('character',Á.Â.selectionEnd-nbLineEnd-(Á.Â.selectionStart-nbLineStart));range.select();};EA.Ä.tab_selection=Ã(){if(Á.is_tabbing)return;Á.is_tabbing=Ë;if(Á.nav['isIE']&&Á.nav['isIE'] < 9)Á.getIESelection();var start=Á.Â.selectionStart;var end=Á.Â.selectionEnd;var insText=Á.Â.Ê.substring(start,end);var pos_start=start;var pos_end=end;if (insText.Æ==0){Á.Â.Ê=Á.Â.Ê.substr(0,start)+Á.tabulation+Á.Â.Ê.substr(end);pos_start=start+Á.tabulation.Æ;pos_end=pos_start;}\nelse{start=Math.max(0,Á.Â.Ê.substr(0,start).lastIndexOf(\"\\n\")+1);endText=Á.Â.Ê.substr(end);startText=Á.Â.Ê.substr(0,start);tmp=Á.Â.Ê.substring(start,end).split(\"\\n\");insText=Á.tabulation+tmp.join(\"\\n\"+Á.tabulation);Á.Â.Ê=startText+insText+endText;pos_start=start;pos_end=Á.Â.Ê.indexOf(\"\\n\",startText.Æ+insText.Æ);if(pos_end==-1)pos_end=Á.Â.Ê.Æ;}Á.Â.selectionStart=pos_start;Á.Â.selectionEnd=pos_end;if(Á.nav['isIE']&&Á.nav['isIE']<9){Á.setIESelection();setTimeout(\"eA.is_tabbing=Ì;\",100);}\nelse Á.is_tabbing=Ì;};EA.Ä.invert_tab_selection=Ã(){if(Á.is_tabbing)return;Á.is_tabbing=Ë;if(Á.nav['isIE']&&Á.nav['isIE'] < 9)Á.getIESelection();var start=Á.Â.selectionStart;var end=Á.Â.selectionEnd;var insText=Á.Â.Ê.substring(start,end);var pos_start=start;var pos_end=end;if (insText.Æ==0){if(Á.Â.Ê.substring(start-Á.tabulation.Æ,start)==Á.tabulation){Á.Â.Ê=Á.Â.Ê.substr(0,start-Á.tabulation.Æ)+Á.Â.Ê.substr(end);pos_start=Math.max(0,start-Á.tabulation.Æ);pos_end=pos_start;}}\nelse{start=Á.Â.Ê.substr(0,start).lastIndexOf(\"\\n\")+1;endText=Á.Â.Ê.substr(end);startText=Á.Â.Ê.substr(0,start);tmp=Á.Â.Ê.substring(start,end).split(\"\\n\");insText=\"\";for(i=0;i<tmp.Æ;i++){for(j=0;j<Á.tab_nb_char;j++){if(tmp[i].charAt(0)==\"\t\"){tmp[i]=tmp[i].substr(1);j=Á.tab_nb_char;}\nelse if(tmp[i].charAt(0)==\" \")tmp[i]=tmp[i].substr(1);}insText+=tmp[i];if(i<tmp.Æ-1)insText+=\"\\n\";}Á.Â.Ê=startText+insText+endText;pos_start=start;pos_end=Á.Â.Ê.indexOf(\"\\n\",startText.Æ+insText.Æ);if(pos_end==-1)pos_end=Á.Â.Ê.Æ;}Á.Â.selectionStart=pos_start;Á.Â.selectionEnd=pos_end;if(Á.nav['isIE']&&Á.nav['isIE']<9){Á.setIESelection();setTimeout(\"eA.is_tabbing=Ì;\",100);}\nelse Á.is_tabbing=Ì;};EA.Ä.press_enter=Ã(){if(!Á.smooth_selection)return Ì;if(Á.nav['isIE']&&Á.nav['isIE']<9)Á.getIESelection();var scrollTop=Á.result.scrollTop;var scrollLeft=Á.result.scrollLeft;var start=Á.Â.selectionStart;var end=Á.Â.selectionEnd;var start_last_line=Math.max(0,Á.Â.Ê.substring(0,start).lastIndexOf(\"\\n\")+1 );var begin_line=Á.Â.Ê.substring(start_last_line,start).replace(/^([ \t]*).*/gm,\"$1\");if(begin_line==\"\\n\"||begin_line==\"\\r\"||begin_line.Æ==0)return Ì;if(Á.nav['isIE']||Á.nav['isOpera']){begin_line=\"\\r\\n\"+begin_line;}\nelse{begin_line=\"\\n\"+begin_line;}Á.Â.Ê=Á.Â.Ê.substring(0,start)+begin_line+Á.Â.Ê.substring(end);Á.area_select(start+begin_line.Æ ,0);if(Á.nav['isIE']){Á.result.scrollTop=scrollTop;Á.result.scrollLeft=scrollLeft;}return Ë;};EA.Ä.findEndBracket=Ã(infos,bracket){var start=infos[\"indexOfCursor\"];var normal_order=Ë;if(Á.assocBracket[bracket])endBracket=Á.assocBracket[bracket];\nelse if(Á.revertAssocBracket[bracket]){endBracket=Á.revertAssocBracket[bracket];normal_order=Ì;}var end=-1;var nbBracketOpen=0;for(var i=start;i<infos[\"full_text\"].Æ&&i>=0;){if(infos[\"full_text\"].charAt(i)==endBracket){nbBracketOpen--;if(nbBracketOpen<=0){end=i;break;}}\nelse if(infos[\"full_text\"].charAt(i)==bracket)nbBracketOpen++;if(normal_order)i++;\nelse i--;}if(end==-1)return Ì;var endLastLine=infos[\"full_text\"].substr(0,end).lastIndexOf(\"\\n\");if(endLastLine==-1)line=1;\nelse line=infos[\"full_text\"].substr(0,endLastLine).split(\"\\n\").Æ+1;var curPos=end-endLastLine;Á.displayToCursorPosition(\"end_bracket\",line,curPos,infos[\"full_text\"].substring(endLastLine +1,end));return Ë;};EA.Ä.displayToCursorPosition=Ã(id,start_line,cur_pos,lineContent,no_real_move){var elem=$(\"test_font_size\");var dest=$(id);var postLeft=0;elem.innerHTML=\"<pre><span id='test_font_size_inner'>\"+lineContent.substr(0,cur_pos).replace(/&/g,\"&amp;\").replace(/</g,\"&lt;\")+\"</span></pre>\";posLeft=45+$('test_font_size_inner').offsetWidth;var posTop=Á.lineHeight * (start_line-1);if(no_real_move!=Ë){dest.Ç.top=posTop+\"px\";dest.Ç.left=posLeft+\"px\";}dest.cursor_top=posTop;dest.cursor_left=posLeft;};EA.Ä.area_select=Ã(start,Æ){Á.Â.focus();start=Math.max(0,Math.min(Á.Â.Ê.Æ,start));end=Math.max(start,Math.min(Á.Â.Ê.Æ,start+Æ));if(Á.nav['isIE']&&Á.nav['isIE']<9){Á.Â.selectionStart=start;Á.Â.selectionEnd=end;Á.setIESelection();}\nelse{if(Á.nav['isOpera']){Á.Â.setSelectionRange(0,0);}Á.Â.setSelectionRange(start,end);}Á.check_line_selection();};EA.Ä.area_get_selection=Ã(){var text=\"\";if(document.selection ){var range=document.selection.createRange();text=range.text;}\nelse{text=Á.Â.Ê.substring(Á.Â.selectionStart,Á.Â.selectionEnd);}return text;}; EA.Ä.replace_tab=Ã(text){return text.replace(/((\\n?)([^\t\\n]*)\t)/gi,eA.smartTab);};EA.Ä.smartTab=Ã(){val=\"                   \";return EA.Ä.smartTab.arguments[2]+EA.Ä.smartTab.arguments[3]+val.substr(0,eA.tab_nb_char-(EA.Ä.smartTab.arguments[3].Æ)%eA.tab_nb_char);};EA.Ä.show_waiting_screen=Ã(){width=Á.editor_area.offsetWidth;height=Á.editor_area.offsetHeight;if(Á.nav['isGecko']||Á.nav['isOpera']||Á.nav['isIE']>=7){width-=2;height-=2;}Á.processing_screen.Ç.display=\"block\";Á.processing_screen.Ç.width=width+\"px\";Á.processing_screen.Ç.height=height+\"px\";Á.waiting_screen_displayed=Ë;};EA.Ä.hide_waiting_screen=Ã(){Á.processing_screen.Ç.display=\"none\";Á.waiting_screen_displayed=Ì;};EA.Ä.add_Ç=Ã(Çs){if(Çs.Æ>0){newcss=document.createElement(\"Ç\");newcss.type=\"text/css\";newcss.media=\"all\";document.getElementsByTagName(\"head\")[0].appendChild(newcss);cssrules=Çs.split(\"}\");newcss=document.ÇSheets[0];if(newcss.rules){for(i=cssrules.Æ-2;i>=0;i--){newrule=cssrules[i].split(\"{\");newcss.addRule(newrule[0],newrule[1])}}\nelse if(newcss.cssRules){for(i=cssrules.Æ-1;i>=0;i--){if(cssrules[i].indexOf(\"{\")!=-1){newcss.insertRule(cssrules[i]+\"}\",0);}}}}};EA.Ä.set_font=Ã(family,size){var elems=new Array(\"Â\",\"content_highlight\",\"cursor_pos\",\"end_bracket\",\"selection_field\",\"line_number\");if(family&&family!=\"\")Á.Å[\"font_family\"]=family;if(size&&size>0)Á.Å[\"font_size\"]=size;if(Á.nav['isOpera'])Á.Å['font_family']=\"monospace\";var elem_font=$(\"area_font_size\");if(elem_font){for(var i=0;i<elem_font.Æ;i++){if(elem_font.options[i].Ê&&elem_font.options[i].Ê==Á.Å[\"font_size\"])elem_font.options[i].selected=Ë;}}elem=$(\"test_font_size\");elem.Ç.fontFamily=\"\"+Á.Å[\"font_family\"];elem.Ç.fontSize=Á.Å[\"font_size\"]+\"pt\";elem.innerHTML=\"0\";Á.lineHeight=elem.offsetHeight;for(var i=0;i<elems.Æ;i++){var elem=$(elems[i]);elem.Ç.fontFamily=Á.Å[\"font_family\"];elem.Ç.fontSize=Á.Å[\"font_size\"]+\"pt\";elem.Ç.lineHeight=Á.lineHeight+\"px\";}if(Á.nav['isOpera']){var start=Á.Â.selectionStart;var end=Á.Â.selectionEnd;var parNod=Á.Â.ÈNode,nxtSib=Á.Â.nextSibling;parNod.removeChild(Á.Â);parNod.insertBefore(Á.Â,nxtSib);Á.area_select(start,end-start);}Á.add_Ç(\"pre{font-family:\"+Á.Å[\"font_family\"]+\"}\");Á.last_line_selected=-1;Á.É=new Array();Á.resync_highlight();};EA.Ä.change_font_size=Ã(){var size=$(\"area_font_size\").Ê;if(size>0)Á.set_font(\"\",size);};EA.Ä.open_inline_popup=Ã(popup_id){Á.close_all_inline_popup();var popup=$(popup_id);var editor=$(\"editor\");for(var i=0;i<Á.inlinePopup.Æ;i++){if(Á.inlinePopup[i][\"popup_id\"]==popup_id){var icon=$(Á.inlinePopup[i][\"icon_id\"]);if(icon){Á.switchClassSticky(icon,'editAreaButtonSelected',Ë);break;}}}popup.Ç.height=\"auto\";popup.Ç.overflow=\"visible\";if(document.body.offsetHeight< popup.offsetHeight){popup.Ç.height=(document.body.offsetHeight-10)+\"px\";popup.Ç.overflow=\"auto\";}if(!popup.positionned){var new_left=editor.offsetWidth /2-popup.offsetWidth /2;var new_top=editor.offsetHeight /2-popup.offsetHeight /2;popup.Ç.left=new_left+\"px\";popup.Ç.top=new_top+\"px\";popup.positionned=Ë;}popup.Ç.visibility=\"visible\";};EA.Ä.close_inline_popup=Ã(popup_id){var popup=$(popup_id);for(var i=0;i<Á.inlinePopup.Æ;i++){if(Á.inlinePopup[i][\"popup_id\"]==popup_id){var icon=$(Á.inlinePopup[i][\"icon_id\"]);if(icon){Á.switchClassSticky(icon,'editAreaButtonNormal',Ì);break;}}}popup.Ç.visibility=\"hidden\";};EA.Ä.close_all_inline_popup=Ã(e){for(var i=0;i<Á.inlinePopup.Æ;i++){Á.close_inline_popup(Á.inlinePopup[i][\"popup_id\"]);}Á.Â.focus();};EA.Ä.show_help=Ã(){Á.open_inline_popup(\"edit_area_help\");};EA.Ä.new_document=Ã(){Á.Â.Ê=\"\";Á.area_select(0,0);};EA.Ä.get_all_toolbar_height=Ã(){var area=$(\"editor\");var results=È.getChildren(area,\"div\",\"class\",\"area_toolbar\",\"all\",\"0\");var height=0;for(var i=0;i<results.Æ;i++){height+=results[i].offsetHeight;}return height;};EA.Ä.go_to_line=Ã(line){if(!line){var icon=$(\"go_to_line\");if(icon !=null){Á.restoreClass(icon);Á.switchClassSticky(icon,'editAreaButtonSelected',Ë);}line=prompt(Á.get_translation(\"go_to_line_prompt\"));if(icon !=null)Á.switchClassSticky(icon,'editAreaButtonNormal',Ì);}if(line&&line!=null&&line.search(/^[0-9]+$/)!=-1){var start=0;var lines=Á.Â.Ê.split(\"\\n\");if(line > lines.Æ)start=Á.Â.Ê.Æ;\nelse{for(var i=0;i<Math.min(line-1,lines.Æ);i++)start+=lines[i].Æ+1;}Á.area_select(start,0);}};EA.Ä.change_smooth_selection_mode=Ã(setTo){if(Á.do_highlight)return;if(setTo !=null){if(setTo ===Ì)Á.smooth_selection=Ë;\nelse Á.smooth_selection=Ì;}var icon=$(\"change_smooth_selection\");Á.Â.focus();if(Á.smooth_selection===Ë){Á.switchClassSticky(icon,'editAreaButtonNormal',Ì);Á.smooth_selection=Ì;Á.selection_field.Ç.display=\"none\";$(\"cursor_pos\").Ç.display=\"none\";$(\"end_bracket\").Ç.display=\"none\";}\nelse{Á.switchClassSticky(icon,'editAreaButtonSelected',Ì);Á.smooth_selection=Ë;Á.selection_field.Ç.display=\"block\";$(\"cursor_pos\").Ç.display=\"block\";$(\"end_bracket\").Ç.display=\"block\";}};EA.Ä.scroll_to_view=Ã(show){if(!Á.smooth_selection)return;var zone=$(\"result\");var cursor_pos_top=$(\"cursor_pos\").cursor_top;if(show==\"bottom\")cursor_pos_top+=(Á.É[\"line_nb\"]-1)* Á.lineHeight;var max_height_visible=zone.clientHeight+zone.scrollTop;var miss_top=cursor_pos_top+Á.lineHeight-max_height_visible;if(miss_top>0){zone.scrollTop=zone.scrollTop+miss_top;}\nelse if(zone.scrollTop > cursor_pos_top){zone.scrollTop=cursor_pos_top;}var cursor_pos_left=$(\"cursor_pos\").cursor_left;var max_width_visible=zone.clientWidth+zone.scrollLeft;var miss_left=cursor_pos_left+10-max_width_visible;if(miss_left>0){zone.scrollLeft=zone.scrollLeft+miss_left+50;}\nelse if(zone.scrollLeft > cursor_pos_left){zone.scrollLeft=cursor_pos_left;}\nelse if(zone.scrollLeft==45){zone.scrollLeft=0;}};EA.Ä.check_undo=Ã(only_once){if(!eAs[Á.id])return Ì;if(Á.ÂFocused&&eAs[Á.id][\"displayed\"]==Ë){var text=Á.Â.Ê;if(Á.previous.Æ<=1)Á.switchClassSticky($(\"undo\"),'editAreaButtonDisabled',Ë);if(!Á.previous[Á.previous.Æ-1]||Á.previous[Á.previous.Æ-1][\"text\"] !=text){Á.previous.push({\"text\":text,\"selStart\":Á.Â.selectionStart,\"selEnd\":Á.Â.selectionEnd});if(Á.previous.Æ > Á.Å[\"max_undo\"]+1)Á.previous.shift();}if(Á.previous.Æ >=2)Á.switchClassSticky($(\"undo\"),'editAreaButtonNormal',Ì);}if(!only_once)setTimeout(\"eA.check_undo()\",3000);};EA.Ä.undo=Ã(){if(Á.previous.Æ > 0){if(Á.nav['isIE']&&Á.nav['isIE']<9)Á.getIESelection();Á.next.push({\"text\":Á.Â.Ê,\"selStart\":Á.Â.selectionStart,\"selEnd\":Á.Â.selectionEnd});var prev=Á.previous.pop();if(prev[\"text\"]==Á.Â.Ê&&Á.previous.Æ > 0)prev=Á.previous.pop();Á.Â.Ê=prev[\"text\"];Á.last_undo=prev[\"text\"];Á.area_select(prev[\"selStart\"],prev[\"selEnd\"]-prev[\"selStart\"]);Á.switchClassSticky($(\"redo\"),'editAreaButtonNormal',Ì);Á.resync_highlight(Ë);Á.check_file_changes();}};EA.Ä.redo=Ã(){if(Á.next.Æ > 0){var next=Á.next.pop();Á.previous.push(next);Á.Â.Ê=next[\"text\"];Á.last_undo=next[\"text\"];Á.area_select(next[\"selStart\"],next[\"selEnd\"]-next[\"selStart\"]);Á.switchClassSticky($(\"undo\"),'editAreaButtonNormal',Ì);Á.resync_highlight(Ë);Á.check_file_changes();}if(Á.next.Æ==0)Á.switchClassSticky($(\"redo\"),'editAreaButtonDisabled',Ë);};EA.Ä.check_redo=Ã(){if(eA.next.Æ==0||eA.Â.Ê!=eA.last_undo){eA.next=new Array();eA.switchClassSticky($(\"redo\"),'editAreaButtonDisabled',Ë);}\nelse{Á.switchClassSticky($(\"redo\"),'editAreaButtonNormal',Ì);}};EA.Ä.switchClass=Ã(element,class_name,lock_state){var lockChanged=Ì;if (typeof(lock_state)!=\"undefined\"&&element !=null){element.classLock=lock_state;lockChanged=Ë;}if (element !=null&&(lockChanged||!element.classLock)){element.oldClassName=element.className;element.className=class_name;}};EA.Ä.restoreAndSwitchClass=Ã(element,class_name){if (element !=null&&!element.classLock){Á.restoreClass(element);Á.switchClass(element,class_name);}};EA.Ä.restoreClass=Ã(element){if (element !=null&&element.oldClassName&&!element.classLock){element.className=element.oldClassName;element.oldClassName=null;}};EA.Ä.setClassLock=Ã(element,lock_state){if (element !=null)element.classLock=lock_state;};EA.Ä.switchClassSticky=Ã(element,class_name,lock_state){var lockChanged=Ì;if (typeof(lock_state)!=\"undefined\"&&element !=null){element.classLock=lock_state;lockChanged=Ë;}if (element !=null&&(lockChanged||!element.classLock)){element.className=class_name;element.oldClassName=class_name;}};EA.Ä.scroll_page=Ã(params){var dir=params[\"dir\"];var shift_pressed=params[\"shift\"];screen_height=$(\"result\").clientHeight;var lines=Á.Â.Ê.split(\"\\n\");var new_pos=0;var Æ=0;var char_left=0;var line_nb=0;if(dir==\"up\"){var scroll_line=Math.ceil((screen_height -30)/Á.lineHeight);if(Á.É[\"selec_direction\"]==\"up\"){for(line_nb=0;line_nb< Math.min(Á.É[\"line_start\"]-scroll_line,lines.Æ);line_nb++){new_pos+=lines[line_nb].Æ+1;}char_left=Math.min(lines[Math.min(lines.Æ-1,line_nb)].Æ,Á.É[\"curr_pos\"]-1);if(shift_pressed)Æ=Á.É[\"selectionEnd\"]-new_pos-char_left;Á.area_select(new_pos+char_left,Æ);view=\"top\";}\nelse{view=\"bottom\";for(line_nb=0;line_nb< Math.min(Á.É[\"line_start\"]+Á.É[\"line_nb\"]-1-scroll_line,lines.Æ);line_nb++){new_pos+=lines[line_nb].Æ+1;}char_left=Math.min(lines[Math.min(lines.Æ-1,line_nb)].Æ,Á.É[\"curr_pos\"]-1);if(shift_pressed){start=Math.min(Á.É[\"selectionStart\"],new_pos+char_left);Æ=Math.max(new_pos+char_left,Á.É[\"selectionStart\"] )-start;if(new_pos+char_left < Á.É[\"selectionStart\"])view=\"top\";}\nelse start=new_pos+char_left;Á.area_select(start,Æ);}}\nelse{var scroll_line=Math.floor((screen_height-30)/Á.lineHeight);if(Á.É[\"selec_direction\"]==\"down\"){view=\"bottom\";for(line_nb=0;line_nb< Math.min(Á.É[\"line_start\"]+Á.É[\"line_nb\"]-2+scroll_line,lines.Æ);line_nb++){if(line_nb==Á.É[\"line_start\"]-1)char_left=Á.É[\"selectionStart\"] -new_pos;new_pos+=lines[line_nb].Æ+1;}if(shift_pressed){Æ=Math.abs(Á.É[\"selectionStart\"]-new_pos);Æ+=Math.min(lines[Math.min(lines.Æ-1,line_nb)].Æ,Á.É[\"curr_pos\"]);Á.area_select(Math.min(Á.É[\"selectionStart\"],new_pos),Æ);}\nelse{Á.area_select(new_pos+char_left,0);}}\nelse{view=\"top\";for(line_nb=0;line_nb< Math.min(Á.É[\"line_start\"]+scroll_line-1,lines.Æ,lines.Æ);line_nb++){if(line_nb==Á.É[\"line_start\"]-1)char_left=Á.É[\"selectionStart\"] -new_pos;new_pos+=lines[line_nb].Æ+1;}if(shift_pressed){Æ=Math.abs(Á.É[\"selectionEnd\"]-new_pos-char_left);Æ+=Math.min(lines[Math.min(lines.Æ-1,line_nb)].Æ,Á.É[\"curr_pos\"])-char_left-1;Á.area_select(Math.min(Á.É[\"selectionEnd\"],new_pos+char_left),Æ);if(new_pos+char_left > Á.É[\"selectionEnd\"])view=\"bottom\";}\nelse{Á.area_select(new_pos+char_left,0);}}}Á.check_line_selection();Á.scroll_to_view(view);};EA.Ä.start_resize=Ã(e){È.eAL.resize[\"id\"]=eA.id;È.eAL.resize[\"start_x\"]=(e)? e.pageX:event.x+document.body.scrollLeft;È.eAL.resize[\"start_y\"]=(e)? e.pageY:event.y+document.body.scrollTop;if(eA.nav['isIE']&&eA.nav['isIE']<9){eA.Â.focus();eA.getIESelection();}È.eAL.resize[\"selectionStart\"]=eA.Â.selectionStart;È.eAL.resize[\"selectionEnd\"]=eA.Â.selectionEnd;È.eAL.start_resize_area();};EA.Ä.toggle_full_screen=Ã(to){if(typeof(to)==\"undefined\")to=!Á.fullscreen['isFull'];var old=Á.fullscreen['isFull'];Á.fullscreen['isFull']=to;var icon=$(\"fullscreen\");if(to&&to!=old){var selStart=Á.Â.selectionStart;var selEnd=Á.Â.selectionEnd;var html=È.document.getElementsByTagName(\"html\")[0];var frame=È.document.getElementById(\"frame_\"+Á.id);Á.fullscreen['old_overflow']=È.get_css_property(html,\"overflow\");Á.fullscreen['old_height']=È.get_css_property(html,\"height\");Á.fullscreen['old_width']=È.get_css_property(html,\"width\");Á.fullscreen['old_scrollTop']=html.scrollTop;Á.fullscreen['old_scrollLeft']=html.scrollLeft;Á.fullscreen['old_zIndex']=È.get_css_property(frame,\"z-index\");if(Á.nav['isOpera']){html.Ç.height=\"100%\";html.Ç.width=\"100%\";}html.Ç.overflow=\"hidden\";html.scrollTop=0;html.scrollLeft=0;frame.Ç.position=\"absolute\";frame.Ç.width=html.clientWidth+\"px\";frame.Ç.height=html.clientHeight+\"px\";frame.Ç.display=\"block\";frame.Ç.zIndex=\"999999\";frame.Ç.top=\"0px\";frame.Ç.left=\"0px\";frame.Ç.top=\"-\"+È.calculeOffsetTop(frame)+\"px\";frame.Ç.left=\"-\"+È.calculeOffsetLeft(frame)+\"px\";Á.switchClassSticky(icon,'editAreaButtonSelected',Ì);Á.fullscreen['allow_resize']=Á.resize_allowed;Á.allow_resize(Ì);if(Á.nav['isFirefox']){È.eAL.execCommand(Á.id,\"update_size();\");Á.area_select(selStart,selEnd-selStart);Á.scroll_to_view();Á.focus();}\nelse{setTimeout(\"È.eAL.execCommand('\"+Á.id +\"','update_size();');eA.focus();\",10);}}\nelse if(to!=old){var selStart=Á.Â.selectionStart;var selEnd=Á.Â.selectionEnd;var frame=È.document.getElementById(\"frame_\"+Á.id);frame.Ç.position=\"static\";frame.Ç.zIndex=Á.fullscreen['old_zIndex'];var html=È.document.getElementsByTagName(\"html\")[0];if(Á.nav['isOpera']){html.Ç.height=\"auto\";html.Ç.width=\"auto\";html.Ç.overflow=\"auto\";}\nelse if(Á.nav['isIE']&&È!=top){html.Ç.overflow=\"auto\";}\nelse html.Ç.overflow=Á.fullscreen['old_overflow'];html.scrollTop=Á.fullscreen['old_scrollTop'];html.scrollTop=Á.fullscreen['old_scrollLeft'];È.eAL.hide(Á.id);È.eAL.show(Á.id);Á.switchClassSticky(icon,'editAreaButtonNormal',Ì);if(Á.fullscreen['allow_resize'])Á.allow_resize(Á.fullscreen['allow_resize']);if(Á.nav['isFirefox']){Á.area_select(selStart,selEnd-selStart);setTimeout(\"eA.scroll_to_view();\",10);}}};EA.Ä.allow_resize=Ã(allow){var resize=$(\"resize_area\");if(allow){resize.Ç.visibility=\"visible\";È.eAL.add_event(resize,\"mouseup\",eA.start_resize);}\nelse{resize.Ç.visibility=\"hidden\";È.eAL.remove_event(resize,\"mouseup\",eA.start_resize);}Á.resize_allowed=allow;};EA.Ä.change_syntax=Ã(new_syntax,is_waiting){if(new_syntax==Á.Å['syntax'])return Ë;var founded=Ì;for(var i=0;i<Á.syntax_list.Æ;i++){if(Á.syntax_list[i]==new_syntax)founded=Ë;}if(founded==Ë){if(!È.eAL.load_syntax[new_syntax]){if(!is_waiting)È.eAL.load_script(È.eAL.baseURL+\"reg_syntax/\"+new_syntax+\".js\");setTimeout(\"eA.change_syntax('\"+new_syntax +\"',Ë);\",100);Á.show_waiting_screen();}\nelse{if(!Á.allready_used_syntax[new_syntax]){È.eAL.init_syntax_regexp();Á.add_Ç(È.eAL.syntax[new_syntax][\"Çs\"]);Á.allready_used_syntax[new_syntax]=Ë;}var sel=$(\"syntax_selection\");if(sel&&sel.Ê!=new_syntax){for(var i=0;i<sel.Æ;i++){if(sel.options[i].Ê&&sel.options[i].Ê==new_syntax)sel.options[i].selected=Ë;}}Á.Å['syntax']=new_syntax;Á.resync_highlight(Ë);Á.hide_waiting_screen();return Ë;}}return Ì;};EA.Ä.set_editable=Ã(is_editable){if(is_editable){document.body.className=\"\";Á.Â.readOnly=Ì;Á.is_editable=Ë;}\nelse{document.body.className=\"non_editable\";Á.Â.readOnly=Ë;Á.is_editable=Ì;}if(eAs[Á.id][\"displayed\"]==Ë)Á.update_size();};EA.Ä.set_wrap_text=Ã(to){Á.Å['wrap_text']=to;if(Á.Å['wrap_text']){wrap_mode='soft';Á.container.className+=' wrap_text';}\nelse{wrap_mode='off';Á.container.className=Á.container.className.replace(/ wrap_text/g,'');}var t=Á.Â;t.wrap=wrap_mode;t.setAttribute('wrap',wrap_mode);if(!Á.nav['isIE']){var start=t.selectionStart,end=t.selectionEnd;var parNod=t.ÈNode,nxtSib=t.nextSibling;parNod.removeChild(t);parNod.insertBefore(t,nxtSib);Á.area_select(start,end-start);}};EA.Ä.open_file=Ã(Å){if(Å['id']!=\"undefined\"){var id=Å['id'];var new_file=new Object();new_file['id']=id;new_file['title']=id;new_file['text']=\"\";new_file['É']=\"\";new_file['last_text_to_highlight']=\"\";new_file['last_hightlighted_text']=\"\";new_file['previous']=new Array();new_file['next']=new Array();new_file['last_undo']=\"\";new_file['smooth_selection']=Á.Å['smooth_selection'];new_file['do_highlight']=Á.Å['start_highlight'];new_file['syntax']=Á.Å['syntax'];new_file['scroll_top']=0;new_file['scroll_left']=0;new_file['selection_start']=0;new_file['selection_end']=0;new_file['edited']=Ì;new_file['font_size']=Á.Å[\"font_size\"];new_file['font_family']=Á.Å[\"font_family\"];new_file['toolbar']={'links':{},'selects':{}};new_file['compare_edited_text']=new_file['text'];Á.files[id]=new_file;Á.update_file(id,Å);Á.files[id]['compare_edited_text']=Á.files[id]['text'];var html_id='tab_file_'+encodeURIComponent(id);Á.filesIdAssoc[html_id]=id;Á.files[id]['html_id']=html_id;if(!$(Á.files[id]['html_id'])&&id!=\"\"){Á.tab_browsing_area.Ç.display=\"block\";var elem=document.createElement('li');elem.id=Á.files[id]['html_id'];var close=\"<img src=\\\"\"+È.eAL.baseURL +\"images/close.gif\\\" title=\\\"\"+Á.get_translation('close_tab','word')+\"\\\" onclick=\\\"eA.execCommand('close_file',eA.filesIdAssoc['\"+html_id +\"']);return Ì;\\\" class=\\\"hidden\\\" onmouseover=\\\"Á.className=''\\\" onmouseout=\\\"Á.className='hidden'\\\" />\";elem.innerHTML=\"<a onclick=\\\"javascript:eA.execCommand('switch_to_file',eA.filesIdAssoc['\"+html_id +\"']);\\\" selec=\\\"none\\\"><b><span><strong class=\\\"edited\\\">*</strong>\"+Á.files[id]['title']+close +\"</span></b></a>\";$('tab_browsing_list').appendChild(elem);var elem=document.createElement('text');Á.update_size();}if(id!=\"\")Á.execCommand('file_open',Á.files[id]);Á.switch_to_file(id,Ë);return Ë;}\nelse return Ì;};EA.Ä.close_file=Ã(id){if(Á.files[id]){Á.save_file(id);if(Á.execCommand('file_close',Á.files[id])!==Ì){var li=$(Á.files[id]['html_id']);li.ÈNode.removeChild(li);if(id==Á.curr_file){var next_file=\"\";var is_next=Ì;for(var i in Á.files){if(is_next){next_file=i;break;}\nelse if(i==id)is_next=Ë;\nelse next_file=i;}Á.switch_to_file(next_file);}delete (Á.files[id]);Á.update_size();}}};EA.Ä.save_file=Ã(id){if(Á.files[id]){var save=Á.files[id];save['É']=Á.É;save['last_text_to_highlight']=Á.last_text_to_highlight;save['last_hightlighted_text']=Á.last_hightlighted_text;save['previous']=Á.previous;save['next']=Á.next;save['last_undo']=Á.last_undo;save['smooth_selection']=Á.smooth_selection;save['do_highlight']=Á.do_highlight;save['syntax']=Á.Å['syntax'];save['text']=Á.Â.Ê;save['scroll_top']=Á.result.scrollTop;save['scroll_left']=Á.result.scrollLeft;save['selection_start']=Á.É[\"selectionStart\"];save['selection_end']=Á.É[\"selectionEnd\"];save['font_size']=Á.Å[\"font_size\"];save['font_family']=Á.Å[\"font_family\"];save['toolbar']={'links':{},'selects':{}};var links=$(\"toolbar_1\").getElementsByTagName(\"a\");for(var i=0;i<links.Æ;i++){if(links[i].getAttribute('fileSpecific')=='yes'){var save_butt=new Object();var img=links[i].getElementsByTagName('img')[0];save_butt['classLock']=img.classLock;save_butt['className']=img.className;save_butt['oldClassName']=img.oldClassName;save['toolbar']['links'][links[i].id]=save_butt;}}var selects=$(\"toolbar_1\").getElementsByTagName(\"select\");for(var i=0;i<selects.Æ;i++){if(selects[i].getAttribute('fileSpecific')=='yes'){save['toolbar']['selects'][selects[i].id]=selects[i].Ê;}}Á.files[id]=save;return save;}\nelse return Ì;};EA.Ä.update_file=Ã(id,new_Ês){for(var i in new_Ês){Á.files[id][i]=new_Ês[i];}};EA.Ä.display_file=Ã(id){if(id==''){Á.Â.readOnly=Ë;Á.tab_browsing_area.Ç.display=\"none\";$(\"no_file_selected\").Ç.display=\"block\";Á.result.className=\"empty\";if(!Á.files[''])Á.open_file({id:''});}\nelse{Á.result.className=\"\";Á.Â.readOnly=!Á.is_editable;$(\"no_file_selected\").Ç.display=\"none\";Á.tab_browsing_area.Ç.display=\"block\";}Á.check_redo(Ë);Á.check_undo(Ë);Á.curr_file=id;var lis=Á.tab_browsing_area.getElementsByTagName('li');for(var i=0;i<lis.Æ;i++){if(lis[i].id==Á.files[id]['html_id'])lis[i].className='selected';\nelse lis[i].className='';}var new_file=Á.files[id];Á.Â.Ê=new_file['text'];Á.set_font(new_file['font_family'],new_file['font_size']);Á.area_select(new_file['É']['selection_start'],new_file['É']['selection_end']-new_file['É']['selection_start']);Á.manage_size(Ë);Á.result.scrollTop=new_file['scroll_top'];Á.result.scrollLeft=new_file['scroll_left'];Á.previous=new_file['previous'];Á.next=new_file['next'];Á.last_undo=new_file['last_undo'];Á.check_redo(Ë);Á.check_undo(Ë);Á.execCommand(\"change_highlight\",new_file['do_highlight']);Á.execCommand(\"change_syntax\",new_file['syntax']);Á.execCommand(\"change_smooth_selection_mode\",new_file['smooth_selection']);var links=new_file['toolbar']['links'];for(var i in links){if(img=$(i).getElementsByTagName('img')[0]){var save_butt=new Object();img.classLock=links[i]['classLock'];img.className=links[i]['className'];img.oldClassName=links[i]['oldClassName'];}}var selects=new_file['toolbar']['selects'];for(var i in selects){var options=$(i).options;for(var j=0;j<options.Æ;j++){if(options[j].Ê==selects[i])$(i).options[j].selected=Ë;}}};EA.Ä.switch_to_file=Ã(file_to_show,force_refresh){if(file_to_show!=Á.curr_file||force_refresh){Á.save_file(Á.curr_file);if(Á.curr_file!='')Á.execCommand('file_switch_off',Á.files[Á.curr_file]);Á.display_file(file_to_show);if(file_to_show!='')Á.execCommand('file_switch_on',Á.files[file_to_show]);}};EA.Ä.get_file=Ã(id){if(id==Á.curr_file)Á.save_file(id);return Á.files[id];};EA.Ä.get_all_files=Ã(){tmp_files=Á.files;Á.save_file(Á.curr_file);if(tmp_files[''])delete(Á.files['']);return tmp_files;};EA.Ä.check_file_changes=Ã(){var id=Á.curr_file;if(Á.files[id]&&Á.files[id]['compare_edited_text']!=undefined){if(Á.files[id]['compare_edited_text'].Æ==Á.Â.Ê.Æ&&Á.files[id]['compare_edited_text']==Á.Â.Ê){if(Á.files[id]['edited']!=Ì)Á.set_file_edited_mode(id,Ì);}\nelse{if(Á.files[id]['edited']!=Ë)Á.set_file_edited_mode(id,Ë);}}};EA.Ä.set_file_edited_mode=Ã(id,to){if(Á.files[id]&&$(Á.files[id]['html_id'])){var link=$(Á.files[id]['html_id']).getElementsByTagName('a')[0];if(to==Ë){link.className='edited';}\nelse{link.className='';if(id==Á.curr_file)text=Á.Â.Ê;\nelse text=Á.files[id]['text'];Á.files[id]['compare_edited_text']=text;}Á.files[id]['edited']=to;}};EA.Ä.set_show_line_colors=Ã(new_Ê){Á.show_line_colors=new_Ê;if(new_Ê)Á.selection_field.className	+=' show_colors';\nelse Á.selection_field.className=Á.selection_field.className.replace(/ show_colors/g,'' );};var EA_keys={8:\"Retour arriere\",9:\"Tabulation\",12:\"Milieu (pave numerique)\",13:\"Entrer\",16:\"Shift\",17:\"Ctrl\",18:\"Alt\",19:\"Pause\",20:\"Verr Maj\",27:\"Esc\",32:\"Space\",33:\"Page up\",34:\"Page down\",35:\"End\",36:\"Begin\",37:\"Left\",38:\"Up\",39:\"Right\",40:\"Down\",44:\"Impr ecran\",45:\"Inser\",46:\"Suppr\",91:\"Menu Demarrer Windows / touche pomme Mac\",92:\"Menu Demarrer Windows\",93:\"Menu contextuel Windows\",112:\"F1\",113:\"F2\",114:\"F3\",115:\"F4\",116:\"F5\",117:\"F6\",118:\"F7\",119:\"F8\",120:\"F9\",121:\"F10\",122:\"F11\",123:\"F12\",144:\"Verr Num\",145:\"Arret defil\"};Ã keyDown(e){if(!e){e=event;}for(var i in eA.plugins){if(typeof(eA.plugins[i].onkeydown)==\"Ã\"){if(eA.plugins[i].onkeydown(e)===Ì){if(eA.nav['isIE'])e.keyCode=0;return Ì;}}}var target_id=(e.target||e.srcElement).id;var use=Ì;if (EA_keys[e.keyCode])letter=EA_keys[e.keyCode];\nelse letter=String.fromCharCode(e.keyCode);var low_letter=letter.toLowerCase();if(letter==\"Page up\"&&!eA.nav['isOpera']){eA.execCommand(\"scroll_page\",{\"dir\":\"up\",\"shift\":ShiftPressed(e)});use=Ë;}\nelse if(letter==\"Page down\"&&!eA.nav['isOpera']){eA.execCommand(\"scroll_page\",{\"dir\":\"down\",\"shift\":ShiftPressed(e)});use=Ë;}\nelse if(eA.is_editable==Ì){return Ë;}\nelse if(letter==\"Tabulation\"&&target_id==\"Â\"&&!CtrlPressed(e)&&!AltPressed(e)){if(ShiftPressed(e))eA.execCommand(\"invert_tab_selection\");\nelse eA.execCommand(\"tab_selection\");use=Ë;if(eA.nav['isOpera']||(eA.nav['isFirefox']&&eA.nav['isMacOS']))setTimeout(\"eA.execCommand('focus');\",1);}\nelse if(letter==\"Entrer\"&&target_id==\"Â\"){if(eA.press_enter())use=Ë;}\nelse if(letter==\"Entrer\"&&target_id==\"area_search\"){eA.execCommand(\"area_search\");use=Ë;}\nelse  if(letter==\"Esc\"){eA.execCommand(\"close_all_inline_popup\",e);use=Ë;}\nelse if(CtrlPressed(e)&&!AltPressed(e)&&!ShiftPressed(e)){switch(low_letter){case \"f\":eA.execCommand(\"area_search\");use=Ë;break;case \"r\":eA.execCommand(\"area_replace\");use=Ë;break;case \"q\":eA.execCommand(\"close_all_inline_popup\",e);use=Ë;break;case \"h\":eA.execCommand(\"change_highlight\");use=Ë;break;case \"g\":setTimeout(\"eA.execCommand('go_to_line');\",5);use=Ë;break;case \"e\":eA.execCommand(\"show_help\");use=Ë;break;case \"z\":use=Ë;eA.execCommand(\"undo\");break;case \"y\":use=Ë;eA.execCommand(\"redo\");break;default:break;}}if(eA.next.Æ > 0){setTimeout(\"eA.check_redo();\",10);}setTimeout(\"eA.check_file_changes();\",10);if(use){if(eA.nav['isIE'])e.keyCode=0;return Ì;}return Ë;};Ã AltPressed(e){if (window.event){return (window.event.altKey);}\nelse{if(e.modifiers)return (e.altKey||(e.modifiers % 2));\nelse return e.altKey;}};Ã CtrlPressed(e){if (window.event){return (window.event.ctrlKey);}\nelse{return (e.ctrlKey||(e.modifiers==2)||(e.modifiers==3)||(e.modifiers>5));}};Ã ShiftPressed(e){if (window.event){return (window.event.shiftKey);}\nelse{return (e.shiftKey||(e.modifiers>3));}};	EA.Ä.show_search=Ã(){if($(\"area_search_replace\").Ç.visibility==\"visible\"){Á.hidden_search();}\nelse{Á.open_inline_popup(\"area_search_replace\");var text=Á.area_get_selection();var search=text.split(\"\\n\")[0];$(\"area_search\").Ê=search;$(\"area_search\").focus();}};EA.Ä.hidden_search=Ã(){Á.close_inline_popup(\"area_search_replace\");};EA.Ä.area_search=Ã(mode){if(!mode)mode=\"search\";$(\"area_search_msg\").innerHTML=\"\";var search=$(\"area_search\").Ê;Á.Â.focus();Á.Â.ÂFocused=Ë;var infos=Á.get_selection_infos();var start=infos[\"selectionStart\"];var pos=-1;var pos_begin=-1;var Æ=search.Æ;if($(\"area_search_replace\").Ç.visibility!=\"visible\"){Á.show_search();return;}if(search.Æ==0){$(\"area_search_msg\").innerHTML=Á.get_translation(\"search_field_empty\");return;}if(mode!=\"replace\" ){if($(\"area_search_reg_exp\").checked)start++;\nelse start+=search.Æ;}if($(\"area_search_reg_exp\").checked){var opt=\"m\";if(!$(\"area_search_match_case\").checked)opt+=\"i\";var reg=new RegExp(search,opt);pos=infos[\"full_text\"].substr(start).search(reg);pos_begin=infos[\"full_text\"].search(reg);if(pos!=-1){pos+=start;Æ=infos[\"full_text\"].substr(start).match(reg)[0].Æ;}\nelse if(pos_begin!=-1){Æ=infos[\"full_text\"].match(reg)[0].Æ;}}\nelse{if($(\"area_search_match_case\").checked){pos=infos[\"full_text\"].indexOf(search,start);pos_begin=infos[\"full_text\"].indexOf(search);}\nelse{pos=infos[\"full_text\"].toLowerCase().indexOf(search.toLowerCase(),start);pos_begin=infos[\"full_text\"].toLowerCase().indexOf(search.toLowerCase());}}if(pos==-1&&pos_begin==-1){$(\"area_search_msg\").innerHTML=\"<strong>\"+search+\"</strong> \"+Á.get_translation(\"not_found\");return;}\nelse if(pos==-1&&pos_begin !=-1){begin=pos_begin;$(\"area_search_msg\").innerHTML=Á.get_translation(\"restart_search_at_begin\");}\nelse begin=pos;if(mode==\"replace\"&&pos==infos[\"indexOfCursor\"]){var replace=$(\"area_replace\").Ê;var new_text=\"\";if($(\"area_search_reg_exp\").checked){var opt=\"m\";if(!$(\"area_search_match_case\").checked)opt+=\"i\";var reg=new RegExp(search,opt);new_text=infos[\"full_text\"].substr(0,begin)+infos[\"full_text\"].substr(start).replace(reg,replace);}\nelse{new_text=infos[\"full_text\"].substr(0,begin)+replace+infos[\"full_text\"].substr(begin+Æ);}Á.Â.Ê=new_text;Á.area_select(begin,Æ);Á.area_search();}\nelse Á.area_select(begin,Æ);};EA.Ä.area_replace=Ã(){Á.area_search(\"replace\");};EA.Ä.area_replace_all=Ã(){var base_text=Á.Â.Ê;var search=$(\"area_search\").Ê;var replace=$(\"area_replace\").Ê;if(search.Æ==0){$(\"area_search_msg\").innerHTML=Á.get_translation(\"search_field_empty\");return;}var new_text=\"\";var nb_change=0;if($(\"area_search_reg_exp\").checked){var opt=\"mg\";if(!$(\"area_search_match_case\").checked)opt+=\"i\";var reg=new RegExp(search,opt);nb_change=infos[\"full_text\"].match(reg).Æ;new_text=infos[\"full_text\"].replace(reg,replace);}\nelse{if($(\"area_search_match_case\").checked){var tmp_tab=base_text.split(search);nb_change=tmp_tab.Æ -1;new_text=tmp_tab.join(replace);}\nelse{var lower_Ê=base_text.toLowerCase();var lower_search=search.toLowerCase();var start=0;var pos=lower_Ê.indexOf(lower_search);while(pos!=-1){nb_change++;new_text+=Á.Â.Ê.substring(start,pos)+replace;start=pos+search.Æ;pos=lower_Ê.indexOf(lower_search,pos+1);}new_text+=Á.Â.Ê.substring(start);}}if(new_text==base_text){$(\"area_search_msg\").innerHTML=\"<strong>\"+search+\"</strong> \"+Á.get_translation(\"not_found\");}\nelse{Á.Â.Ê=new_text;$(\"area_search_msg\").innerHTML=\"<strong>\"+nb_change+\"</strong> \"+Á.get_translation(\"occurrence_replaced\");setTimeout(\"eA.Â.focus();eA.Â.ÂFocused=Ë;\",100);}}; EA.Ä.change_highlight=Ã(change_to){if(Á.Å[\"syntax\"].Æ==0&&change_to==Ì){Á.switchClassSticky($(\"highlight\"),'editAreaButtonDisabled',Ë);Á.switchClassSticky($(\"reset_highlight\"),'editAreaButtonDisabled',Ë);return Ì;}if(Á.do_highlight==change_to)return Ì;if(Á.nav['isIE']&&Á.nav['isIE']<9)Á.getIESelection();var pos_start=Á.Â.selectionStart;var pos_end=Á.Â.selectionEnd;if(Á.do_highlight===Ë||change_to==Ì)Á.disable_highlight();\nelse Á.enable_highlight();Á.Â.focus();Á.Â.selectionStart=pos_start;Á.Â.selectionEnd=pos_end;if(Á.nav['isIE']&&Á.nav['isIE']<9)Á.setIESelection();};EA.Ä.disable_highlight=Ã(displayOnly){Á.selection_field.innerHTML=\"\";Á.content_highlight.Ç.visibility=\"hidden\";var new_Obj=Á.content_highlight.cloneNode(Ì);new_Obj.innerHTML=\"\";Á.content_highlight.ÈNode.insertBefore(new_Obj,Á.content_highlight);Á.content_highlight.ÈNode.removeChild(Á.content_highlight);Á.content_highlight=new_Obj;var old_class=È.getAttribute(Á.Â,\"class\");if(old_class){var new_class=old_class.replace(\"hidden\",\"\");È.setAttribute(Á.Â,\"class\",new_class);}Á.Â.Ç.backgroundColor=\"transÈ\";Á.switchClassSticky($(\"highlight\"),'editAreaButtonNormal',Ë);Á.switchClassSticky($(\"reset_highlight\"),'editAreaButtonDisabled',Ë);Á.do_highlight=Ì;Á.switchClassSticky($(\"change_smooth_selection\"),'editAreaButtonSelected',Ë);if(typeof(Á.smooth_selection_before_highlight)!=\"undefined\"&&Á.smooth_selection_before_highlight===Ì){Á.change_smooth_selection_mode(Ì);}};EA.Ä.enable_highlight=Ã(){Á.show_waiting_screen();Á.content_highlight.Ç.visibility=\"visible\";var new_class=È.getAttribute(Á.Â,\"class\")+\" hidden\";È.setAttribute(Á.Â,\"class\",new_class);if(Á.nav['isIE'])Á.Â.Ç.backgroundColor=\"#FFFFFF\";Á.switchClassSticky($(\"highlight\"),'editAreaButtonSelected',Ì);Á.switchClassSticky($(\"reset_highlight\"),'editAreaButtonNormal',Ì);Á.smooth_selection_before_highlight=Á.smooth_selection;if(!Á.smooth_selection)Á.change_smooth_selection_mode(Ë);Á.switchClassSticky($(\"change_smooth_selection\"),'editAreaButtonDisabled',Ë);Á.do_highlight=Ë;Á.resync_highlight();Á.hide_waiting_screen();};EA.Ä.maj_highlight=Ã(infos){if(Á.last_highlight_base_text==infos[\"full_text\"]&&Á.resync_highlight!==Ë)return;if(infos[\"full_text\"].indexOf(\"\\r\")!=-1)text_to_highlight=infos[\"full_text\"].replace(/\\r/g,\"\");\nelse text_to_highlight=infos[\"full_text\"];var start_line_pb=-1;var end_line_pb=-1;var stay_begin=\"\";var stay_end=\"\";var debug_opti=\"\";var date=new Date();var tps_start=date.getTime();var tps_middle_opti=date.getTime();if(Á.reload_highlight===Ë){Á.reload_highlight=Ì;}\nelse if(text_to_highlight.Æ==0){text_to_highlight=\"\\n \";}\nelse{var base_step=200;var cpt=0;var end=Math.min(text_to_highlight.Æ,Á.last_text_to_highlight.Æ);var step=base_step;while(cpt<end&&step>=1){if(Á.last_text_to_highlight.substr(cpt,step)==text_to_highlight.substr(cpt,step)){cpt+=step;}\nelse{step=Math.floor(step/2);}}var pos_start_change=cpt;var line_start_change=text_to_highlight.substr(0,pos_start_change).split(\"\\n\").Æ -1;cpt_last=Á.last_text_to_highlight.Æ;cpt=text_to_highlight.Æ;step=base_step;while(cpt>=0&&cpt_last>=0&&step>=1){if(Á.last_text_to_highlight.substr(cpt_last-step,step)==text_to_highlight.substr(cpt-step,step)){cpt-=step;cpt_last-=step;}\nelse{step=Math.floor(step/2);}}var pos_new_end_change=cpt;var pos_last_end_change=cpt_last;if(pos_new_end_change<=pos_start_change){if(Á.last_text_to_highlight.Æ < text_to_highlight.Æ){pos_new_end_change=pos_start_change+text_to_highlight.Æ-Á.last_text_to_highlight.Æ;pos_last_end_change=pos_start_change;}\nelse{pos_last_end_change=pos_start_change+Á.last_text_to_highlight.Æ-text_to_highlight.Æ;pos_new_end_change=pos_start_change;}}var change_new_text=text_to_highlight.substring(pos_start_change,pos_new_end_change);var change_last_text=Á.last_text_to_highlight.substring(pos_start_change,pos_last_end_change);var line_new_end_change=text_to_highlight.substr(0,pos_new_end_change).split(\"\\n\").Æ -1;var line_last_end_change=Á.last_text_to_highlight.substr(0,pos_last_end_change).split(\"\\n\").Æ -1;var change_new_text_line=text_to_highlight.split(\"\\n\").slice(line_start_change,line_new_end_change+1).join(\"\\n\");var change_last_text_line=Á.last_text_to_highlight.split(\"\\n\").slice(line_start_change,line_last_end_change+1).join(\"\\n\");var trace_new=Á.get_syntax_trace(change_new_text_line);var trace_last=Á.get_syntax_trace(change_last_text_line);if(trace_new==trace_last){date=new Date();tps_middle_opti=date.getTime();stay_begin=Á.last_hightlighted_text.split(\"\\n\").slice(0,line_start_change).join(\"\\n\");if(line_start_change>0)stay_begin+=\"\\n\";stay_end=Á.last_hightlighted_text.split(\"\\n\").slice(line_last_end_change+1).join(\"\\n\");if(stay_end.Æ>0)stay_end=\"\\n\"+stay_end;if(stay_begin.Æ==0&&pos_last_end_change==-1)change_new_text_line+=\"\\n\";text_to_highlight=change_new_text_line;}if(Á.Å[\"debug\"]){debug_opti=(trace_new==trace_last)?\"Optimisation\":\"No optimisation\";debug_opti+=\" start:\"+pos_start_change +\"(\"+line_start_change+\")\";debug_opti+=\" end_new:\"+pos_new_end_change+\"(\"+line_new_end_change+\")\";debug_opti+=\" end_last:\"+pos_last_end_change+\"(\"+line_last_end_change+\")\";debug_opti+=\"\\nchanged_text:\"+change_new_text+\" => trace:\"+trace_new;debug_opti+=\"\\nchanged_last_text:\"+change_last_text+\" => trace:\"+trace_last;debug_opti+=\"\\nchanged_line:\"+change_new_text_line;debug_opti+=\"\\nlast_changed_line:\"+change_last_text_line;debug_opti+=\"\\nstay_begin:\"+stay_begin.slice(-200);debug_opti+=\"\\nstay_end:\"+stay_end;debug_opti+=\"\\n\";}}date=new Date();tps_end_opti=date.getTime();var updated_highlight=Á.colorize_text(text_to_highlight);date=new Date();tps2=date.getTime();var hightlighted_text=stay_begin+updated_highlight+stay_end;date=new Date();inner1=date.getTime();var new_Obj=Á.content_highlight.cloneNode(Ì);if(Á.nav['isIE']||Á.nav['isOpera']||Á.nav['isFirefox'] >=3)new_Obj.innerHTML=\"<pre><span class='\"+Á.Å[\"syntax\"] +\"'>\"+hightlighted_text.replace(\"\\n\",\"<br/>\")+\"</span></pre>\";\nelse new_Obj.innerHTML=\"<span class='\"+Á.Å[\"syntax\"] +\"'>\"+hightlighted_text +\"</span>\";Á.content_highlight.ÈNode.replaceChild(new_Obj,Á.content_highlight);Á.content_highlight=new_Obj;if(infos[\"full_text\"].indexOf(\"\\r\")!=-1)Á.last_text_to_highlight=infos[\"full_text\"].replace(/\\r/g,\"\");\nelse Á.last_text_to_highlight=infos[\"full_text\"];Á.last_hightlighted_text=hightlighted_text;date=new Date();tps3=date.getTime();if(Á.Å[\"debug\"]){tot1=tps_end_opti-tps_start;tot_middle=tps_end_opti-tps_middle_opti;tot2=tps2-tps_end_opti;tps_join=inner1-tps2;tps_td2=tps3-inner1;Á.debug.Ê=\"Tps optimisation \"+tot1+\" (second part:\"+tot_middle+\")| tps reg exp:\"+tot2+\" | tps join:\"+tps_join;Á.debug.Ê+=\" | tps update highlight content:\"+tps_td2+\"(\"+tps3+\")\\n\";Á.debug.Ê+=debug_opti;}};EA.Ä.resync_highlight=Ã(reload_now){Á.reload_highlight=Ë;Á.last_highlight_base_text=\"\";Á.focus();if(reload_now)Á.check_line_selection(Ì);}; EA.Ä.comment_or_quote=Ã(){var new_class=\"\";var close_tag=\"\";for(var i in È.eAL.syntax[eA.current_code_lang][\"quotes\"]){if(EA.Ä.comment_or_quote.arguments[0].indexOf(i)==0){new_class=\"quotesmarks\";close_tag=È.eAL.syntax[eA.current_code_lang][\"quotes\"][i];}}if(new_class.Æ==0){for(var i in È.eAL.syntax[eA.current_code_lang][\"comments\"]){if(EA.Ä.comment_or_quote.arguments[0].indexOf(i)==0){new_class=\"comments\";close_tag=È.eAL.syntax[eA.current_code_lang][\"comments\"][i];}}}if(close_tag==\"\\n\"){return \"µ__\"+new_class +\"__µ\"+EA.Ä.comment_or_quote.arguments[0].replace(/(\\r?\\n)?$/m,\"µ_END_µ$1\");}\nelse{reg=new RegExp(È.eAL.get_escaped_regexp(close_tag)+\"$\",\"m\");if(EA.Ä.comment_or_quote.arguments[0].search(reg)!=-1)return \"µ__\"+new_class +\"__µ\"+EA.Ä.comment_or_quote.arguments[0]+\"µ_END_µ\";\nelse return \"µ__\"+new_class +\"__µ\"+EA.Ä.comment_or_quote.arguments[0];}};EA.Ä.get_syntax_trace=Ã(text){if(Á.Å[\"syntax\"].Æ>0&&È.eAL.syntax[Á.Å[\"syntax\"]][\"syntax_trace_regexp\"])return text.replace(È.eAL.syntax[Á.Å[\"syntax\"]][\"syntax_trace_regexp\"],\"$3\");};EA.Ä.colorize_text=Ã(text){text=\" \"+text;if(Á.Å[\"syntax\"].Æ>0)text=Á.apply_syntax(text,Á.Å[\"syntax\"]);return text.substr(1).replace(/&/g,\"&amp;\").replace(/</g,\"&lt;\").replace(/>/g,\"&gt;\").replace(/µ_END_µ/g,\"</span>\").replace(/µ__([a-zA-Z0-9]+)__µ/g,\"<span class='$1'>\");};EA.Ä.apply_syntax=Ã(text,lang){Á.current_code_lang=lang;if(!È.eAL.syntax[lang])return text;if(È.eAL.syntax[lang][\"custom_regexp\"]['before']){for(var i in È.eAL.syntax[lang][\"custom_regexp\"]['before']){var convert=\"$1µ__\"+È.eAL.syntax[lang][\"custom_regexp\"]['before'][i]['class'] +\"__µ$2µ_END_µ$3\";text=text.replace(È.eAL.syntax[lang][\"custom_regexp\"]['before'][i]['regexp'],convert);}}if(È.eAL.syntax[lang][\"comment_or_quote_reg_exp\"]){text=text.replace(È.eAL.syntax[lang][\"comment_or_quote_reg_exp\"],Á.comment_or_quote);}if(È.eAL.syntax[lang][\"keywords_reg_exp\"]){for(var i in È.eAL.syntax[lang][\"keywords_reg_exp\"]){text=text.replace(È.eAL.syntax[lang][\"keywords_reg_exp\"][i],'µ__'+i+'__µ$2µ_END_µ');}}if(È.eAL.syntax[lang][\"delimiters_reg_exp\"]){text=text.replace(È.eAL.syntax[lang][\"delimiters_reg_exp\"],'µ__delimiters__µ$1µ_END_µ');}if(È.eAL.syntax[lang][\"operators_reg_exp\"]){text=text.replace(È.eAL.syntax[lang][\"operators_reg_exp\"],'µ__operators__µ$1µ_END_µ');}if(È.eAL.syntax[lang][\"custom_regexp\"]['after']){for(var i in È.eAL.syntax[lang][\"custom_regexp\"]['after']){var convert=\"$1µ__\"+È.eAL.syntax[lang][\"custom_regexp\"]['after'][i]['class'] +\"__µ$2µ_END_µ$3\";text=text.replace(È.eAL.syntax[lang][\"custom_regexp\"]['after'][i]['regexp'],convert);}}return text;};var editArea= eA;EditArea=EA;</script>".replace(/Á/g, 'this').replace(/Â/g, 'textarea').replace(/Ã/g, 'function').replace(/Ä/g, 'prototype').replace(/Å/g, 'settings').replace(/Æ/g, 'length').replace(/Ç/g, 'style').replace(/È/g, 'parent').replace(/É/g, 'last_selection').replace(/Ê/g, 'value').replace(/Ë/g, 'true').replace(/Ì/g, 'false');
editAreaLoader.template = "<?xml version=\"1.0\" encoding=\"UTF-8\"?> <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\"> <html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" > <head> <title>EditArea</title> <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /> [__CSSRULES__] [__JSCODE__] </head> <body> <div id='editor'> <div class='area_toolbar' id='toolbar_1'>[__TOOLBAR__]</div> <div class='area_toolbar' id='tab_browsing_area'><ul id='tab_browsing_list' class='menu'> <li> </li> </ul></div> <div id='result'> <div id='no_file_selected'></div> <div id='container'> <div id='cursor_pos' class='edit_area_cursor'>&nbsp;</div> <div id='end_bracket' class='edit_area_cursor'>&nbsp;</div> <div id='selection_field'></div> <div id='line_number' selec='none'></div> <div id='content_highlight'></div> <div id='test_font_size'></div> <textarea id='textarea' wrap='off' onchange='editArea.execCommand(\"onchange\");' onfocus='javascript:editArea.textareaFocused=true;' onblur='javascript:editArea.textareaFocused=false;'> </textarea> </div> </div> <div class='area_toolbar' id='toolbar_2'> <table class='statusbar' cellspacing='0' cellpadding='0'> <tr> <td class='total' selec='none'>{$position}:</td> <td class='infos' selec='none'> {$line_abbr} <span  id='linePos'>0</span>, {$char_abbr} <span id='currPos'>0</span> </td> <td class='total' selec='none'>{$total}:</td> <td class='infos' selec='none'> {$line_abbr} <span id='nbLine'>0</span>, {$char_abbr} <span id='nbChar'>0</span> </td> <td class='resize'> <span id='resize_area'><img src='[__BASEURL__]images/statusbar_resize.gif' alt='resize' selec='none'></span> </td> </tr> </table> </div> </div> <div id='processing'> <div id='processing_text'> {$processing} </div> </div> <div id='area_search_replace' class='editarea_popup'> <table cellspacing='2' cellpadding='0' style='width: 100%'> <tr> <td selec='none'>{$search}</td> <td><input type='text' id='area_search' /></td> <td id='close_area_search_replace'> <a onclick='Javascript:editArea.execCommand(\"hidden_search\")'><img selec='none' src='[__BASEURL__]images/close.gif' alt='{$close_popup}' title='{$close_popup}' /></a><br /> </tr><tr> <td selec='none'>{$replace}</td> <td><input type='text' id='area_replace' /></td> <td><img id='move_area_search_replace' onmousedown='return parent.start_move_element(event,\"area_search_replace\", parent.frames[\"frame_\"+editArea.id]);'  src='[__BASEURL__]images/move.gif' alt='{$move_popup}' title='{$move_popup}' /></td> </tr> </table> <div class='button'> <input type='checkbox' id='area_search_match_case' /><label for='area_search_match_case' selec='none'>{$match_case}</label> <input type='checkbox' id='area_search_reg_exp' /><label for='area_search_reg_exp' selec='none'>{$reg_exp}</label> <br /> <a onclick='Javascript:editArea.execCommand(\"area_search\")' selec='none'>{$find_next}</a> <a onclick='Javascript:editArea.execCommand(\"area_replace\")' selec='none'>{$replace}</a> <a onclick='Javascript:editArea.execCommand(\"area_replace_all\")' selec='none'>{$replace_all}</a><br /> </div> <div id='area_search_msg' selec='none'></div> </div> <div id='edit_area_help' class='editarea_popup'> <div class='close_popup'> <a onclick='Javascript:editArea.execCommand(\"close_all_inline_popup\")'><img src='[__BASEURL__]images/close.gif' alt='{$close_popup}' title='{$close_popup}' /></a> </div> <div><h2>Editarea [__EA_VERSION__]</h2><br /> <h3>{$shortcuts}:</h3> {$tab}: {$add_tab}<br /> {$shift}+{$tab}: {$remove_tab}<br /> {$ctrl}+f: {$search_command}<br /> {$ctrl}+r: {$replace_command}<br /> {$ctrl}+h: {$highlight}<br /> {$ctrl}+g: {$go_to_line}<br /> {$ctrl}+z: {$undo}<br /> {$ctrl}+y: {$redo}<br /> {$ctrl}+e: {$help}<br /> {$ctrl}+q, {$esc}: {$close_popup}<br /> {$accesskey} E: {$toggle}<br /> <br /> <em>{$about_notice}</em> <br /><div class='copyright'>&copy; Christophe Dolivet 2007-2008</div> </div> </div> </div> </body> </html> ";
editAreaLoader.iframe_css = "<style>body,html{margin:0;padding:0;height:100%;border:none;overflow:hidden;background-color:#FFF;}body,html,table,form,textarea{font:12px monospace,sans-serif;}#editor{border:solid #888 1px;overflow:visible;}#result{z-index:4;overflow-x:auto;overflow-y:scroll;border-top:solid #888 1px;border-bottom:solid #888 1px;position:relative;clear:both;}#result.empty{overflow:hidden;}#container{overflow:hidden;border:solid blue 0;position:relative;z-index:10;padding:0 5px 0 45px;}#textarea{position:relative;top:0;left:0;margin:0;padding:0;width:100%;height:100%;overflow:hidden;z-index:7;border-width:0;background-color:transparent;}#textarea,#textarea:hover{outline:none;}#content_highlight{white-space:pre;margin:0;padding:0;position:absolute;z-index:4;overflow:visible;}#selection_field{margin:0;background-color:#E1F2F9;height:1px;position:absolute;z-index:5;top:-100px;padding:0;white-space:pre;overflow:hidden;}#selection_field.show_colors{z-index:3;background-color:#EDF9FC;color:transparent;}#container.wrap_text #content_highlight,#container.wrap_text #selection_field{white-space:pre-wrap;white-space:-moz-pre-wrap !important;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word;width:99%;}#line_number{position:absolute;overflow:hidden;border-right:solid black 1px;z-index:8;width:38px;padding:0 5px 0 0;margin:0 0 0 -45px;text-align:right;color:#AAAAAA;}#test_font_size{padding:0;margin:0;visibility:hidden;position:absolute;white-space:pre;}pre{margin:0;padding:0;}.hidden{opacity:0.2;filter:alpha(opacity=20);}#result .edit_area_cursor{position:absolute;z-index:6;background-color:#FF6633;top:-100px;margin:1px 0 0 0;}#result .edit_area_selection_field .overline{background-color:#996600;}.editarea_popup{border:solid 1px #888888;background-color:#ECE9D8;width:250px;padding:4px;position:absolute;visibility:hidden;z-index:15;top:-500px;}.editarea_popup,.editarea_popup table{font-family:sans-serif;font-size:10pt;}.editarea_popup img{border:0;}.editarea_popup .close_popup{float:right;line-height:16px;border:0;padding:0;}.editarea_popup h1,.editarea_popup h2,.editarea_popup h3,.editarea_popup h4,.editarea_popup h5,.editarea_popup h6{margin:0;padding:0;}.editarea_popup .copyright{text-align:right;}div#area_search_replace{}div#area_search_replace img{border:0;}div#area_search_replace div.button{text-align:center;line-height:1.7em;}div#area_search_replace .button a{cursor:pointer;border:solid 1px #888888;background-color:#DEDEDE;text-decoration:none;padding:0 2px;color:#000000;white-space:nowrap;}div#area_search_replace a:hover{background-color:#EDEDED;}div#area_search_replace  #move_area_search_replace{cursor:move;border:solid 1px #888;}div#area_search_replace  #close_area_search_replace{text-align:right;vertical-align:top;white-space:nowrap;}div#area_search_replace  #area_search_msg{height:18px;overflow:hidden;border-top:solid 1px #888;margin-top:3px;}#edit_area_help{width:350px;}#edit_area_help div.close_popup{float:right;}.area_toolbar{width:100%;margin:0;padding:0;background-color:#ECE9D8;text-align:center;}.area_toolbar,.area_toolbar table{font:11px sans-serif;}.area_toolbar img{border:0;vertical-align:middle;}.area_toolbar input{margin:0;padding:0;}.area_toolbar select{font-family:'MS Sans Serif',sans-serif,Verdana,Arial;font-size:7pt;font-weight:normal;margin:2px 0 0 0 ;padding:0;vertical-align:top;background-color:#F0F0EE;}table.statusbar{width:100%;}.area_toolbar td.infos{text-align:center;width:130px;border-right:solid 1px #888;border-width:0 1px 0 0;padding:0;}.area_toolbar td.total{text-align:right;width:50px;padding:0;}.area_toolbar td.resize{text-align:right;}.area_toolbar span#resize_area{cursor:nw-resize;visibility:hidden;}.editAreaButtonNormal,.editAreaButtonOver,.editAreaButtonDown,.editAreaSeparator,.editAreaSeparatorLine,.editAreaButtonDisabled,.editAreaButtonSelected {border:0; margin:0; padding:0; background:transparent;margin-top:0;margin-left:1px;padding:0;}.editAreaButtonNormal {border:1px solid #ECE9D8 !important;cursor:pointer;}.editAreaButtonOver {border:1px solid #0A246A !important;cursor:pointer;background-color:#B6BDD2;}.editAreaButtonDown {cursor:pointer;border:1px solid #0A246A !important;background-color:#8592B5;}.editAreaButtonSelected {border:1px solid #C0C0BB !important;cursor:pointer;background-color:#F4F2E8;}.editAreaButtonDisabled {filter:progid:DXImageTransform.Microsoft.Alpha(opacity=30);-moz-opacity:0.3;opacity:0.3;border:1px solid #F0F0EE !important;cursor:pointer;}.editAreaSeparatorLine {margin:1px 2px;background-color:#C0C0BB;width:2px;height:18px;}#processing{display:none;background-color:#ECE9D8;border:solid #888 1px;position:absolute;top:0;left:0;width:100%;height:100%;z-index:100;text-align:center;}#processing_text{position:absolute;left:50%;top:50%;width:200px;height:20px;margin-left:-100px;margin-top:-10px;text-align:center;}#tab_browsing_area{display:none;background-color:#CCC9A8;border-top:1px solid #888;text-align:left;margin:0;}#tab_browsing_list {padding:0;margin:0;list-style-type:none;white-space:nowrap;}#tab_browsing_list li {float:left;margin:-1px;}#tab_browsing_list a {position:relative;display:block;text-decoration:none;float:left;cursor:pointer;line-height:14px;}#tab_browsing_list a span {display:block;color:#000;background:#ECE9D8;border:1px solid #888;border-width:1px 1px 0;text-align:center;padding:2px 2px 1px 4px;position:relative;}#tab_browsing_list a b {display:block;border-bottom:2px solid #617994;}#tab_browsing_list a .edited {display:none;}#tab_browsing_list a.edited .edited {display:inline;}#tab_browsing_list a img{margin-left:7px;}#tab_browsing_list a.edited img{margin-left:3px;}#tab_browsing_list a:hover span {background:#F4F2E8;border-color:#0A246A;}#tab_browsing_list .selected a span{background:#046380;color:#FFF;}#no_file_selected{height:100%;width:150%;background:#CCC;display:none;z-index:20;position:absolute;}.non_editable #editor{border-width:0 1px;}.non_editable .area_toolbar{display:none;}#auto_completion_area{background:#FFF;border:solid 1px #888;position:absolute;z-index:15;width:280px;height:180px;overflow:auto;display:none;}#auto_completion_area a,#auto_completion_area a:visited{display:block;padding:0 2px 1px;color:#000;text-decoration:none;}#auto_completion_area a:hover,#auto_completion_area a:focus,#auto_completion_area a.focus{background:#D6E1FE;text-decoration:none;}#auto_completion_area ul{margin:0;padding:0;list-style:none inside;}#auto_completion_area li{padding:0;}#auto_completion_area .prefix{font-style:italic;padding:0 3px;}</style>";