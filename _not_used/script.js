// ondblclick="javascript:popup_url('imgtype-edit.php?id=$imgtype_id')"
function popup_blank(url) {
	width = (arguments.length >= 1) ? arguments[1] : "";
	height = (arguments.length >= 2) ? arguments[2] : "";
	window_name = (arguments.length >= 3) ? arguments[3] : "";
	params = (arguments.length >= 4) ? arguments[4] : "";

//	params = ""
	if (params == "") {
		params = "resizable=1,scrollbars=1,toolbar=0,location=0,directories=0,status=1,menubar=0"
	} else if (params == "clean") {
		params = "resizable=1,scrollbars=1,toolbar=1,location=1,directories=1,status=1,menubar=1"
	}

	if (width != "") {
		if (params != "") params += ","
		params += "width=" + width
	}
	if (height != "") {
		if (params != "") params += ","
		params += "height=" + height
	}

//	alert(params)
	popup_win = window.open(url, window_name, params);
	popup_win.focus();
	return popup_win;
}

function popup_url(url) {
	window_name = (arguments.length >= 2) ? arguments[1] : "";
//	alert(window_name)
	window_params = (arguments.length >= 3) ? arguments[2] : "resizable=1,scrollbars=1,toolbar=0,location=0,directories=0,status=1,menubar=0";
//	alert(window_params)
	popup_win = window.open(url, window_name, window_params);
	popup_win.focus();
}

function popup_imgurl(imgurl, width, height) {
	p_width = width + 40
	p_height = height + 70
	
	popup_win = window.open("_popup_imgurl.php?imgurl=" + imgurl + "&width=" + width + "&height=" + height, "",
		"resizable=1,scrollbars=1,toolbar=0,location=0,directories=0,status=1,menubar=0,width="+p_width+",height="+p_height);
	popup_win.focus();
}

function popup_img(img_id, width, height){
	width += 70
	height += 120
	
	if (width > 900) width = 900
	if (height > 700) height = 700
//	if (width < 320) width = 320
//	if (height < 200) height = 200

	popup_win = window.open("_popup_img.php?img_id=" + img_id, "img_" + img_id, "resizable=1,scrollbars=1,toolbar=0,location=0,directories=0,status=0,menubar=0,width="+width+",height="+height)
	popup_win.focus()
}

function popup_entityimg(entity, entity_id, imgfield, width, height){
	width += 40
	height += 70
	
	popup_win = window.open("_popup_entityimg.php?entity=" + entity + "&entity_id=" + entity_id + "&imgfield=" + imgfield, entity + "_" + entity_id + "_" + imgfield,
		"resizable=1,scrollbars=1,toolbar=0,location=0,directories=0,status=0,menubar=0,width="+width+",height="+height)
	popup_win.focus()
}

function popup_bo(bo_href) {
	popup_win = window.open("backoffice/" + bo_href);
	popup_win.focus();
}


function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function form_find_it(it_name, form_name) {
	ret = null

	form_name = (arguments.length >= 2) ? arguments[1] : "form_edit";
//	alert(form_name)

	form_element = MM_findObj(form_name)
//	alert(form_element)
	
//	alert(form_edit[it_name])
	if (form_element[it_name]+"~" != "undefined") ret = form_element[it_name]
	
	return ret
}

function layer_isopened(nr) {
	ret = 0
	layer_nr = MM_findObj("layer_" + nr)
//	alert ("layer_open(" + nr + "): " + layer_nr)
	if (layer_nr != null) {
		if (layer_nr.style.display == 'block') ret = 1
	}
	return ret
}

function layer_open(nr) {
	layer_nr = MM_findObj("layer_" + nr)
//	alert ("layer_open(" + nr + "): " + layer_nr)
	if (layer_nr != null) layer_nr.style.display = 'block'

	layer_opened_nr = MM_findObj("layer_opened_nr")
	if (layer_opened_nr != null) layer_opened_nr.value = nr
//	alert ("layer_open(" + nr + "): layer_opened_nr=" + layer_opened_nr.value)
}

function layer_close(nr) {
	layer_nr = MM_findObj("layer_" + nr)
//	alert ("layer_close(" + nr + "): " + layer_nr)
	if (layer_nr != null) layer_nr.style.display = 'none'

	layer_opened_nr = MM_findObj("layer_opened_nr")
	if (layer_opened_nr != null) layer_opened_nr.value = 0
//	alert ("layer_close(" + nr + "): layer_opened_nr=" + layer_opened_nr.value)
}

function layer_switch(nr) {
	for (i = 1; i <= layers_total; i++) {
	    if (i != nr) layer_close(i)
	}

	if (layer_isopened(nr)) layer_close(nr)
	else layer_open(nr)
}

function layer_switch_forceopened(nr) {
	for (i = 1; i <= layers_total; i++) {
	    if (i == nr) layer_open(i)
	    else layer_close(i)
	}
}


function ilayer_open(nr) {
	layer_nr = MM_findObj("layer_" + nr)
//	alert ("layer_open(" + nr + "): " + layer_nr)
	if (layer_nr != null) layer_nr.style.display = 'block'
}

function ilayer_close(nr) {
	layer_nr = MM_findObj("layer_" + nr)
//	alert ("layer_close(" + nr + "): " + layer_nr)
	if (layer_nr != null) layer_nr.style.display = 'none'

}

function ilayer_switch(nr) {
	if (layer_isopened(nr)) ilayer_close(nr)
	else ilayer_open(nr)
}


function img_control_switch(nr) {
	ilayer_switch("img_img_" + nr)
	ilayer_switch("img_img_big_" + nr)

	ilayer_switch("img_hr_" + nr)
	ilayer_switch("img_qresize_" + nr)
	ilayer_switch("img_resize_" + nr)
	ilayer_switch("img_big_qresize_" + nr)
	ilayer_switch("img_big_resize_" + nr)
}


function ilayer_switch_focusing_wrapper(nr) {
	if (layer_isopened(nr)) {
		ilayer_close(nr)
	} else {
		ilayer_open(nr)
		a_focus =  MM_findObj(nr + "_focus_after_open")
		if (a_focus != null) {
//			alert("focusing to " + nr + "_focus_after_open")
			a_focus.focus();
//			location = "#" + nr + "_focus_after_open"
			window.scrollBy(0, 50)
		}
	}
}

function focus_itname(it_name, form_name) {
//	vitem = MM_findObj(it_name)
//	alert(vitem)
//	if (vitem != null) vitem.focus()
	
	form_name = (arguments.length >= 2) ? arguments[1] : "form_edit";
	vitem = form_find_it(it_name, form_name)
	if (vitem != null) vitem.focus()
}


function swap(image, over){
if (document.images){
	document.images[image].src = "img/" + image + (over ? "_over" : "_normal") + ".gif";
	document.images[image + "_shadow"].src = "img/" + image + "_shadow" + (over ? "_over" : "_normal") + ".gif";
	}
}

function swap_class(id, cl){
	var div = document.getElementById(id).style;
	div = "out";
}


function print_area_on() {
	var div = document.getElementById("content");
	div.style.border = "1px dashed #575757";
	div.style.margin = "10px";
}

function print_area_off() {
	var div = document.getElementById("content")
	div.style.border = "0px solid #575757";
	div.style.margin = "11px";
}


function form_login_password_submit(form_login_password_name) {
	form_login_password_name = (arguments.length >= 1) ? arguments[0] : "form_login_password";
//	alert(form_login_password_name)

	form_login_password_element = MM_findObj(form_login_password_name)
//	alert(form_login_password_element)

//	alert(form_login_password_element["l_login"].value)

	a_login = null
	if (form_login_password_element["l_login"]+"~" != "undefined~") {
		a_login = form_login_password_element["l_login"]
	} else {
		alert("form_login_password_element[l_login] is " + form_login_password_element["l_login"])
		return
	}

	a_passwd = null
	if (form_login_password_element["l_passwd"]+"~" != "undefined~") {
		a_passwd = form_login_password_element["l_passwd"]
	} else {
		alert("form_login_password_element[l_passwd] is " + form_login_password_element["l_passwd"])
		return
	}

	if (a_login.value == "") alert ("Вы не указали Логин")
	else if (a_passwd.value == "") alert ("Пароль не может быть пустым")
	else form_login_password_element.submit()
}

function form_login_auth_submit(form_login_auth_name) {
	form_login_auth_name = (arguments.length >= 1) ? arguments[0] : "form_login_auth";
//	alert(form_login_auth_name)

	form_login_auth_element = MM_findObj(form_login_auth_name)
//	alert(form_login_auth_element)

//	alert(form_login_auth_element["l_auth"].value)

	a_auth = null
	if (form_login_auth_element["l_auth"]+"~" != "undefined~") {
		a_auth = form_login_auth_element["l_auth"]
	} else {
		alert("form_login_auth_element[l_auth] is " + form_login_auth_element["l_auth"])
		return
	}

	if (a_auth.value == "") alert ("Вы не указали Токен")
	else form_login_auth_element.submit()
}

function popup_pwreminder(email) {
	popup_win = window.open("reminder-popup.php?email="+email, "pwreminder", "resizable=1,scrollbars=1,toolbar=0,location=0,directoties=0,status=0,menubar=0,width=300,height=270");
	popup_win.focus();
}

function addfav() {
	if (document.all) {
		window.external.AddFavorite("http://richaclub.com","Rich@Club")
	}
}

function popup_radio() {
	window_params = "resizable=1,scrollbars=0,toolbar=0,location=0,directories=0,status=0,menubar=0, width=150, height=150"
	popup_win = window.open("radio.htm", "rc_radio", window_params)
//	popup_win.focus()
}

function popup_facecontrol(mode_force_facecontrol) {
	popup_blank("my_facecontrol.php?popup=1" + mode_force_facecontrol, 720, 600)
}

function message_board_open() {
	person_to = (arguments.length > 0) ? arguments[0] : 0;
	person_recent = (arguments.length > 1) ? arguments[1] : 0;
	params = "resizable=1,scrollbars=1,toolbar=0,location=0,directories=0,status=1,menubar=0,width=640,height=600"
	popup_win = window.open("message_board.php?person_to=" + person_to + "&person_recent=" + person_recent, "message_board", params);
	popup_win.focus();
}

