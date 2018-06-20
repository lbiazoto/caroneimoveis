function validaInputText(valor, idMensagem, mensagem)
{
	var obj_msg = document.getElementById(idMensagem);
	var txt = valor.value;
	if (txt.length >= 1)
	{
		obj_msg.className = "none";
		obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
	}
	else
	{
		obj_msg.className = "obrigatorio";
		obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>" + mensagem;
	}
}
function validaArquivo(valor)
{
	var obj_msg = document.getElementById("msgArquivo");
	var txt = valor.value;
	var txt2 = valor.text;
	if (txt.length > 0)
	{
		var extensoesOk = "jpg,gif,png,jpeg,";
		var vetor = txt.split(".");
		var tamanho = vetor.length;
		tamanho--;
		var extensao = vetor[tamanho].toLowerCase();
		if(extensoesOk.indexOf( extensao ) == -1)
		{
			obj_msg.className = "errado";
			obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/errado.png'></div> Extensão inválida.";
		}
		else
		{
			obj_msg.className = "none";
			obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
		}
	}
	else
	{
		obj_msg.className = "obrigatorio";
		obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> Largura recomendada: 920px.";
	}
}
function validaArquivoOnSubmit(id)
{
	var obj = document.getElementById(id);
	var valor = obj.value;
	if(valor == "")
	{
		alert("Campo Obrigatório!");
		obj.focus();
		return false;
	}
	if (valor.length > 0)
	{
		var extensoesOk = "jpg,gif,png,jpeg,";
		var vetor = valor.split(".");
		var tamanho = vetor.length;
		tamanho--;
		var extensao = vetor[tamanho].toLowerCase();
		if(extensoesOk.indexOf( extensao ) == -1)
		{
			alert("O arquivo deve ter uma das extensões permitidas:\n \"" + extensoesOk + "\".");
			obj.focus();
			return false;
		}
		else
		{
			obj_msg.className = "none";
			obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
		}
	}
	else
	{
		alert("O arquivo deve ter uma das extensões permitidas:\n \"" + extensoesOk + "\".");
		obj.focus();
		return false;
	}
}
function validaSelect(valor, idMensagem)
{
	var obj_msg = document.getElementById(idMensagem);
	obj_msg.className = "none";
	obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
}
function validaEmailForm(valor)
			{
				var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
				var obj_msg = document.getElementById("msgEmail");
				var mail = valor.value;

				if(typeof(mail) == "string")
				{
		        	if(er.test(mail))
					{
						obj_msg.className = "none";
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
					}
					else
					{
		                obj_msg.className = "obrigatorio";
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> E-mail válido. (nome@provedor.com)";
		            }
		        }
				else
				{
					if(typeof(mail) == "object")
					{
		                if(er.test(mail.value))
						{
		                    obj_msg.className = "none";
							obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
		                }
		        	}
					else
					{
		                obj_msg.className = "obrigatorio";
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> E-mail válido. (nome@provedor.com)";
		            }
				}
			}
			function validaEmailOnSubmit(id)
			{
				var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
				var obj = document.getElementById(id);
				var mail = obj.value;
				if(mail == "")
				{
					alert("Campo Obrigatório!");
					obj.focus();
					return false;
				}
				if(typeof(mail) == "string")
				{
		        	if(er.test(mail))
					{
						return true;
					}
					else
					{
		                alert("O campo \"E-mail\" deve conter um endereço eletrônico válido!\nFormato: nome@seuprovedor.com!");
						obj.focus();
						return false;
		            }
		        }
				else
				{
					if(typeof(mail) == "object")
					{
		                if(er.test(mail.value))
						{
		                    return true;
		                }
		        	}
					else
					{
		                alert("O campo \"E-mail\" deve conter um endereço eletrônico válido!\nFormato: nome@seuprovedor.com!");
						obj.focus();
						return false;
		            }
				}
			}