<?php
	session_start();
	include("cms/util.php");
	include("func.php");
	if($site=="")	$site="home";
	$retornoNews="";

	if($modo=="assinarNewsletter")
		$retornoNews=cadastraNewsletter($nomeNewsletter, $emailNewsletter);
?>
<html>
<head>
	<title>Carone - corretora de im&oacute;veis</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<META NAME="author" CONTENT="BetaG Soluções">
	<META NAME="robots" CONTENT="index,follow">
	<META HTTP-EQUIV="content-language" content="pt-br">
	<META NAME="reply-to" CONTENT="">
	<META NAME="description" CONTENT="">
	<META NAME="keywords" CONTENT="imóveis em joinville, imoveis em joinville, Im&oacute;veis, Santa Catarina, Joinville, Atendimento, Diferenciado, Personalizado, Carone, Corretora de Im&oacute;veis, Aut&ocirc;nomas, Mercado Imobili&aacute;rio">
	<link rel="stylesheet" type="text/css" href="css/default.css">
	<script type="text/javascript" src="js/util.js"></script>
	<script type="text/javascript" src="js/efeito.js"></script>
	<script type="text/javascript" src="js/mascaras.js"></script>
	<script type="text/javascript" src="js/AC_RunActiveContent.js"></script>
	<script type="text/javascript" src="highslide/highslide-with-gallery.js"></script>
	<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
	<script type="text/javascript">
	<!--
	function MM_swapImgRestore() { //v3.0
	  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
	}
	function MM_preloadImages() { //v3.0
	  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
	    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
	    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
	}

	function MM_findObj(n, d) { //v4.01
	  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
	    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
	  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	  if(!x && d.getElementById) x=d.getElementById(n); return x;
	}

	function MM_swapImage() { //v3.0
	  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
	   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
	}
	//-->

	function menu()
	{
	   var navItems = document.getElementById("menu_dropdown").getElementsByTagName("li");

	   for (var i=0; i< navItems.length; i++) {
	      if(navItems[i].className == "submenu")
	      {
	         if(navItems[i].getElementsByTagName('ul')[0] != null)
	         {
	            navItems[i].onmouseover=function() {this.getElementsByTagName('ul')[0].style.display="block";}
	            navItems[i].onmouseout=function() {this.getElementsByTagName('ul')[0].style.display="none";}
	         }
	      }
	   }

	}
    function menu2()
	{
	   var navItems = document.getElementById("menu_dropdown2").getElementsByTagName("li");

	   for (var i=0; i< navItems.length; i++) {
	      if(navItems[i].className == "submenu2")
	      {
	         if(navItems[i].getElementsByTagName('ul')[0] != null)
	         {
	            navItems[i].onmouseover=function() {this.getElementsByTagName('ul')[0].style.display="block";}
	            navItems[i].onmouseout=function() {this.getElementsByTagName('ul')[0].style.display="none";}
	         }
	      }
	   }

	}
</script>
</head>
<body bgcolor="#464646" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="menu2(); menu(); Mascaras.carregar(); MM_preloadImages('images/menuover_06.jpg','images/menuover_07.jpg','images/menuover_08.jpg','images/menuover_09.jpg','images/menuover_10.jpg','images/menuover_11.jpg','images/menuover_12.jpg')">
<table id="Table_01" align="center" width="920" border="0" cellpadding="0" cellspacing="0" style="z-index:10; position:relative;">
	<tr>
		<td colspan="11" align="center" valign="middle" bgcolor="#383431" style="background:url(images/reducao_03.jpg) top center no-repeat;"><a href="index.php"><img src="images/logo_topo.jpg" width="256" height="164" border="0" style="margin:15px;"></a></td>
	</tr>
	<tr>
		<td colspan="9"><img src="images/index_04.jpg" width="929" height="6" alt=""></td>
	</tr>
	<tr>
		<td rowspan="2" style="background:url('images/index_05.jpg') right repeat-y; width:4px;">&nbsp;</td>
		<td><a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image15','','images/<?php if($site!='' || $site!='home') echo 'menuover_06'; else echo 'index_06';?>.jpg',1)"><img src="images/<?php if($site=="" || $site=="home") echo "menuover_06"; else echo "index_06";?>.jpg" name="Image15" width="115" height="52" border="0"></a></td>
		<td><div id="barramenu2" align="center">
				<ul id="menu_dropdown2" class="menubar2">
					<li class="submenu2"><a href="index.php?site=imoveis"  class="menuImoveis"></a>
                        <!--<ul class="menu2" style="z-index:10;">
                            <li><a href="index.php?site=imoveis&tipoImovel=1" class="menuImoveisLocacao" style="padding-bottom:2px;"><img src="images/submenu_locacao.jpg" border="0" width="101" height="28"></a></li>
                            <li><a href="index.php?site=imoveis&tipoImovel=0" class="menuImoveisVenda"><img src="images/submenu_venda.jpg" border="0" width="101" height="28"></a></li>
                        </ul>
                        -->
                    </li>
				</ul>
			</div>
        </td>
		<td><a href="index.php?site=pesquisa" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image17','','images/<?php if($site!='pesquisa') echo 'menuover_08'; else echo 'index_08';?>.jpg',1)"><img src="images/<?php if($site=="pesquisa") echo "menuover_08"; else echo "index_08";?>.jpg" name="Image17" width="105" height="52" border="0"></a></td>
		<td><a href="index.php?site=quemSomos" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image18','','images/<?php if($site!='quemSomos') echo 'menuover_09'; else echo 'index_09';?>.jpg',1)"><img src="images/<?php if($site=="quemSomos") echo "menuover_09"; else echo "index_09";?>.jpg" name="Image18" width="136" height="52" border="0"></a></td>
		<td><div id="barramenu" align="center">
				<ul id="menu_dropdown" class="menubar">
					<li class="submenu">
						<a href="#" class="menuItemProduto"></a>
						<ul class="menu" style="z-index:10;">
							<li><a href="index.php?site=servicos" class="menuServicos"><img src="images/menu_down_13.jpg" width="177" height="28" border="0"></a></li>
							<li><a href="index.php?site=simulacoes" class="menuSimulacoes"><img src="images/menu_down_16.jpg" width="177" height="28" border="0"></a></li>
							<li><a href="index.php?site=dicas" class="menuDicas"><img src="images/menu_down_20.jpg" width="177" height="28" border="0"></a></li>
							<li><a href="index.php?site=nosVoce" class="menuNosVoce"><img src="images/eu_mais_voce_20.jpg" width="177" height="28" border="0"></a></li>
						</ul>
					</li>
				</ul>
			</div>
		</td>
		<td><a href="index.php?site=incluaOseu" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image20','','images/<?php if($site!='incluaOseu') echo 'menuover_11'; else echo 'index_11';?>.jpg',1)"><img src="images/<?php if($site=="incluaOseu") echo "menuover_11"; else echo "index_11";?>.jpg" name="Image20" width="181" height="52" border="0"></a></td>
		<td><a href="index.php?site=contato" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image21','','images/<?php if($site!='contato') echo 'menuover_12'; else echo 'index_12';?>.jpg',1)"><img src="images/<?php if($site=="contato") echo "menuover_12"; else echo "index_12";?>.jpg" name="Image21" width="105" height="52" border="0"></a></td>
		<td rowspan="2" style="background:url('images/index_13.jpg') right repeat-y; width:4px;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="7" bgcolor="#FFFFFF">
        	<?php
				if(!testaInjection($site))
				{
					if(file_exists($site.".php"))
						include($site.".php");
					else
						include("home.php");
				}
				else{
					include("home.php");
				}
			?>
        </td>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" align="center" style="background-color:#383431; height:320px; margin-top:-20px; z-index:3; position:relative;">
	<tr>
    	<td align="center" valign="top">
        	<table width="920" cellpadding="0" cellspacing="0" style="margin-top:30px;">
            	<tr>
                	<td width="255" align="center">
                    	<a href="index.php?site=simulacoes"><img src="images/simulacoes_financeiras_rodape.jpg" width="185" height="218"></a>
                    </td>
                    <td width="5" align="center"><img src="images/separador.jpg" width="1" height="218"></td>
                	<td width="255" align="center">
                    	<a href="index.php?site=nosVoce"><img src="images/nos_vc_objetivo.jpg" width="164" height="218"></a>
                    </td>
                    <td width="5" align="center"><img src="images/separador.jpg" width="1" height="218"></td>
                    <td width="400" align="center">
                    	<img src="images/news_rodape.jpg" width="259" height="117">
                        <form name="formNewsletter" id="formNewsletter" action="index.php?site=<?php print($_GET['site']);?>&modo=assinarNewsletter" method="post">
                            <label><span>Nome: </span><input type="text" id="nomeNewsletter" name="nomeNewsletter" value=""></label>
                            <label><span>Email: </span><input type="text" id="emailNewsletter" name="emailNewsletter" value="">&nbsp;<input type="submit" name="submitNewsletter" value="" onClick="return(campoObrigatorio(nomeNewsletter) && campoObrigatorio(emailNewsletter) && validaEmail(emailNewsletter));"></label>
                            <label><?php if($retornoNews!="") print("Seus dados foram cadastrados com sucesso!");?></label>
                        </form>
                    </td>
                </tr>
                <tr><td colspan="5"></td></tr>
                <tr>
                	<td width="371" align="center">
                    	<ul id="linkRedesSociais">
                        	<li><a target="_blank" href="http://www.facebook.com/pages/Carone-Im%C3%B3veis/242123185829720" class="linkFacebook"></a></li>
                        	<li><a target="_blank" href="http://twitter.com/#!/caroneimoveis" class="linkTwitter"></a></li>
                        	<li><a target="_blank" href="http://www.orkut.com.br/Main#Profile?uid=14574066433341336473" class="linkOrkut"></a></li>
                        </ul>
                        <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com/pages/Carone-Imóveis/242123185829720&amp;layout=button_count&amp;show_faces=false&amp;width=80&amp;action=like&amp;font=trebuchet+ms&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px; margin: 10px; clear:both;" allowTransparency="true"></iframe>
                    </td>
                	<td colspan="4" align="center"><img src="images/informacoes_rodape.jpg" width="649" height="106">
						<span style="float:right; width:150px; heigth:15px; color:#CCC; margin-bottom:5px;"><a href="http://www.betag.com.br" title="Desenvolvido por BetaG Soluções" alt="Desenvolvido por BetaG Soluções" style="color:#AAA; text-decoration:none;" target="_blank">BetaG Soluções</a></span>
					</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td></td>
    </tr>
</table>
</body>
</html>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-1834720-37");
pageTracker._trackPageview();
} catch(err) {}
</script>
<?php
	//date(w) retorno os dias da semana por valores inteiros
	//0-domingo, 1-segunda, etc...
	if(date("w")==1){
		enviaAvisos();
	}
?>