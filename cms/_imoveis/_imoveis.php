<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['imoveis'])
{
	include("func.php");

	if($index == "")	$index = 0;
	if($mark=="")		$mark = 1;

	if($tipo=="cadastrar")	$tituloH1="Imóveis - Cadastrar";
	elseif($tipo=="listar")	$tituloH1="Imóveis - Listar";

	if($modo == "alterarStatus")
	{
		alterarStatus($status, $id);
	}
	if($modo == "alterarDestaque")
	{
		alterarDestaque($status, $id);
	}
	if($modo=="cadastrar")
	{
		$campoimagem ="imagem";
		$valorcampo  = $_FILES[$campoimagem];
		if($valorcampo){
			$imagem = uploadImagem("imagem", "../imoveis", 0, "");
			imageResize($imagem, "../imoveis", "p_", "120", "120");
			imageResize($imagem, "../imoveis", "m_", "230", "230");
			imageResize($imagem, "../imoveis", "g_", "800", "600");
			$imagem = end(explode('/', $imagem));
			unlink("../imoveis/$imagem");
		}
		// opcaoCategoria=cidade & listaSubCategoria=regiao & listaSubCategoria2=bairro
		$composicao=$_POST['composicao'];
		$valor=formataValor($valor);
		if(isset($destaque))	$destaque=1;	else	$destaque=0;
		if(isset($exclusivo))	$exclusivo=1;	else	$exclusivo=0;
		
		$retorno=cadastraImovel($referencia, $idCliente, $idCategoria, $idSubCategoria, $valor, $imagem, $idEstado, $opcaoCategoria, $listaSubCategoria, $listaSubCategoria2, $endereco, $descricaoCurta, $descricaoCompleta, $maisInformacoes, $destaque, $exclusivo, converteDataToMysql($dataTerminoExclusividade), converteDataToMysql($dataAviso), $composicao);
		
		if($retorno==true)
		{
			print("
				<script language='javascript'>window.location='index.php?modulo=imoveis&acao=imovelinfo&tipo=galeria&tipo2=fotos&id=$retorno';</script>
			");
		}
		else
			$msg="Erro ao cadastrar Imóvel!";
	}

	if($modo=="remover")
	{
		$retorno=remove($id, $_SESSION['idUsuario']);
		if($retorno==true)
			$msg="Imóvel removido com sucesso!";
		else
			$msg="Erro ao remover Imóvel!";
	}

	print("
		<h1>
			$tituloH1
		</h1>
	");

	if($msg!="")	devolveMensagem($msg, $retorno);

	if($tipo=="cadastrar")
	{
		?>
		<script type="text/javascript" src="mce/tiny_mce.js"></script>
		<script language="javascript" type="text/javascript">
		tinyMCE.init({
				mode : "specific_textareas",
				editor_selector : "mceEditor",
				theme : "simple",
				plugins : "style,layer,table,save,advhr,advimage,advlink,iespell,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,fullpage",
				theme_advanced_buttons2_add : "preview,separator,forecolor,backcolor,styleprops",
				theme_advanced_buttons3_add_before : "tablecontrols,separator",
				theme_advanced_buttons3_add : "emotions",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_path_location : "top",
				content_css : "example_full.css",
			    external_link_list_url : "example_link_list.js",
				external_image_list_url : "example_image_list.js",
				flash_external_list_url : "example_flash_list.js",
				media_external_list_url : "example_media_list.js",
				template_external_list_url : "example_template_list.js",
				file_browser_callback : "fileBrowserCallBack",
				theme_advanced_resize_horizontal : false,
				theme_advanced_resizing : true,
				nonbreaking_force_tab : true,
				apply_source_formatting : true,
				inline_styles : true,
				relative_urls : false,
				remove_script_host : false,
				valid_elements : ""
		+"a[accesskey|charset|class|coords|dir<ltr?rtl|href|hreflang|id|lang|name"
		  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|rel|rev"
		  +"|shape<circle?default?poly?rect|style|tabindex|title|target|type],"
		+"abbr[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"acronym[class|dir<ltr?rtl|id|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"address[class|align|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"applet[align<bottom?left?middle?right?top|alt|archive|class|code|codebase"
		  +"|height|hspace|id|name|object|style|title|vspace|width],"
		+"area[accesskey|alt|class|coords|dir<ltr?rtl|href|id|lang|nohref<nohref"
		  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup"
		  +"|shape<circle?default?poly?rect|style|tabindex|title|target],"
		+"base[href|target],"
		+"basefont[color|face|id|size],"
		+"bdo[class|dir<ltr?rtl|id|lang|style|title],"
		+"big[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"blockquote[dir|style|cite|class|dir<ltr?rtl|id|lang|onclick|ondblclick"
		  +"|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
		  +"|onmouseover|onmouseup|style|title],"
		+"body[alink|background|bgcolor|class|dir<ltr?rtl|id|lang|link|onclick|url"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onload|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|onunload|style|title|text|vlink],"
		+"br[class|clear<all?left?none?right|id|style|title],"
		+"button[accesskey|class|dir<ltr?rtl|disabled<disabled|id|lang|name|onblur"
		  +"|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup|onmousedown"
		  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|tabindex|title|type"
		  +"|value],"
		+"caption[align<bottom?left?right?top|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"center[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"cite[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"code[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"col[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
		  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
		  +"|onmousemove|onmouseout|onmouseover|onmouseup|span|style|title"
		  +"|valign<baseline?bottom?middle?top|width],"
		+"colgroup[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl"
		  +"|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
		  +"|onmousemove|onmouseout|onmouseover|onmouseup|span|style|title"
		  +"|valign<baseline?bottom?middle?top|width],"
		+"dd[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
		+"del[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"dfn[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"dir[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"div[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"dl[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"dt[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
		+"em/i[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"fieldset[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"font[class|color|dir<ltr?rtl|face|id|lang|size|style|title],"
		+"form[accept|accept-charset|action|class|dir<ltr?rtl|enctype|id|lang"
		  +"|method<get?post|name|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onreset|onsubmit"
		  +"|style|title|target],"
		+"frame[class|frameborder|id|longdesc|marginheight|marginwidth|name"
		  +"|noresize<noresize|scrolling<auto?no?yes|src|style|title],"
		+"frameset[class|cols|id|onload|onunload|rows|style|title],"
		+"h1[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"h2[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"h3[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"h4[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"h5[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"h6[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"head[dir<ltr?rtl|lang|profile],"
		+"hr[align<center?left?right|class|dir<ltr?rtl|id|lang|noshade<noshade|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|size|style|title|width],"
		+"html[dir<ltr?rtl|lang|version],"
		+"iframe[align<bottom?left?middle?right?top|class|frameborder|height|id"
		  +"|longdesc|marginheight|marginwidth|name|scrolling<auto?no?yes|src|style"
		  +"|title|width],"
		+"img[align<bottom?left?middle?right?top|alt|border|class|dir<ltr?rtl|height"
		  +"|hspace|id|ismap<ismap|lang|longdesc|name|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|src|style|title|usemap|vspace|width],"
		+"input[accept|accesskey|align<bottom?left?middle?right?top|alt"
		  +"|checked<checked|class|dir<ltr?rtl|disabled<disabled|id|ismap<ismap|lang"
		  +"|maxlength|name|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onselect"
		  +"|readonly<readonly|size|src|style|tabindex|title"
		  +"|type<button?checkbox?file?hidden?image?password?radio?reset?submit?text"
		  +"|usemap|value],"
		+"ins[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"isindex[class|dir<ltr?rtl|id|lang|prompt|style|title],"
		+"kbd[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"label[accesskey|class|dir<ltr?rtl|for|id|lang|onblur|onclick|ondblclick"
		  +"|onfocus|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
		  +"|onmouseover|onmouseup|style|title],"
		+"legend[align<bottom?left?right?top|accesskey|class|dir<ltr?rtl|id|lang"
		  +"|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"li[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title|type"
		  +"|value],"
		+"link[charset|class|dir<ltr?rtl|href|hreflang|id|lang|media|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|rel|rev|style|title|target|type],"
		+"map[class|dir<ltr?rtl|id|lang|name|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"menu[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"meta[content|dir<ltr?rtl|http-equiv|lang|name|scheme],"
		+"noframes[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"noscript[class|dir<ltr?rtl|id|lang|style|title],"
		+"object[align<bottom?left?middle?right?top|archive|border|class|classid"
		  +"|codebase|codetype|data|declare|dir<ltr?rtl|height|hspace|id|lang|name"
		  +"|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|standby|style|tabindex|title|type|usemap"
		  +"|vspace|width],"
		+"ol[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|start|style|title|type],"
		+"optgroup[class|dir<ltr?rtl|disabled<disabled|id|label|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"option[class|dir<ltr?rtl|disabled<disabled|id|label|lang|onclick|ondblclick"
		  +"|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
		  +"|onmouseover|onmouseup|selected<selected|style|title|value],"
		+"p[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"param[id|name|type|value|valuetype<DATA?OBJECT?REF],"
		+"pre/listing/plaintext/xmp[align|class|dir<ltr?rtl|id|lang|onclick|ondblclick"
		  +"|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
		  +"|onmouseover|onmouseup|style|title|width],"
		+"q[cite|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"s[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
		+"samp[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"script[charset|defer|language|src|type],"
		+"select[class|dir<ltr?rtl|disabled<disabled|id|lang|multiple<multiple|name"
		  +"|onblur|onchange|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|size|style"
		  +"|tabindex|title],"
		+"small[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"span[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"strike[class|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"strong/b[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"style[dir<ltr?rtl|lang|media|title|type],"
		+"sub[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"sup[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"table[align<center?left?right|bgcolor|border|cellpadding|cellspacing|background|class"
		  +"|dir<ltr?rtl|frame|height|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|rules"
		  +"|style|summary|title|width],"
		+"tbody[align<center?char?justify?left?right|char|class|charoff|dir<ltr?rtl|id"
		  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
		  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
		  +"|valign<baseline?bottom?middle?top],"
		+"td[abbr|align<center?char?justify?left?right|axis|bgcolor|background|char|charoff|class"
		  +"|colspan|dir<ltr?rtl|headers|height|id|lang|nowrap<nowrap|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|rowspan|scope<col?colgroup?row?rowgroup"
		  +"|style|title|valign<baseline?bottom?middle?top|width],"
		+"textarea[accesskey|class|cols|dir<ltr?rtl|disabled<disabled|id|lang|name"
		  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onselect"
		  +"|readonly<readonly|rows|style|tabindex|title],"
		+"tfoot[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
		  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
		  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
		  +"|valign<baseline?bottom?middle?top],"
		+"th[abbr|align<center?char?justify?left?right|axis|bgcolor|background|char|charoff|class"
		  +"|colspan|dir<ltr?rtl|headers|height|id|lang|nowrap<nowrap|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|rowspan|scope<col?colgroup?row?rowgroup"
		  +"|style|title|valign<baseline?bottom?middle?top|width],"
		+"thead[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
		  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
		  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
		  +"|valign<baseline?bottom?middle?top],"
		+"title[dir<ltr?rtl|lang],"
		+"tr[abbr|align<center?char?justify?left?right|bgcolor|char|background|charoff|class"
		  +"|rowspan|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title|valign<baseline?bottom?middle?top],"
		+"tt[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
		+"u[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
		+"ul[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title|type],"
		+"var[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title]"

			});
		</script>
		<form name="formCadastro" id="formCadastro" action="index.php?modulo=imoveis&acao=imoveis&modo=cadastrar&tipo=cadastrar" method="post" enctype="multipart/form-data">
		  	<table align="center" width="500" border="0" cellspacing="3" cellpadding="3">
				<tr>
					<td align="right" colspan="2" style="color:787878; letter-spacing:1px; font-size:85%;">* Campos Obrigat&oacute;rios</td>
				</tr>
				<tr>
					<th align="left">Refer&ecirc;ncia:</th>
					<td align="left">CI&nbsp;<input type="text" name="referencia" id="referencia" tipo="numerico" mascara="##########"></td>
				</tr>
				<tr>
			  		<th align="left">Cliente:</th>
			  		<td align="left">
						<select id="idCliente" name="idCliente" style="width:95%;">
							<option value="">-- Selecione uma das opções</option>
							<?php montaSelect("cliente", $idCliente); ?>
						</select> *
					</td>
		 		</tr>
		 		<tr>
					<th align="left" colspan="2">Op&ccedil;&otilde;es de Controle</th>
				</tr>
				<tr>
					<th align="left" colspan="2" valign="top">
						<input type="checkbox" name="destaque" id="destaque"> Selecione para marcar este im&oacute;vel como destaque.
					</th>
				</tr>
				<tr>
					<th align="left" colspan="2" valign="top">
						<input type="checkbox" name="exclusivo" id="exclusivo"
							onclick="
								el = document.getElementById( 'trExclusivo' );
								if( el.style.display == 'none' )
								{
									el.style.display = 'block';
								}
								else
								{
									el.style.display = 'none';
								}
							"
						> Selecione para marcar este im&oacute;vel como exclusivo.
					</th>
				</tr>
				<tr id="trExclusivo">
					<td align="left" colspan="2">
						<table align="center" width="100%" border="0" cellspacing="3" cellpadding="3">
							<tr>
								<th width="20%" align="left">Data T&eacute;rmino:</th>
								<td align="left">
									<input type="text" name="dataTerminoExclusividade" id="dataTerminoExclusividade" style="width:100px;" value="" onchange="document.formCadastro.dataAviso.value=SubtrairData(document.formCadastro.dataTerminoExclusividade.value, 10);"  onblur="document.formCadastro.dataAviso.value=SubtrairData(document.formCadastro.dataTerminoExclusividade.value, 9);" tipo="numerico" mascara="##/##/####">
									<img src="imagens/calendario.gif" id="f_trigger_a" style="cursor: pointer;" width="20" height="20" title="Clique para selecionar a data"/>
									<script type="text/javascript">
										Calendar.setup({
											inputField     :    "dataTerminoExclusividade",      // id of the input field
											ifFormat       :    "%d/%m/%Y",       // format of the input field
											showsTime      :    false,            // will display a time selector
											button         :    "f_trigger_a",   // trigger for the calendar (button ID)
											singleClick    :    true,           // double-click mode
											step           :    1                // show all years in drop-down boxes (instead of every other year as default)
										});
									</script>
								</td>
							</tr>
							<tr>
								<th align="left">Data Aviso:</th>
								<td align="left">
									<input type="text" name="dataAviso" id="dataAviso" style="width:100px;" value="" tipo="numerico" mascara="##/##/####">
									<img src="imagens/calendario.gif" id="f_trigger_b" style="cursor: pointer;" width="20" height="20" title="Clique para selecionar a data"/>
									<script type="text/javascript">
										Calendar.setup({
											inputField     :    "dataAviso",      // id of the input field
											ifFormat       :    "%d/%m/%Y",       // format of the input field
											showsTime      :    false,            // will display a time selector
											button         :    "f_trigger_b",   // trigger for the calendar (button ID)
											singleClick    :    true,           // double-click mode
											step           :    1                // show all years in drop-down boxes (instead of every other year as default)
										});
									</script>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
			  		<th align="left">Categoria:</th>
			  		<td align="left">
						<select id="idCategoria" name="idCategoria" style="width:95%;" onChange="DadosCategoria(this.value, 'subCategoriaXML', 'idSubCategoria', 'subCatOpcoes');">
							<option value="">-- Selecione uma das opções</option>
							<?php montaSelect("categorias", $idCategoria); ?>
						</select> *
					</td>
		 		</tr>
				<tr>
			  		<th align="left">Sub Categoria: </th>
			  		<td align="left">
		 				<select id="idSubCategoria" name="idSubCategoria" style="width:95%;">
						  <option id="subCatOpcoes" value="">-- Selecione uma das opções</option>
						  <?php //montaSelect("subcategorias", $idSubCategoria); ?>
						</select> *
		  	  		</td>
				</tr>
				<tr>
					<th align="left">Valor:</th>
					<td align="left"><input type="text" name="valor" id="valor" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
				</tr>
				<tr>
					<th align="left">Imagem:</th>
					<td align="left"><input type="file" name="imagem" id="imagem"> *</td>
				</tr>
				<tr>
			  		<th align="left">Cidade:</th>
			  		<td align="left">
						<select id="opcaoCategoria" name="opcaoCategoria" style="width:95%;" onChange="listaSubCategoria2.value=''; Dados(this.value, 'regioesXML', 'listaSubCategoria', 'opcaoSubCategoria');">
							<option value="">-- Selecione uma das opções</option>
							<?php montaSelect("cidades", $idCidade); ?>
						</select> *
					</td>
		 		</tr>
				<tr>
			  		<th align="left">Regi&atilde;o: </th>
			  		<td align="left">
		 				<select id="listaSubCategoria" name="listaSubCategoria" style="width:95%;" onChange="Dados2(this.value, 'bairrosXML', 'listaSubCategoria2', 'opcaoSubCategoria2');">
						  <option id="opcaoSubCategoria" value="">-- Selecione uma das opções</option>
						  <?php //montaSelect("regiao", $idRegiao); ?>
						</select> *
		  	  		</td>
				</tr>
				<tr>
			  		<th align="left">Bairro: </th>
			  		<td align="left">
		 				<select id="listaSubCategoria2" name="listaSubCategoria2" style="width:95%;">
						  <option id="opcaoSubCategoria2" value="">-- Selecione uma das opções</option>
						  <?php //montaSelect("bairros", $idBairro); ?>
						</select> *
		  	  		</td>
				</tr>
				<tr>
					<th align="left">Endere&ccedil;o:</th>
					<td align="left"><input type="text" name="endereco" id="endereco" maxlength="150"></td>
				</tr>
				<tr>
					<th align="left" colspan="2">Composi&ccedil;&atilde;o:</th>
				</tr>
				<tr>
					<th align="left" colspan="2"><?php listaComposicoes(); ?></th>
				</tr>
				<tr>
					<th align="left" colspan="2">Descri&ccedil;&atilde;o Curta:</th>
				</tr>
				<tr>
					<th align="left" colspan="2"><textarea name="descricaoCurta" id="descricaoCurta" style="width:100%; height:120px;"></textarea></td>
				</tr>
				<tr>
					<th align="left" colspan="2">Descri&ccedil;&atilde;o Completa:</th>
				</tr>
				<tr>
					<th align="left" colspan="2"><textarea name="descricaoCompleta" class="mceEditor" id="descricaoCompleta" style="width:100%;"></textarea></td>
				</tr>
				<tr>
					<th align="left" colspan="2">Mais Informa&ccedil;&otilde;es:</th>
				</tr>
				<tr>
					<th align="left" colspan="2"><textarea name="maisInformacoes" id="maisInformacoes" style="width:100%; height:120px;"></textarea></td>
				</tr>
				<tr valign="baseline">
					<td align="center" colspan="2">
						<input name="cadastrar" type="submit" id="form_submit" value="Cadastrar" onclick="tinyMCE.triggerSave();">
					</td>
				</tr>
			</table>
		</form>
		<script language="javascript">
			hide('trExclusivo');
			document.formCadastro.referencia.focus();

			function DadosCategoria(valor, arquivo, proximoCampo, opcoes)
			{
				var ajax;
				if(window.XMLHttpRequest) // Mozilla, Safari...
			    {
			        ajax = new XMLHttpRequest();
			    }
			    else if(window.ActiveXObject) // IE
			    {
					try{
			            ajax = new ActiveXObject('Msxml2.XMLHTTP');
			        }
			        catch(e)
			        {
			            try{
			                ajax = new ActiveXObject('Microsoft.XMLHTTP');
			            }
			            catch(e){}
			        }
			    }
				if(ajax) {
					document.formCadastro.idSubCategoria.options.length=1;
					idOpcao=document.getElementById(opcoes);
					ajax.open('POST', arquivo+'.php', true);
					ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					ajax.onreadystatechange=function() {
						if(ajax.readyState==1) {
							idOpcao.innerHTML='Carregando...';
						}
						if(ajax.readyState==4) {
							if(ajax.responseXML)
								processXMLCategoria(ajax.responseXML, arquivo, proximoCampo, opcoes);
							else
								idOpcao.innerHTML='';
						}
					}
				}
				var params = 'codigo='+valor;
				ajax.send(params);

			}
			function processXMLCategoria(obj, arquivo, proximoCampo, opcoes){
				var dataArray = obj.getElementsByTagName('subCategoria');
				if(dataArray.length > 0) {
					for(var i = 0 ; i < dataArray.length ; i++) {
						var item = dataArray[i];
						var codigo = item.getElementsByTagName('codigo')[0].firstChild.nodeValue;
						var nome =  item.getElementsByTagName('nome')[0].firstChild.nodeValue;
						idOpcao.innerHTML = '-- Selecione uma das opções >>';
						var novo = document.createElement('option');
						novo.setAttribute('id', opcoes);
						novo.value = codigo;
						novo.text  = nome;
						document.formCadastro.idSubCategoria.options.add(novo);
					}
				}
				else {
					idOpcao.innerHTML = '';
				}
			}

			function Dados(valor, arquivo, proximoCampo, opcoes)
			{
				var ajax;
				if(window.XMLHttpRequest) // Mozilla, Safari...
			    {
			        ajax = new XMLHttpRequest();
			    }
			    else if(window.ActiveXObject) // IE
			    {
					try{
			            ajax = new ActiveXObject('Msxml2.XMLHTTP');
			        }
			        catch(e)
			        {
			            try{
			                ajax = new ActiveXObject('Microsoft.XMLHTTP');
			            }
			            catch(e){}
			        }
			    }
				if(ajax) {
					document.formCadastro.listaSubCategoria.options.length=1;
					idOpcao=document.getElementById(opcoes);
					ajax.open('POST', arquivo+'.php', true);
					ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					ajax.onreadystatechange=function() {
						if(ajax.readyState==1) {
							idOpcao.innerHTML='Carregando...';
						}
						if(ajax.readyState==4) {
							if(ajax.responseXML)
								processXML(ajax.responseXML, arquivo, proximoCampo, opcoes);
							else
								idOpcao.innerHTML='';
						}
					}
				}
				var params = 'codigo='+valor;
				ajax.send(params);

			}
			function processXML(obj, arquivo, proximoCampo, opcoes){
				var dataArray = obj.getElementsByTagName('regiao');
				if(dataArray.length > 0) {
					for(var i = 0 ; i < dataArray.length ; i++) {
						var item = dataArray[i];
						var codigo = item.getElementsByTagName('codigo')[0].firstChild.nodeValue;
						var nome =  item.getElementsByTagName('nome')[0].firstChild.nodeValue;
						idOpcao.innerHTML = '-- Selecione uma das opções >>';
						var novo = document.createElement('option');
						novo.setAttribute('id', opcoes);
						novo.value = codigo;
						novo.text  = nome;
						document.formCadastro.listaSubCategoria.options.add(novo);
					}
				}
				else {
					idOpcao.innerHTML = '';
				}
			}

			function Dados2(valor, arquivo, proximoCampo, opcoes)
			{
				var ajax;
				if(window.XMLHttpRequest) // Mozilla, Safari...
			    {
			        ajax = new XMLHttpRequest();
			    }
			    else if(window.ActiveXObject) // IE
			    {
					try{
			            ajax = new ActiveXObject('Msxml2.XMLHTTP');
			        }
			        catch(e)
			        {
			            try{
			                ajax = new ActiveXObject('Microsoft.XMLHTTP');
			            }
			            catch(e){}
			        }
			    }
				if(ajax) {
					document.formCadastro.listaSubCategoria2.options.length=1;
					idOpcao2=document.getElementById(opcoes);
					ajax.open('POST', arquivo+'.php', true);
					ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					ajax.onreadystatechange=function() {
						if(ajax.readyState==1) {
							idOpcao2.innerHTML='Carregando...';
						}
						if(ajax.readyState==4) {
							if(ajax.responseXML)
								processXML2(ajax.responseXML, arquivo, proximoCampo, opcoes);
							else
								idOpcao2.innerHTML='';
						}
					}
				}
				var params2 = 'codigo='+valor;
				ajax.send(params2);

			}
			function processXML2(obj, arquivo, proximoCampo, opcoes){
				var dataArray = obj.getElementsByTagName('bairro');
				if(dataArray.length > 0) {
					idOpcao2.innerHTML = '-- Selecione uma das opções >>';
					for(var i = 0 ; i < dataArray.length ; i++) {
						var item = dataArray[i];
						var codigo = item.getElementsByTagName('codigo')[0].firstChild.nodeValue;
						var nome =  item.getElementsByTagName('nome')[0].firstChild.nodeValue;
						var novo = document.createElement('option');
						novo.setAttribute('id', opcoes);
						novo.value = codigo;
						novo.text  = nome;
						document.formCadastro.listaSubCategoria2.options.add(novo);
					}
				}
				else {
					idOpcao2.innerHTML = '';
				}
			}
		</script>
		<?php
	}
	elseif($tipo=="listar" || $tipo=="")
	{
		?>
		<script type="text/javascript">
		// remove the registerOverlay call to disable the controlbar
		hs.registerOverlay({
			thumbnailId: null,
			overlayId: 'controlbar',
			position: 'top right',
			hideOnMouseOut: true
		});
		hs.graphicsDir = 'highslide/graphics/';
		hs.outlineType = 'rounded-white';
		// Tell Highslide to use the thumbnail's title for captions
		hs.captionEval = 'this.thumb.title';
		</script>
		<?php
		if($order=="referenciaASC") $referenciaAscSelected="selected"; else $referenciaAscSelected="";
		if($order=="referenciaDESC") $referenciaDescSelected="selected"; else $referenciaDescSelected="";
		if($order=="valorASC") $valorAscSelected="selected"; else $valorAscSelected="";
		if($order=="valorDESC") $valorDescSelected="selected"; else $valorDescSelected="";
		if(isset($inativos))	$checked="checked";	else	$checked="";
		if($exclusivos=="")	$sExclusivos="selected";	else	$sExclusivos="";
		if($exclusivos=="0")	$sExclusivos0="selected";	else	$sExclusivos0="";
		if($exclusivos=="1")	$sExclusivos1="selected";	else	$sExclusivos1="";
		print("
		<table align='center' width='90%' cellpadding='2' cellspacing='2'>
			<tr>
				<td width='80%' align='center' valign='top'>
					<form action='index.php?modulo=imoveis&acao=imoveis&tipo=listar&modo=pesquisa' method='post'>
						<fieldset style='width:450px;'>
					    	<legend>Listar</legend>
							<table align = 'center' border = '0' cellpadding='2' cellspacing='2'>
								<tr>
									<th align='left'>Ordenado por:</th>
									<td align='left'>
										<select name='order' id='order'>
											<option value='referenciaASC' $referenciaAscSelected>Referência Crescente</option>
											<option value='referenciaDESC' $referenciaDescSelected>Referência Decrescente</option>
											<option value='valorASC' $valorAscSelected>Valor Crescente</option>
											<option value='valorDESC' $valorDescSelected>Valor Decrescente</option>
										</select>
									</td>
								</tr>
								<tr>
									<th align='left'>Referência:</th>
									<td align='left'>CI&nbsp;<input type='text' name='referencia' id='referencia' value='$referencia' tipo='numerico' mascara='##########' style='width:90%;'></td>
								</tr>
								<tr>
									<th align='left'>Bairro:</th>
									<td align='left'>
										<select id='idBairro' name='idBairro'>
			                                <option value=''>Todos</option>
			                                "); montaSelect("bairros", $idBairro); print("
			                            </select>
			                        </td>
								</tr>
								<tr>
									<th align='left'>Valor:</th>
									<td align='left'>
										<input type='text' name='valorIni' id='valorIni' value='$valorIni' style='width:113px;' tipo='numerico' orientacao='esquerda' mascara='###.###.###.###,##'>
										&nbsp;à&nbsp;
										<input type='text' name='valorFim' id='valorFim' value='$valorFim' style='width:113px;' tipo='numerico' orientacao='esquerda' mascara='###.###.###.###,##'>
									</td>
								</tr>
								<tr>
									<th align='left'>Inativos:</th>
									<td align='left'><input type='checkbox' name='inativos' id='inativos' $checked> Selecione para ver apenas os inativos</td>
								</tr>
								<tr>
									<th align='left'>Exclusividade:</th>
									<td align='left'>
										<select name='exclusivos' id='exclusivos'>
											<option value='' $sExclusivos>Todos</option>
											<option value='0' $sExclusivos0>Não exclusivos</option>
											<option value='1' $sExclusivos1>Exclusivos</option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan='2' align='center'><input type='submit' id='form_submit' name='submitPesquisa' value='Pesquisar'></td>
								</tr>
							</table>
						</fieldset>
					</form>
				</td>
				<td width='20%' align='center' valign='top'>
					<fieldset style='width:230px; text-align:left;'>
						<legend>Legenda</legend>
						<table cellpadding='3' cellspacing='3' align='left'>
							<tr>
								<td align='center' valign='middle'><img src='imagens/ver_detalhes.png' border='0' title='Ver detalhes' alt='Ver detalhes'></td>
								<td align='left' valign='middle'>Ver detalhes</td>
							</tr>
							<tr>
								<td align='center' valign='middle'><img src='imagens/editar.png' border='0' title='Editar' alt='Editar'></td>
								<td align='left' valign='middle'>Editar</td>
							</tr>
							<tr>
								<td align='center' valign='middle'><img src='imagens/delete.png' border='0' title='Excluir' alt='Excluir'></td>
								<td align='left' valign='middle'>Excluir</td>
							</tr>
							<tr>
								<td align='center' valign='middle'><img src='imagens/status1.png' border='0' title='Liberado'></td>
								<td align='left' valign='middle'>Liberado</td>
							</tr>
							<tr>
								<td align='center' valign='middle'><img src='imagens/status0.png' border='0' title='Bloqueado'></td>
								<td align='left' valign='middle'>Bloqueado</td>
							</tr>
							<tr>
								<td align='center' valign='middle'><img src='imagens/destaque1.png' border='0' title='Marcado como Destaque' alt='Marcado como Destaque'></td>
								<td align='left' valign='middle'>Marcado como Destaque</td>
							</tr>
							<tr>
								<td align='center' valign='middle'><img src='imagens/destaque0.png' border='0' title='Marcado como NÃO Destaque' alt='Marcado como NÃO Destaque'></td>
								<td align='left' valign='middle'>Marcado como NÃO Destaque</td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
		</table>
		");

		if($order=="") $order="dataCadastroASC";

		$where="";
		if($referencia!=""){
			$where.=" AND referencia LIKE '%$referencia%' ";
		}
		if($idBairro!=""){
			$where.=" AND idBairro =$idBairro ";
		}
		if($valorIni!="")
		{
			$valorFiltroIni=formataValor($valorIni);
			$where.=" AND valor>=$valorFiltroIni ";
		}
		if($valorFim!="")
		{
			$valorFiltroFim=formataValor($valorFim);
			$where.=" AND valor<=$valorFiltroFim ";
		}
		if(isset($inativos))
		{
			$where.=" AND status=0 ";
		}
		if($exclusivos!="")
		{
			$where.=" AND exclusivo=$exclusivos ";
		}

		if($order=="dataCadastroASC")	$orderBy="id ASC";
		if($order=="referenciaASC")	$orderBy="referencia ASC";
		if($order=="referenciaDESC")	$orderBy="referencia DESC";
		if($order=="valorASC")	$orderBy="valor ASC";
		if($order=="valorDESC")	$orderBy="valor DESC";
		devolveListaImoveis($tipo, $index, $mark, "WHERE deletado='0' $where ORDER BY $orderBy", "&order=$order&referencia=$referencia&idBairro=$idBairro&valorIni=$valorIni&valorFim=$valorFim");
	}
}
else
{
	print("
		<br><br>
		<h1>
			");
			if(devolveUsuarioLogado())	devolveMensagem(NAO_AUTORIZADO, false);
			print("
		</h1>
		<br><br>
	");
}
?>