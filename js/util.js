function confirmaExclusao(mensagem) {
	// a mensagem a ser exibida na confirmação pode ser passada como referencia, caso contrário é utilizada a mensagem padrão
	if(mensagem==undefined)
		mensagem='Você tem certeza que deseja excluir?';
	if(confirm(mensagem)){
		this.href;
		return true;
	}else{
		return false;
	}
}

function showHideReg(id) {
 var obj = document.getElementById(id);
 if(obj.style.display == "") {
  obj.style.display = "none";
 } else {
  obj.style.display = "";
 }
}

function hide(id) {
 var obj = document.getElementById(id);
 obj.style.display = "none";
}

function show(id) {
 var obj = document.getElementById(id);
  obj.style.display = "";
}

function functionToOnMouseOver(id) {
	var obj = document.getElementById(id);
	obj.style.display = "";
}


function functionToOnMouseOut(id) {
		var obj = document.getElementById(id);
		obj.style.display = "none";

}

function onChangeFocus(id)
{
	 id.style.backgroundColor='#EDEDED';
}

function onLostFocus(id)
{
	 id.style.backgroundColor='#FFFFFF';
}
function setFocus(id)
{
	var obj = document.getElementById(id);
	if(obj)
	{
		obj.focus();
	}
}

var tgs = new Array( 'div' );

//Specify spectrum of different font sizes:
var szs = new Array( '9','10','11','12','13','14','15' );
var startSz = 2;

function ts( trgt,inc ) {
	if (!document.getElementById)
	return
	var d = document,cEl = null,sz = startSz,i,j,cTags;
	sz += inc;
	if ( sz < 0 ) sz = 0;
	if ( sz > 6 ) sz = 6;
	startSz = sz;
	if ( !( cEl = d.getElementById( trgt ) ) ) cEl = d.getElementsByTagName( trgt )[ 0 ];

	cEl.style.fontSize = szs[ sz ];

	for ( i = 0; i < tgs.length; i++ )
	{
		cTags = cEl.getElementsByTagName( tgs[ i ] );
		for ( j = 0; j < cTags.length; j++ )
			cTags[ j ].style.fontSize = szs[ sz ];
	}
}

function menu() {

   var navItems = document.getElementById("menu_dropdown").getElementsByTagName("li");

   for (var i=0; i< navItems.length; i++) {
      if(navItems[i].className == "submenu")
      {
         if(navItems[i].getElementsByTagName('ul')[0] != null)
         {
            navItems[i].onmouseover=function() {this.getElementsByTagName('ul')[0].style.display="block";this.style.backgroundColor = "#f9f9f9";}
            navItems[i].onmouseout=function() {this.getElementsByTagName('ul')[0].style.display="none";this.style.backgroundColor = "#FFFFFF";}
         }
      }
   }

}

function validaSite(site){
	siteCampo = site.value;
    siteCampo=siteCampo.replace(/^http:\/\/?/,"")
    dominio=siteCampo
    caminho=""
    if(siteCampo.indexOf("/")>-1)
        dominio=siteCampo.split("/")[0]
        caminho=siteCampo.replace(/[^\/]*/,"")
    dominio=dominio.replace(/[^\w\.\+-:@]/g,"")
    caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"")
    caminho=caminho.replace(/([\?&])=/,"$1")
    if(caminho!="")dominio=dominio.replace(/\.+$/,"")
    siteCampo="http://"+dominio+caminho
    site.value = siteCampo;
}

function campoObrigatorio(id)
{
	if(id.value == "")
	{
		alert("Campo Obrigatório!");
		id.focus();
		return false;
	}
	return true;
}
function camposObrigatorios(valores)
{
	var obj;
	var i = 1;
	while(i<=valores.length)
	{
		obj = document.getElementById(valores[i]);
 		if(obj.value == "")
		{
			obj.focus();
			alert("Você deve preencher todos os campos obrigatórios");
			return false;
		}
		if(obj.value == "000")
		{
			obj.focus();
			alert("Você deve preencher todos os campos obrigatórios");
			return false;
		}
		i++;
	}
	return true;
}

function umCampoMaiorZero(valores)
{
	var obj;
	var i = 1;
	while(i<=valores.length)
	{
		obj = document.getElementById(valores[i]);
		if(obj.value > 0)
		{
			return true;
		}
		i++;
	}
	document.getElementById(valores[1]).focus();
	alert("Você deve preencher pelo menos uma quantidade com um valor maior que zero");
	return false;
}

function criaArray(n)
{
	this.length = n;
	for(var i = 1;i<=n;i++)
	{
		this[i] = "";
	}
}

function validaCPF(cpfValor)
{
	var i;
	s = cpfValor.value;
	s = s.replace(/\./g,"");
	s = s.replace(/\-/g,"");
	var c = s.substr(0,9);
	var dv = s.substr(9,2);
	var d1 = 0;
	for (i = 0; i < 9; i++)
	{
		d1 += c.charAt(i)*(10-i);
	}
	if (d1 == 0)
	{
		alert("CPF Inválido");
		cpfValor.value="";
		cpfValor.focus();
		return false;
	}
	d1 = 11 - (d1 % 11);
	if (d1 > 9)
		d1 = 0;
	if (dv.charAt(0) != d1)
	{
		alert("CPF Inválido");
		cpfValor.focus();
		cpfValor.value="";
		return false;
	}
	d1 *= 2;
	for (i = 0; i < 9; i++)
	{
		d1 += c.charAt(i)*(11-i);
	}
	d1 = 11 - (d1 % 11);
	if (d1 > 9)
		d1 = 0;
	if (dv.charAt(1) != d1)
	{
		alert("CPF Inválido");
		cpfValor.value="";
		cpfValor.focus();
		return false;
	}
	return true;
}
function validaEmail(email)
{
    parte1 = email.value.indexOf("@");
    parte2 = email.value.indexOf(".");
    parte3 = email.value.length;
    if (!(parte1 >= 1 && parte2 >= 3 && parte3 >= 5))
    {
	     alert ("O campo \"E-mail\" deve conter um endereço eletrônico válido!\nFormato: nome@seuprovedor.com");
	     email.focus();
	     return false;
    }
    return true;
}

function validaSeparador(separador)
{
	if((separador != '.') && (separador != '@') && !isNumber(separador) && !isChar(separador))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function validaCEP(cep)
{
    cepValue = cep.value;
	cepValue = cepValue.replace(/\-/g,"");
	parte1 = cepValue.length;
    if (parte1 < 8)
    {
	     alert ("O campo \"CEP\" está incorreto!\nFormato: 99999-999");
	     cep.focus();
	     return false;
    }
    return true;
}
function validaData(data)
{
    dataValue = data.value;
	dataValue = dataValue.replace(/\//g,"");
	parte1 = dataValue.length;
    if (parte1 < 8)
    {
	     alert ("O campo \"Data\" está incorreto!\nFormato: dd/mm/aaaa");
	     data.focus();
	     return false;
    }
    return true;
}
function validaHora(hora)
{
    horaValue = hora.value;
	horaValue = horaValue.replace(/\:/g,"");
	parte1 = horaValue.length;
    if (parte1 < 4)
    {
	     alert ("O campo \"Hora\" está incorreto!\nFormato: hh:mm");
	     hora.focus();
	     return false;
    }
    return true;
}

function validaCNPJ(cnpjPass)
{
	CNPJ = cnpjPass.value;
	erro = new String;
	if (CNPJ.length < 18) erro += "É necessario preencher corretamente o número do CNPJ! \n\n";
	if ((CNPJ.charAt(2) != ".") || (CNPJ.charAt(6) != ".") || (CNPJ.charAt(10) != "/") || (CNPJ.charAt(15) != "-"))
	{
		if (erro.length == 0) erro += "É necessário preencher corretamente o número do CNPJ! \n\n";
	}
	//substituir os caracteres que não são números
	if(document.layers && parseInt(navigator.appVersion) == 4)
	{
	      x = CNPJ.substring(0,2);
	      x += CNPJ. substring (3,6);
	      x += CNPJ. substring (7,10);
	      x += CNPJ. substring (11,15);
	      x += CNPJ. substring (16,18);
	      CNPJ = x;
	}else
	{
	      CNPJ = CNPJ. replace (".","");
	      CNPJ = CNPJ. replace (".","");
	      CNPJ = CNPJ. replace ("-","");
	      CNPJ = CNPJ. replace ("/","");
	}
	var nonNumbers = /\D/;
	if (nonNumbers.test(CNPJ)) erro += "A verificação de CNPJ suporta apenas números! \n\n";
	var a = [];
	var b = new Number;
	var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
	for (i=0; i<12; i++)
	{
		a[i] = CNPJ.charAt(i);
		b += a[i] * c[i+1];
	}
	if ((x = b % 11) < 2)
	{
		a[12] = 0;
	}else
	{
		a[12] = 11-x;
	}
	b = 0;
	for (y=0; y<13; y++)
	{
	    b += (a[y] * c[y]);
	}
	if ((x = b % 11) < 2)
	{
		a[13] = 0;
	}else
	{
		a[13] = 11-x;
	}
	if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13]))
	{
	      erro +="Dígito verificador com problema!";
	}
	if (erro.length > 0)
	{
		alert(erro);
		cnpjPass.focus();
		return false;
	}
return true;
}
// Custom event handler
function myCustomExecCommandHandler(editor_id, elm, command, user_interface, value)
{
	var linkElm, imageElm, inst;

	switch (command)
	{
		case "mceLink":
			inst = tinyMCE.getInstanceById(editor_id);
			linkElm = tinyMCE.getParentElement(inst.selection.getFocusElement(), "a");

			if (linkElm)
				alert("Link dialog has been overriden. Found link href: " + tinyMCE.getAttrib(linkElm, "href"));
			else
				alert("Link dialog has been overriden.");

			return true;

		case "mceImage":
			inst = tinyMCE.getInstanceById(editor_id);
			imageElm = tinyMCE.getParentElement(inst.selection.getFocusElement(), "img");

			if (imageElm)
				alert("Image dialog has been overriden. Found image src: " + tinyMCE.getAttrib(imageElm, "src"));
			else
				alert("Image dialog has been overriden.");

			return true;
	}

	return false; // Pass to next handler in chain
}
// Custom save callback, gets called when the contents is to be submitted
function customSave(id, content)
{
	alert(id + "=" + content);
}

function myFileBrowser (field_name, url, type, win) {

// alert("Field_Name: " + field_name + "\nURL: " + url + "\nType: " + type + "\nWin: " + win); // debug/testing

/* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
   the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
   These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */

var cmsURL = window.location.pathname;      // script URL
var searchString = window.location.search;  // possible parameters
if (searchString.length < 1) {
    // add "?" to the URL to include parameters (in other words: create a search string because there wasn't one before)
    searchString = "?";
}

// newer writing style of the TinyMCE developers for tinyMCE.openWindow

tinyMCE.openWindow({
    file : cmsURL + searchString + "&type=" + type, // PHP session ID is now included if there is one at all
    title : "File Browser",
    width : 420,  // Your dimensions may differ - toy around with them!
    height : 400,
    close_previous : "no"
}, {
    window : win,
    input : field_name,
    resizable : "yes",
    inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
    editor_id : tinyMCE.getWindowArg("editor_id")
});
return false;
}

/**
 *
 * @access public
 * @return void
 **/
function cmc7(valor)
{
	var banco2 = valor.substring(1,4);
	var agencia2 = valor.substring(4,8);
	var dv12 = valor.substring(8,10);
	var sirc2 = valor.substring(11,14);
	var numero2 = valor.substring(13,19);
	var tipo2 = valor.substring(20,21);
	var dv22 = valor.substring(21,22);
	var conta2 = valor.substring(22,32);
	var dv32 = valor.substring(35,37);

	var campo1 = document.getElementById('codigoBanco');
	campo1.setAttribute('value',banco2);
	var campo2 = document.getElementById('agencia');
	campo2.value = agencia2;
	var campo3 = document.getElementById('conta');
	campo3.value = conta2;
	var campo4 = document.getElementById('numero');
	campo4.value = numero2;
}

function abreLink(link)
{
	window.location = link;
}

function cancelEvent()
{
	return false;
}
function controle(tecla)
{
		cancelEvent();
		if(tecla==112)
		{
			if(variaF1!="")
			{
				abreLink(variaF1);
			}else
			{
				alert('Tecla [F1] não configurada!\nPara configurar vá em Opções - Configuração - Atalhos');
			}
		}
}

function evento(e)
{
	if(e.keyCode==112){
		if(variaF1!="")
		{
			abreLink(variaF1);
		}else
		{
			alert('Tecla [F1] não configurada!\nPara configurar vá em Opções - Configuração - Atalhos');
		}
		return false;
	}
	if(e.keyCode==113){
		if(variaF2!="")
		{
			abreLink(variaF2);
		}else
		{
			alert('Tecla [F2] não configurada!\nPara configurar vá em Opções - Configuração - Atalhos');
		}
		return false;
	}
	if(e.keyCode==114){
		if(variaF3!="")
		{
			abreLink(variaF3);
		}else
		{
			alert('Tecla [F3] não configurada!\nPara configurar vá em Opções - Configuração - Atalhos');
		}
		return false;
	}
	if(e.keyCode==115){
		if(variaF4!="")
		{
			abreLink(variaF4);
		}else
		{
			alert('Tecla [F4] não configurada!\nPara configurar vá em Opções - Configuração - Atalhos');
		}
		return false;
	}
	if(e.keyCode==116){
		if(variaF5!="")
		{
			abreLink(variaF5);
		}else
		{
			alert('Tecla [F5] não configurada!\nPara configurar vá em Opções - Configuração - Atalhos');
		}
		return false;
	}
	if(e.keyCode==117){
		if(variaF6!="")
		{
			abreLink(variaF6);
		}else
		{
			alert('Tecla [F6] não configurada!\nPara configurar vá em Opções - Configuração - Atalhos');
		}
		return false;
	}
	if(e.keyCode==118){
		if(variaF7!="")
		{
			abreLink(variaF7);
		}else
		{
			alert('Tecla [F7] não configurada!\nPara configurar vá em Opções - Configuração - Atalhos');
		}
		return false;
	}
	if(e.keyCode==119){
		if(variaF8!="")
		{
			abreLink(variaF8);
		}else
		{
			alert('Tecla [F8] não configurada!\nPara configurar vá em Opções - Configuração - Atalhos');
		}
		return false;
	}
	if(e.keyCode==120){
		if(variaF9!="")
		{
			abreLink(variaF9);
		}else
		{
			alert('Tecla [F9] não configurada!\nPara configurar vá em Opções - Configuração - Atalhos');
		}
		return false;
	}
	if(e.keyCode==121){
		if(variaF10!="")
		{
			abreLink(variaF10);
		}else
		{
			alert('Tecla [F10] não configurada!\nPara configurar vá em Opções - Configuração - Atalhos');
		}
		return false;
	}
	if(e.keyCode==122){
		if(variaF11!="")
		{
			abreLink(variaF11);
		}else
		{
			alert('Tecla [F11] não configurada!\nPara configurar vá em Opções - Configuração - Atalhos');
		}
		return false;
	}
	if(e.keyCode==123){
		if(variaF12!="")
		{
			abreLink(variaF12);
		}else
		{
			alert('Tecla [F12] não configurada!\nPara configurar vá em Opções - Configuração - Atalhos');
		}
		return false;
	}
}

function alertaTecla()
 {
  var tecla = window.event.keyCode;
  alert(tecla);
  event.keyCode=0;
  event.returnValue=false;

 }



nereidFadeObjects = new Object();
nereidFadeTimers = new Object();

function sourceNum(obj){
	if ((document.documentElement.sourceIndex*1)+1)
	return obj.sourceIndex;
	else if (document.getElementsByTagName)
	var order=document.getElementsByTagName('*')
	for (var i_tem = 0; i_tem < order.length; i_tem++)
	if (order[i_tem]==obj)
	return i_tem;
}

function nereidFade(object, destOp, rate, delta){
	if (object.toString().indexOf('object') == -1){  //do this so I can take a string too
		setTimeout("nereidFade("+object+","+destOp+","+rate+","+delta+")",0);
		return;
	}
	if (!(object.filters||object.style.MozOpacity||object.style.opacity))
		return;
	var objOpac=object.filters? object.filters.alpha.opacity : object.style.MozOpacity? object.style.MozOpacity*100 : object.style.opacity? object.style.opacity*100 : null
	clearTimeout(nereidFadeTimers[sourceNum(object)]);

	diff = destOp-objOpac;
	direction = 1;
	if (objOpac!==null&&objOpac > destOp){
		direction = -1;
	}
	delta=Math.min(direction*diff,delta);
	if (object.filters)
		object.filters.alpha.opacity+=direction*delta;
	else if (object.style.MozOpacity)
		object.style.MozOpacity=(object.style.MozOpacity*1)+(direction*delta/100);
	else if (object.style.opacity)
		object.style.opacity=(object.style.opacity*1)+(direction*delta/100);

	objOpac=object.filters? object.filters.alpha.opacity : object.style.MozOpacity? object.style.MozOpacity*100 : object.style.opacity? object.style.opacity*100 : null

	if (objOpac!==null&&objOpac != destOp){
		nereidFadeObjects[sourceNum(object)]=object;
		nereidFadeTimers[sourceNum(object)]=setTimeout("nereidFade(nereidFadeObjects["+sourceNum(object)+"],"+destOp+","+rate+","+delta+")",rate);
	}
}