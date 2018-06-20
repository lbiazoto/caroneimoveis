/**
* Para usar é bem simples
* carrege esse arquivo em seu html e no onload do body execute
* Mascaras.carregar();
* <body onload="Mascaras.carregar();">
*
* pontro o codigo vai percorrer todoseu html procurando as marcacoes abaixo em seus inputs e aplicando a mascara
*
* insira os seguintes atributos nos seus input
*
* tipo = pode ser numerico ou decimal
* mascara = é a mascara a ser usada coloque # nas posições dos caracteres ex : "##:##"
* casasdecimais = para o caso do tiposer decimal aqui eh dito quantas casas decimais vaum ser usadas
* negativo = isso define um sinal de negativo no inicio do valor
*
* pronto é so isso
* exemplos:
* <input type="text" tipo="numerico"> aqui so da para digitar numeros
* <input type="text" tipo="numerico" negativo=true> aqui so da para digitar numeros e no caso de precionar "-" * umsinal de negativo vai aparecer
* <input type="text" tipo="decimal" negativo=true casasdecimais=3>Decimal
* <input type="text" tipo="numerico" mascara="##/##/####"> data
* <input type="text" tipo="numerico" mascara="###.###.###-##"> cpf
*
**/

Mascaras = {
IsIE: navigator.appName.toLowerCase().indexOf('microsoft')!=-1,
AZ: /[A-Z]/i,
Acentos: /[À-ÿ]/i,
Num: /[0-9]/,
carregar: function(parte){
 	var Tags = ['input','textarea'];
 if (typeof parte == "undefined") parte = document;
 for(var z=0;z<Tags.length;z++){
  Inputs=parte.getElementsByTagName(Tags[z]);
  for(var i=0;i<Inputs.length;i++)
   if(('button,image,hidden,submit,reset').indexOf(Inputs[i].type.toLowerCase())==-1)
    this.aplicar(Inputs[i]);
 }
},
aplicar: function(campo){
 tipo = campo.getAttribute('tipo');
 if (!tipo || campo.type == "select-one") return;
 orientacao = campo.getAttribute('orientacao');
 mascara = campo.getAttribute('mascara');
 if (tipo.toLowerCase() == "decimal"){
  orientacao = "esquerda";
  casasdecimais = campo.getAttribute('casasdecimais');
  tamanho = campo.getAttribute('maxLength');
  if (!tamanho || tamanho > 50)
   tamanho = 12;
  if (!casasdecimais)
   casasdecimais = 2;
  campo.setAttribute("mascara", this.geraMascaraDecimal(tamanho, casasdecimais));
  campo.setAttribute("tipo", "numerico");
  campo.setAttribute("orientacao", orientacao);
 }
 if (orientacao && orientacao.toLowerCase() == "esquerda") campo.style.textAlign = "right";
 if (mascara) campo.setAttribute("maxLength", mascara.length);
 if (tipo){
  campo.onkeypress = function(e){ return Mascaras.onkeypress(e?e:event); };
  campo.onkeyup = function(e){ Mascaras.onkeyup(e?e:event, campo) };
 }
 campo.setAttribute("snegativo", ((campo.value).substr(0,1) == "-" ? "s" : "n"));
},
onkeypress: function(e){
 KeyCode = this.IsIE ? event.keyCode : e.which;
 campo =  this.IsIE ? event.srcElement : e.target;
 readonly = campo.getAttribute('readonly');
 if (readonly) return;
 maxlength = campo.getAttribute('maxlength');
 pt = campo.getAttribute('pt');
 selecao = this.selecao(campo);
 if (selecao.length > 0 && KeyCode != 0){
  campo.value = ""; return true;
 }
 if (KeyCode == 0) return true;
 Char = String.fromCharCode(KeyCode);
 valor = campo.value;
 mascara = campo.getAttribute('mascara');
 if (KeyCode != 8){
  tipo = campo.getAttribute('tipo').toLowerCase();
  negativo = campo.getAttribute('negativo');
  if(negativo && KeyCode == 45){
   snegativo = campo.getAttribute('snegativo');
   snegativo = (snegativo == "s" ? "n" : "s");
   campo.setAttribute("snegativo", snegativo);
  }else{
   valor += Char
   if (tipo == "numerico" && Char.search(this.Num) == -1) return false;
   if (KeyCode != 32 && tipo == "caracter" && Char.search(this.AZ) == -1 && Char.search(this.Acentos) == -1) return false;
  }
 }
 if (mascara){
  this.aplicarMascara(campo, valor);
  return false;
 }
 return true;
},
onkeyup: function(e, campo){
 KeyCode = this.IsIE ? event.keyCode : e.which;
 if (KeyCode != 9 && KeyCode != 16 && KeyCode != 109){
  valor = campo.value;
  if (KeyCode == 8 && !this.IsIE) valor = valor.substr(0,valor.length-1);
  this.aplicarMascara(campo, valor);
 }
},
aplicarMascara: function(campo, valor){
 mascara = campo.getAttribute('mascara');
 if (!mascara) return;
 negativo = campo.getAttribute('negativo');
 snegativo = campo.getAttribute('snegativo');
 if (negativo && valor.substr(0,1) == "-")
  valor = valor.substr(1,valor.length-1);
 orientacao = campo.getAttribute('orientacao');
 var i = 0;
 for(i=0;i<mascara.length;i++){
  caracter = mascara.substr(i,1);
  if (caracter != "#") valor = valor.replace(caracter, "");
 }
 retorno = "";
 if (orientacao != "esquerda"){
  contador = 0;
  for(i=0;i<mascara.length;i++){
   caracter = mascara.substr(i,1);
   if (caracter == "#"){
    retorno += valor.substr(contador,1);
    contador++;
   }else
    retorno += caracter;
   if(contador >= valor.length) break;
  }
 }else{
  contador = valor.length-1;
  for(i=mascara.length-1;i>=0;i--){
   if(contador < 0) break;
   caracter = mascara.substr(i,1);
   if (caracter == "#"){
    retorno = valor.substr(contador,1) + retorno;
    contador--;
   }else
    retorno = caracter + retorno;
  }
 }
 if (negativo && snegativo == "s")
  retorno = "-" + retorno;
 campo.value = retorno;
},
geraMascaraDecimal: function(tam, decimais){
 var retorno = ""; var contador = 0; var i = 0;
 decimais = parseInt(decimais);
 for (i=0;i<(tam-(decimais+1));i++){
  retorno = "#" + retorno;
  contador++;
  if (contador == 3){
   retorno = "." + retorno;
   contador=0;
  }
 }
 retorno = retorno + ",";
 for (i=0;i<decimais;i++) retorno += "#";
 return retorno;
},
selecao: function(campo){
 if (this.IsIE)
  return document.selection.createRange().text;
 else
  return (campo.value).substr(campo.selectionStart, (campo.selectionEnd - campo.selectionStart));
},
formataValor: function (valor, decimais){
 valor = valor.split('.');
 if (valor.length == 1) valor[1] = "";
 for(var i=valor[1].length;i<decimais;i++)
  valor[1] += "0";
 valor[1] = valor[1].substr(0,2);
 return (valor[0] + "." + valor[1]);
}
};


function mouseOver(src,clrOver) {
  if (!src.contains(event.fromElement)) {
	src.style.cursor = 'default';
	src.bgColor = clrOver;
  }
}

function mouseOut(src,clrIn) {
  if (!src.contains(event.toElement)) {
	src.style.cursor = 'default';
	src.bgColor = clrIn;
  }
}


	var tableWidget_okToSort = true;
	var tableWidget_arraySort = new Array();
	tableWidget_tableCounter = 1;
	var activeColumn = new Array();
	var currentColumn = false;

	function sortNumeric(a,b){

		a = a.replace(/,/,'.');
		b = b.replace(/,/,'.');
		a = a.replace(/[^\d\.\/]/g,'');
		b = b.replace(/[^\d\.\/]/g,'');
		if(a.indexOf('/')>=0)a = eval(a);
		if(b.indexOf('/')>=0)b = eval(b);
		return a/1 - b/1;
	}


	function sortString(a, b) {

	  if ( a.toUpperCase() < b.toUpperCase() ) return -1;
	  if ( a.toUpperCase() > b.toUpperCase() ) return 1;
	  return 0;
	}

	function sortTable()
	{
		if(!tableWidget_okToSort)return;
		tableWidget_okToSort = false;
		/* Getting index of current column */
		var obj = this;
		var indexThis = 0;
		while(obj.previousSibling){
			obj = obj.previousSibling;
			if(obj.tagName=='TH')indexThis++;
		}

		if(this.getAttribute('direction') || this.direction){
			direction = this.getAttribute('direction');
			if(navigator.userAgent.indexOf('Opera')>=0)direction = this.direction;
			if(direction=='ascending'){
				direction = 'descending';
				this.setAttribute('direction','descending');
				this.direction = 'descending';
			}else{
				direction = 'ascending';
				this.setAttribute('direction','ascending');
				this.direction = 'ascending';
			}
		}else{
			direction = 'ascending';
			this.setAttribute('direction','ascending');
			this.direction = 'ascending';
		}

		var tableObj = this.parentNode.parentNode.parentNode;
		var tBody = tableObj.getElementsByTagName('TBODY')[0];

		var widgetIndex = tableObj.getAttribute('tableIndex');
		if(!widgetIndex)widgetIndex = tableObj.tableIndex;

		if(currentColumn)currentColumn.className='';
		document.getElementById('col' + widgetIndex + '_' + (indexThis+1)).className='highlightedColumn';
		currentColumn = document.getElementById('col' + widgetIndex + '_' + (indexThis+1));


		var sortMethod = tableWidget_arraySort[widgetIndex][indexThis]; // N = numeric, S = String
		if(activeColumn[widgetIndex] && activeColumn[widgetIndex]!=this){
			if(activeColumn[widgetIndex])activeColumn[widgetIndex].removeAttribute('direction');
		}

		activeColumn[widgetIndex] = this;

		var cellArray = new Array();
		var cellObjArray = new Array();
		for(var no=1;no<tableObj.rows.length;no++){
			var content= tableObj.rows[no].cells[indexThis].innerHTML+'';
			cellArray.push(content);
			cellObjArray.push(tableObj.rows[no].cells[indexThis]);
		}

		if(sortMethod=='N'){
			cellArray = cellArray.sort(sortNumeric);
		}else{
			cellArray = cellArray.sort(sortString);
		}

		if(direction=='descending'){
			for(var no=cellArray.length;no>=0;no--){
				for(var no2=0;no2<cellObjArray.length;no2++){
					if(cellObjArray[no2].innerHTML == cellArray[no] && !cellObjArray[no2].getAttribute('allreadySorted')){
						cellObjArray[no2].setAttribute('allreadySorted','1');
						tBody.appendChild(cellObjArray[no2].parentNode);
					}
				}
			}
		}else{
			for(var no=0;no<cellArray.length;no++){
				for(var no2=0;no2<cellObjArray.length;no2++){
					if(cellObjArray[no2].innerHTML == cellArray[no] && !cellObjArray[no2].getAttribute('allreadySorted')){
						cellObjArray[no2].setAttribute('allreadySorted','1');
						tBody.appendChild(cellObjArray[no2].parentNode);
					}
				}
			}
		}

		for(var no2=0;no2<cellObjArray.length;no2++){
			cellObjArray[no2].removeAttribute('allreadySorted');
		}

		tableWidget_okToSort = true;


	}
	function initSortTable(objId,sortArray)
	{
		var obj = document.getElementById(objId);
		obj.setAttribute('tableIndex',tableWidget_tableCounter);
		obj.tableIndex = tableWidget_tableCounter;
		tableWidget_arraySort[tableWidget_tableCounter] = sortArray;
		var tHead = obj.getElementsByTagName('THEAD')[0];
		var cells = tHead.getElementsByTagName('TH');
		for(var no=0;no<cells.length;no++){
			if(sortArray[no]){
				cells[no].onclick = sortTable;
			}else{
				cells[no].style.cursor = 'default';
			}
		}
		for(var no2=0;no2<sortArray.length;no2++){	/* Right align numeric cells */
			if(sortArray[no2] && sortArray[no2]=='N')obj.rows[0].cells[no2].style.textAlign='right';
		}

		tableWidget_tableCounter++;
	}


	var arrayOfRolloverClasses = new Array();
	var arrayOfClickClasses = new Array();
	var activeRow = false;
	var activeRowClickArray = new Array();

	function highlightTableRow()
	{
		var tableObj = this.parentNode;
		if(tableObj.tagName!='TABLE')tableObj = tableObj.parentNode;

		if(this!=activeRow){
			this.setAttribute('origCl',this.className);
			this.origCl = this.className;
		}
		this.className = arrayOfRolloverClasses[tableObj.id];

		activeRow = this;

	}

	function clickOnTableRow()
	{
		var tableObj = this.parentNode;
		if(tableObj.tagName!='TABLE')tableObj = tableObj.parentNode;

		if(activeRowClickArray[tableObj.id] && this!=activeRowClickArray[tableObj.id]){
			activeRowClickArray[tableObj.id].className='';
		}
		this.className = arrayOfClickClasses[tableObj.id];

		activeRowClickArray[tableObj.id] = this;

	}

	function resetRowStyle()
	{
		var tableObj = this.parentNode;
		if(tableObj.tagName!='TABLE')tableObj = tableObj.parentNode;

		if(activeRowClickArray[tableObj.id] && this==activeRowClickArray[tableObj.id]){
			this.className = arrayOfClickClasses[tableObj.id];
			return;
		}

		var origCl = this.getAttribute('origCl');
		if(!origCl)origCl = this.origCl;
		this.className=origCl;

	}

	function addTableRolloverEffect(tableId,whichClass,whichClassOnClick)
	{
		arrayOfRolloverClasses[tableId] = whichClass;
		arrayOfClickClasses[tableId] = whichClassOnClick;

		var tableObj = document.getElementById(tableId);
		var tBody = tableObj.getElementsByTagName('TBODY');
		if(tBody){
			var rows = tBody[0].getElementsByTagName('TR');
		}else{
			var rows = tableObj.getElementsByTagName('TR');
		}
		for(var no=0;no<rows.length;no++){
			rows[no].onmouseover = highlightTableRow;
			rows[no].onmouseout = resetRowStyle;

			if(whichClassOnClick){
				rows[no].onclick = clickOnTableRow;
			}
		}

	}