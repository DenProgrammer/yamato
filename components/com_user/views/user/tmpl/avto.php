<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

	$db = JFactory::getDbo();
	$user = JFactory::getUser();
	$id = JRequest::getInt('id');
	$Itemid = JRequest::getInt('Itemid');
	$action = JRequest::getVar('action');
	
	function create_small($name_big,$name_small,$max_x, $max_y)
		{
			list($x, $y, $t, $attr) = getimagesize($name_big);
 
			if ($t == IMAGETYPE_GIF)
				$big=imagecreatefromgif($name_big);
			else if ($t == IMAGETYPE_JPEG)
				$big=imagecreatefromjpeg($name_big);
			else if ($t == IMAGETYPE_PNG)
				$big=imagecreatefrompng($name_big);
			else
				return;    
 
			if ($x > $y)
				{
					$xs=$max_x;
					$ys=$max_x/($x/$y);
				}
			else
				{
					$ys=$max_y;
					$xs=$max_y/($y/$x);
				}
			$small=imagecreatetruecolor ($xs,$ys);
			$res = imagecopyresampled($small,$big,0,0,0,0,$xs,$ys,$x,$y);
			imagedestroy($big);
			imagejpeg($small,$name_small);
			imagedestroy($small);      
		} 		
	
	if (($action == 'saveprod') and ($id > 0))
		{			
			//pr($_POST);
			$desc = trim(JRequest::getVar('desc')); 
			$TipKuzova = JRequest::getVar('TipKuzova');
			$altTipKuzova = JRequest::getVar('altTipKuzova');
			$TipKPP = JRequest::getVar('TipKPP');
			$altTipKPP = JRequest::getVar('altTipKPP');
			$TipSalona = JRequest::getVar('TipSalona');
			$altTipSalona = JRequest::getVar('altTipSalona');
			$CvetKuzova = JRequest::getVar('CvetKuzova');
			$altCvetKuzova = JRequest::getVar('altCvetKuzova');
			$TipPrivoda = JRequest::getVar('TipPrivoda');
			$EngineSize = JRequest::getInt('EngineSize');
			$CvetSalona = JRequest::getVar('CvetSalona');
			$altTipPrivoda = JRequest::getVar('altTipPrivoda');
			$TipTopliva = JRequest::getVar('TipTopliva');
			$altTipTopliva = JRequest::getVar('altTipTopliva');
			$RaspolojenieRulya = JRequest::getVar('RaspolojenieRulya');
			$Probeg = JRequest::getVar('Probeg');
			$price = JRequest::getVar('price');
			$currency = JRequest::getVar('currency');
			$showimg = JRequest::getVar('showimg');
			$delimg = JRequest::getVar('delimg');
			$mainimg = JRequest::getVar('mainimg');
			$contact = JRequest::getVar('contact');
			$AukcionnayaCena = JRequest::getVar('AukcionnayaCena');
			$product_publish = (JRequest::getVar('product_publish')) ? 'Y' : 'N' ;
			
			if (($altTipKuzova) and ($altTipKuzova != 'Свой вариант')) $TipKuzova = $altTipKuzova;
			if (($altTipKPP) and ($altTipKPP != 'Свой вариант')) $TipKPP = $altTipKPP;
			if (($altTipSalona) and ($altTipSalona != 'Свой вариант')) $TipSalona = $altTipSalona;
			if (($altCvetKuzova) and ($altCvetKuzova != 'Свой вариант')) $CvetKuzova = $altCvetKuzova;
			if (($altTipPrivoda) and ($altTipPrivoda != 'Свой вариант')) $TipPrivoda = $altTipPrivoda;
			if (($altTipTopliva) and ($altTipTopliva != 'Свой вариант')) $TipTopliva = $altTipTopliva;
			
			
			$sql = "UPDATE `#__vm_product` SET
					`TipKuzova`='$TipKuzova', `TipKPP`='$TipKPP', `TipSalona`='$TipSalona', `CvetKuzova`='$CvetKuzova', `CvetSalona`='$CvetSalona', 
					`TipPrivoda`='$TipPrivoda', `TipTopliva`='$TipTopliva', `RaspolojenieRulya`='$RaspolojenieRulya', `Probeg`='$Probeg',
					`product_desc`='$desc', `useredit`='1', `writeble`='0', `EngineSize`='$EngineSize',
					`contact`='$contact'
					WHERE `product_id`=$id 
					LIMIT 1";
			$db->setQuery($sql);//echo $sql.'<br /><br />';
			$db->query();
			
			$sql = "UPDATE `#__vm_product_files` SET
					`file_published`='0' 
					WHERE `file_product_id`=$id";
			$db->setQuery($sql);//echo $sql.'<br /><br />';
			$db->query();
			
			if ($delimg) foreach($delimg as $k=>$v)
				{
					$file_id = (int) $k;
					
					$sql = 'SELECT * FROM `#__vm_product_files` WHERE `uploaded_from1C`=0 AND `file_id`='.$file_id;
					$db->setQuery($sql);//echo $sql.'<br /><br />';
					$file = $db->LoadObject();
					
					if ($file)
						{
							$bfile = 'http://image.yamato.kg/'.$file->file_name;
							$sfile = 'http://image.yamato.kg/'.$file->file_name;
							
							@unlink($bfile);
							@unlink($sfile);
							
							$sql = "DELETE FROM `#__vm_product_files` 
									WHERE `file_id`=$file_id 
									LIMIT 1";
							$db->setQuery($sql);//echo $sql.'<br /><br />';
							$db->query();
						}
				}
				
			if ($mainimg)
				{
					foreach($mainimg as $k=>$v)
						{
							$mainimg_id = (int) $k;
						}
							
					$sql = 'SELECT * FROM `#__vm_product_files` WHERE `file_id`='.$mainimg_id;
					$db->setQuery($sql);//echo $sql.'<br /><br />';
					$smallobj = $db->LoadObject();
					$smallimg = $smallobj->file_name;
					
					$sql = "SELECT * FROM `#__vm_product` WHERE `product_id`=$id";
					$db->setQuery($sql);//echo $sql.'<br /><br />';
					$bigobj = $db->LoadObject();
					$bigimg = $bigobj->product_full_image;
			
					$sql = "UPDATE `#__vm_product_files` SET `file_name`='$bigimg', `file_title`='$bigimg', `file_url`='components/com_virtuemart/shop_image/product/$bigimg' WHERE `file_id`=$mainimg_id";
					$db->setQuery($sql);//echo $sql.'<br /><br />';
					$db->query();
					
					$sql = "UPDATE `#__vm_product` SET `product_full_image`='$smallimg', `product_thumb_image`='resized/$smallimg' WHERE `product_id`=$id";
					$db->setQuery($sql);//echo $sql.'<br /><br />';
					$db->query();
				}
			
			if ($showimg) foreach($showimg as $k=>$v)
				{
					$file_id = (int) $k;
					
					$sql = "UPDATE `#__vm_product_files` SET
							`file_published`='1' 
							WHERE `file_id`=$file_id 
							LIMIT 1";
					$db->setQuery($sql);//echo $sql.'<br /><br />';
					$db->query();
				}
					
			if (($price>0) and ($currency))
				{
					$price_id = 0;
					$sql = "SELECT `product_price_id` 
							FROM `#__vm_product_price` 
							WHERE `product_currency`='$currency' AND `product_id`=$id
							LIMIT 1";
					$db->setQuery($sql);//echo $sql.'<br /><br />';
					$price_id = $db->LoadResult();
					
					if ($price_id > 0){
						$sql = "UPDATE `#__vm_product_price` SET
								`product_price`='$price', `product_currency`='$currency'
								WHERE `product_id`=$id
								LIMIT 1";
					} else {
						$sql = "INSERT INTO `#__vm_product_price` 
								(`product_price`, `product_currency`, `product_id`, `shopper_group_id`) 
								VALUES 
								('$price', '$currency', '$id', '5')";
					}
					$db->setQuery($sql);//echo $sql.'<br /><br />';
					$db->query();
				}
				
			if ($_FILES)
				{
					$filename = $id.'_'.time();
					$filetype = $_FILES['newimg']['type'];
					$filepath = $_FILES['newimg']['tmp_name'];
					$filesize = $_FILES['newimg']['size'];
					
					if (($filetype=='image/jpeg') or ($filetype=='image/png'))
						{
							create_small($filepath,"components/com_virtuemart/shop_image/product/file_$filename.jpg",500, 400);
							create_small($filepath,"components/com_virtuemart/shop_image/product/resized/file_$filename.jpg",190, 150);
							
							$sql = "INSERT INTO `#__vm_product_files` (
										`file_product_id`, `file_name`, `file_title`, `file_description`, `file_extension`, 
										`file_mimetype`, `file_url`, `file_published`, `file_is_image`, `file_image_height`, 
										`file_image_width`, `file_image_thumb_height`, `file_image_thumb_width`, `uploaded_from1C`
										) VALUES (
										'$id', 'file_$filename.jpg', 'file_$filename.jpg', '', 'jpg', 
										'image/jpeg', 'components/com_virtuemart/shop_image/product/file_$filename.jpg', '1', '1', '400', 
										'500', '150', '190', '0')";
							$db->setQuery($sql);//echo $sql.'<br /><br />';
							$db->query();
						}
				}
			
			header("Location: index.php?option=com_user&view=user&layout=avto&Itemid=$Itemid&id=$id");
			exit;
		}
	
		
	
	$sql = 'SELECT `link` FROM `#__users` WHERE `id`='.$user->id.' LIMIT 1';
	$db->setQuery($sql);
	$userlink = $db->LoadResult();
	
	if ($userlink)
		{
			if ($id>0)
				{
					
					$sql = 'SELECT `p`.* 
							FROM `#__vm_product` AS `p` 
							WHERE `p`.`product_id`='.$id.' 
							LIMIT 1';
					$db->setQuery($sql);
					$prod = $db->LoadObject();
					
					$product_id = $prod->product_id;
					$product_publish = $prod->product_publish;
					$product_desc = $prod->product_desc;
					$product_s_desc = $prod->product_s_desc;
					$marka = $prod->marka;
					$model = $prod->model;
					$year = $prod->year;
					$NomerKuzov = $prod->NomerKuzov;	
					$TipKuzova = $prod->TipKuzova;	
					$TipKPP = $prod->TipKPP;	
					$Probeg = $prod->Probeg;	
					$EngineSize = $prod->EngineSize;	
					$TipSalona = $prod->TipSalona;	
					$CvetKuzova = $prod->CvetKuzova;	
					$CvetSalona = $prod->CvetSalona;	
					$TipPrivoda = $prod->TipPrivoda;	
					$TipTopliva = $prod->TipTopliva;	
					$RaspolojenieRulya = $prod->RaspolojenieRulya;	
					$product_thumb_image = $prod->product_thumb_image;
					$product_full_image = $prod->product_full_image;
					$price = round($prod->CenaProdaji);
					$currency = $prod->ValutaCenyProdaji;
					$contact = $prod->contact;
					$AukcionnayaCena = $prod->AukcionnayaCena;
					$ValutaAukcionnoiCeny = $prod->ValutaAukcionnoiCeny;
					
					$img = $prod->product_thumb_image;
					$bigimg = $prod->product_full_image;
					
					$sql = 'SELECT * FROM `#__vm_product_files` WHERE `file_product_id`='.$id;
					$db->setQuery($sql);
					$files = $db->LoadObjectList();
					
					$sql = 'SELECT * FROM `#__vm_product_price` WHERE `product_id`='.$id.' ORDER BY `product_currency` LIMIT 1';
					$db->setQuery($sql);
					$site_prices = $db->LoadObject();
					
					$title = $marka.' '.$model.' '.$year.' г. ('.$NomerKuzov.')';
						
					$path = $_SERVER['PHP_SELF'];
					$path = str_replace(array('/','index.php'),'',$path);
					
					$sql = 'SELECT `title` AS `TipKuzova` FROM `#__list_type_kuzov`';
					$db->setQuery($sql);
					$TipKuzovaList = $db->LoadObjectList();
					
					$sql = 'SELECT `title` AS `TipKPP` FROM `#__list_type_kpp`';
					$db->setQuery($sql);
					$TipKPPList = $db->LoadObjectList();
					
					$sql = 'SELECT `title` AS `TipSalona` FROM `#__list_type_salon`';
					$db->setQuery($sql);
					$TipSalonaList = $db->LoadObjectList();
					
					$sql = 'SELECT `title` AS `CvetKuzova` FROM `#__list_cveta_kuzova`';
					$db->setQuery($sql);
					$CvetKuzovaList = $db->LoadObjectList();
					
					$sql = 'SELECT `title` AS `CvetSalona` FROM `#__list_cveta_salona`';
					$db->setQuery($sql);
					$CvetSalonaList = $db->LoadObjectList();
					
					$sql = 'SELECT DISTINCT `TipPrivoda` FROM `#__vm_product` WHERE `TipPrivoda` IS NOT NULL AND `TipPrivoda`!=""';
					$db->setQuery($sql);
					$TipPrivodaList = $db->LoadObjectList();
					
					$sql = 'SELECT `title` AS `TipTopliva` FROM `#__list_type_toplivo`';
					$db->setQuery($sql);
					$TipToplivaList = $db->LoadObjectList();
					
					$sql = 'SELECT DISTINCT `RaspolojenieRulya` FROM `#__vm_product` WHERE `RaspolojenieRulya` IS NOT NULL AND `RaspolojenieRulya`!=""';
					$db->setQuery($sql);
					$RaspolojenieRulyaList = $db->LoadObjectList();
					
					$sql = 'SELECT * FROM `#__vm_currency`';
					$db->setQuery($sql);
					$CurrencyList = $db->LoadObjectList();
?>
<link href="templates/beez/css/jquery-te-1.4.0.css" type="text/css" rel="stylesheet" />
<script src="templates/beez/javascript/jquery-te-1.4.0.min.js" type="text/javascript"></script>
<script>
	jQuery('document').ready(function($){
		
		//$('#editor').jqte({source: false,sub:false,sup:false,strike:false,link:false,unlink:false,fsize:false,color:false,rule:false});
	
		$('input.alttext').focus(function(){
			if ($(this).attr('value') == 'Свой вариант') $(this).attr('value','');
		}).blur(function(){
			if ($(this).attr('value') == '') $(this).attr('value','Свой вариант');
		});
		
		$('.mainimgchb').mousedown(function(){
			$('.mainimgchb').removeAttr('checked');
		});
	});
</script>
<script src="http://dev.yamato.kg/components/com_virtuemart/fetchscript.php?gzip=0&amp;subdir[0]=/themes/default&amp;file[0]=theme.js&amp;subdir[1]=/js&amp;file[1]=sleight.js&amp;subdir[2]=/js/mootools&amp;file[2]=mootools-release-1.11.js&amp;subdir[3]=/js/mootools&amp;file[3]=mooPrompt.js&amp;subdir[4]=/js/slimbox/js&amp;file[4]=slimbox.js" type="text/javascript"></script>
<script type="text/javascript">var slimboxurl = 'http://dev.yamato.kg/components/com_virtuemart/js/slimbox/';</script>
<link href="http://dev.yamato.kg/components/com_virtuemart/fetchscript.php?gzip=0&amp;subdir[0]=/themes/default&amp;file[0]=theme.css&amp;subdir[1]=/js/mootools&amp;file[1]=mooPrompt.css&amp;subdir[2]=/js/slimbox/css&amp;file[2]=slimbox.css" type="text/css" rel="stylesheet" />

<div style="text-align:left; margin-bottom:5px;">
	<h1 class="product_name"><?php echo $title; ?></h1>
</div>
<form method="post" action="" enctype="multipart/form-data">

	<div class="prodlist" >
		<div class="avtolist" style="text-align:left;">
			<a rel="lightbox[product0]" href="<?php echo $bigimg; ?>">
				<img src="<?php echo $img; ?>" title="<?php echo $title; ?>" alt="<?php echo $title; ?>" style="width:120px;border-radius:5px;float:left;margin-right:10px;">
			</a>
			<p>Редактирование автомобиля</p>
			<p>
				<a href="index.php?option=com_user&view=user&layout=avto&Itemid=24">Вернутся к списку</a>&nbsp;|&nbsp;
				<a href="index.php?option=com_user&view=user&layout=etap&Itemid=24&id=<?php echo $id; ?>">Этапы доставки</a>
			</p>
			<div style="clear:both;"></div>
		</div>

		<div style="float:right;width:140px;display:none" >
			<input type="checkbox" name="product_publish" <?php if ($product_publish == 'Y') echo 'checked'; ?> /> Выставить на сайт
		</div>
		<br />
		<div class="row" >
			<div class="span2" >
				<label for="price" >Цена автомобиля</label>
				<?php echo "$price ($currency)"; ?>
			</div>
			<div class="span2" >
				<label for="AukcionnayaCena" >Аукционная цена (<?php echo $ValutaAukcionnoiCeny; ?>)</label>
				<?php echo (float) $AukcionnayaCena; ?>
			</div>
		</div>
		<div class="row" >
			<div class="span2 mainimg" >
				<label name="Probeg" >Цена автомобиля на сайте</label>
				<input type="text" name="price" value="<?php echo intval($site_prices->product_price); ?> "/>
			</div>
			<div class="span2" >
				<label for="currency" >Валюта</label>
				<select name="currency" >
				<?php
					if ($CurrencyList) foreach($CurrencyList as $row)
						{
							$sel = ($row->currency_code == $site_prices->product_currency) ? 'selected' : '' ;
							echo '<option '.$sel.' value="'.$row->currency_name.'">'.$row->currency_name.'</option>';
						}
				?>
				</select>
			</div>
			<div class="span2" >
				<label name="Probeg" >Пробег</label>
				<input type="text" name="Probeg" value="<?php echo $Probeg; ?> "/>
			</div>
			<div class="span2" >
				<label for="EngineSize" >Обьем двигателя</label>
				<input type="text" name="EngineSize" value="<?php echo $EngineSize; ?>" />
			</div>
			<div class="span2" >
				<label for="TipPrivoda" >Тип привода</label>
				<select name="TipPrivoda" >
					<option value="" >Не выбрано</option>
				<?php
					if ($TipPrivodaList) foreach($TipPrivodaList as $row)
						{
							$sel = ($row->TipPrivoda == $TipPrivoda) ? 'selected' : '' ;
							echo '<option '.$sel.' value="'.$row->TipPrivoda.'">'.$row->TipPrivoda.'</option>';
						}
				?>
				</select>
			</div>
			<div class="span2" >
				<label for="TipKPP" >Тип КПП</label>
				<select name="TipKPP" >
					<option value="">Не выбрано</option>
				<?php
					if ($TipKPPList) foreach($TipKPPList as $row)
						{
							$sel = ($row->TipKPP == $TipKPP) ? 'selected' : '' ;
							echo '<option '.$sel.' value="'.$row->TipKPP.'">'.$row->TipKPP.'</option>';
						}
				?>
				</select>
			</div>
		</div>
		<div class="row" >
			<div class="span2" >
				<label for="TipTopliva" >Тип топлива</label>
				<select name="TipTopliva">
					<option value="">Не выбрано</option>
				<?php
					if ($TipToplivaList) foreach($TipToplivaList as $row)
						{
							$sel = ($row->TipTopliva == $TipTopliva) ? 'selected' : '' ;
							echo '<option '.$sel.' value="'.$row->TipTopliva.'">'.$row->TipTopliva.'</option>';
						}
				?>
				</select>
			</div>
			<div class="span2" >
				<label for="RaspolojenieRulya" >Руль</label>
				<select name="RaspolojenieRulya" >
					<option value="">Не выбрано</option>
				<?php
					if ($RaspolojenieRulyaList) foreach($RaspolojenieRulyaList as $row)
						{
							$sel = ($row->RaspolojenieRulya == $RaspolojenieRulya) ? 'selected' : '' ;
							echo '<option '.$sel.' value="'.$row->RaspolojenieRulya.'">'.$row->RaspolojenieRulya.'</option>';
						}
				?>
				</select>
			</div>
			<div class="span2" >
				<label for="TipKuzova" >Тип кузова</label>
				<select name="TipKuzova">
					<option value="">Не выбрано</option>
				<?php
					if ($TipKuzovaList) foreach($TipKuzovaList as $row)
						{
							$sel = ($row->TipKuzova == $TipKuzova) ? 'selected' : '' ;
							echo '<option '.$sel.' value="'.$row->TipKuzova.'">'.$row->TipKuzova.'</option>';
						}
				?>
				</select>
			</div>
			<div class="span2" >
				<label for="CvetKuzova" >Цвет кузова</label>
				<select name="CvetKuzova">
					<option value="">Не выбрано</option>
				<?php
					if ($CvetKuzovaList) foreach($CvetKuzovaList as $row)
						{
							$sel = ($row->CvetKuzova == $CvetKuzova) ? 'selected' : '' ;
							echo '<option '.$sel.' value="'.$row->CvetKuzova.'">'.$row->CvetKuzova.'</option>';
						}
				?>
				</select>
			</div>
			<div class="span2" >
				<label for="TipSalona" >Тип салона</label>
				<select name="TipSalona">
					<option value="">Не выбрано</option>
				<?php
					if ($TipSalonaList) foreach($TipSalonaList as $row)
						{
							$sel = ($row->TipSalona == $TipSalona) ? 'selected' : '' ;
							echo '<option '.$sel.' value="'.$row->TipSalona.'">'.$row->TipSalona.'</option>';
						}
				?>
				</select>
			</div>
			<div class="span2" >
				<label for="CvetSalona" >Цвет салона</label>
				<select name="CvetSalona">
					<option value="">Не выбрано</option>
				<?php
					if ($CvetSalonaList) foreach($CvetSalonaList as $row)
						{
							$sel = ($row->CvetSalona == $CvetSalona) ? 'selected' : '' ;
							echo '<option '.$sel.' value="'.$row->CvetSalona.'">'.$row->CvetSalona.'</option>';
						}
				?>
				</select>
			</div>
		</div>
		<div class="row" >
			<div class="span6" >
				<label for="desc">Описание</label><br>
				<textarea name="desc" id="editor" ><?php echo $product_desc; ?></textarea>
			</div>
			<div class="span6" >
				<label for="contact">Контактные данные</label><br>
				<textarea name="contact" ><?php echo $contact; ?></textarea>
			</div>
		</div>
		<div class="row" >
			<div class="span12" >
				<input type="hidden" name="action" value="saveprod"/>
				<input type="hidden" name="id" value="<?php echo $id; ?>"/>
				<input type="submit" id="bfr_find_btn" name="btn" value="Сохранить изменения"/>
			</div>
		</div>
	</div>
	
	<hr class="gsep" />

	<div class="smallimglist">
		Загрузить картинку <input type="file" name="newimg" />
		<br />
		<br />
<?php
	if ($files) foreach($files as $file)
		{
			$checked = ($file->file_published) ? 'checked' : '' ;
			$disable = ($file->uploaded_from1C == 1) ? 'disabled' : '';
			echo '<div class="span3">
					<a rel="lightbox[product0]" title="'.$file->file_name.'" href="'.$file->file_url.'">
						<img width="115" border="0" class="browseProductImage" title="'.$file->file_name.'" alt="'.$file->file_name.'" src="'.$file->file_url.'">
					</a>
					<table width="100%" >
						<tr><td><input name="showimg['.$file->file_id.']" '.$checked.' type="checkbox" /></td><td align="left">Показывать на сайте</td></tr>
						<tr><td><input class="mainimgchb" name="mainimg['.$file->file_id.']" type="checkbox" /></td><td align="left">Сделать главной</td></tr>
						<tr><td><input '.$disable.' name="delimg['.$file->file_id.']" type="checkbox" /></td><td align="left">Удалить</td></tr>
					</table>
				</div>';
		}		
?>
	</div>

</form>
<?php		
				}
			else
				{
					$countinlist = 50;
					$p           = ($_GET['p']>1) ? $_GET['p'] : 1;
					$marka       = $_GET['marka'];
					$model       = $_GET['model'];
					$all         = $_GET['all'];
					$delivered   = $_GET['delivered'];
					$sold        = $_GET['sold'];
					$fresh       = $_GET['fresh'];
					
					$filtr = '';
					if ($marka) $filtr .= " AND `p`.`marka` LIKE '%$marka%' ";
					if ($model) $filtr .= " AND `p`.`model` LIKE '%$model%' ";
					if ($all != 'true') {
						if ($delivered == 'true') $status[] = " `p`.`status` = 'delivered' ";
						if ($sold == 'true') $status[] = " `p`.`status` = 'sold' ";
						if ($fresh == 'true') $status[] = " `p`.`status` = 'fresh' ";
						if (count($status) > 0){
							$filtr .= '('.implode(' OR ', $status).')';
						}
					}
					
					$sql = 'SELECT DISTINCT `p`.`marka` 
							FROM `#__vm_product` `p` 
							LEFT JOIN `#__cagents_avto` AS `ca` ON `ca`.`avto_link`=`p`.`link`
							WHERE `p`.`product_type`=\'automobil\' AND `ca`.`cagent_link`=\''.$userlink.'\'
							ORDER BY `p`.`model` ';
					$db->setQuery($sql);
					$markas = $db->LoadObjectList();

					if ($marka)	
						{
							$sql = 'SELECT DISTINCT `p`.`model` 
									FROM `#__vm_product` AS `p`
									LEFT JOIN `#__cagents_avto` AS `ca` ON `ca`.`avto_link`=`p`.`link`
									WHERE `product_type`=\'automobil\' AND `marka`=\''.$marka.'\' AND `ca`.`cagent_link`=\''.$userlink.'\'
									ORDER BY `p`.`model` ';
							$db->setQuery($sql);
							$models = $db->LoadObjectList();
						}
					
					$start = ($p-1)*$countinlist;
					$sql = "SELECT COUNT(`p`.`product_id`) AS `countid`  
							FROM `#__vm_product` AS `p` 
							LEFT JOIN `#__cagents_avto` AS `ca` ON `ca`.`avto_link`=`p`.`link`
							WHERE `ca`.`cagent_link`='$userlink'
							$filtr";
					$db->setQuery($sql);
					$count = $db->LoadResult();
					
					$countlist = ceil($count / $countinlist);
					
					$avto = array();
					$sql = "SELECT `p`.*, `ca`.`avto_link` AS `avto_link`, `ca`.`etap_dostavki` AS `etap_dostavki`, `ca`.`cdate` AS `avto_cdate`  
							FROM `#__vm_product` AS `p` 
							LEFT JOIN `#__cagents_avto` AS `ca` ON `ca`.`avto_link`=`p`.`link`
							WHERE `ca`.`cagent_link`='$userlink'
							$filtr
							ORDER BY `ca`.`cdate` DESC
							LIMIT $start, $countinlist";//echo $sql.'<br>';
					$db->setQuery($sql);
					$rows = $db->LoadObjectList();
					if ($rows) foreach($rows as $prod)
						{
							$avto[$prod->avto_link]->etap_dostavki = $prod->etap_dostavki;
							$avto[$prod->avto_link]->cdate = $prod->DataPokupki;
							$avto[$prod->avto_link]->AukcionnayaCena = $prod->AukcionnayaCena;
							$avto[$prod->avto_link]->ValutaAukcionnoiCeny = $prod->ValutaAukcionnoiCeny;
							
							$avto[$prod->avto_link]->product_id = $prod->product_id;
							$avto[$prod->avto_link]->marka = $prod->marka;
							$avto[$prod->avto_link]->model = $prod->model;
							$avto[$prod->avto_link]->year = $prod->year;
							$avto[$prod->avto_link]->NomerKuzov = $prod->NomerKuzov;	
							$avto[$prod->avto_link]->EngineSize = $prod->EngineSize;	
							$avto[$prod->avto_link]->product_thumb_image = $prod->product_thumb_image;
							$avto[$prod->avto_link]->product_full_image = $prod->product_full_image;
							$avto[$prod->avto_link]->price = round($prod->price);
							$avto[$prod->avto_link]->product_publish = $prod->product_publish;
							$avto[$prod->avto_link]->currency = ($prod->currency == 'USD') ? '$' : $prod->currency;
							$avto[$prod->avto_link]->CenaProdaji = (float) $prod->CenaProdaji;
							$avto[$prod->avto_link]->ValutaCenyProdaji = (string) $prod->ValutaCenyProdaji;
						}
					$path = $_SERVER['PHP_SELF'];
					$path = str_replace(array('/','index.php'),'',$path);
?>
<script>
		jQuery('document').ready(function($) {
			$('.filtr_el').change(function() {
				if ($(this).attr('type') == 'checkbox' && $(this).attr('id') != 'filtr_all' && $(this).is(':checked') == false) {
					$('#filtr_all').removeAttr('checked');
				}
				var all = $('#filtr_all').is(':checked');
				if (all == true) {
					$('.chb').attr('checked','checked');
				}
				
				var marka = $('#filtr_marka').val();
				var model = $('#filtr_model').val();
				var delivered = $('#filtr_delivered').is(':checked');
				var sold = $('#filtr_sold').is(':checked');
				var fresh = $('#filtr_fresh').is(':checked');
				
				var url = 'index.php?option=com_user&view=user&layout=avto&Itemid=24';
				url += '&marka=' + marka;
				url += '&model=' + model;
				url += '&delivered=' + delivered;
				url += '&sold=' + sold;
				url += '&all=' + all;
				url += '&fresh=' + fresh;
				document.location = url;
			});
		});
</script>
<div class="avtolist" >
	<div class="filtr">
		марка авто
		<select id="filtr_marka" class="filtr_el">
			<option value="">Все</option>
			<?php
				if ($markas) foreach($markas as $item)
					{
						$sel = ($marka == $item->marka) ? 'selected' : '';
						echo '<option '.$sel.' value="'.$item->marka.'">'.$item->marka.'</option>';
					}
				
			?>
		</select>
		модель 
		<select id="filtr_model" class="filtr_el">
			<option value="">Все</option>
			<?php
				if ($models) foreach($models as $item)
					{
						$sel = ($model == $item->model) ? 'selected' : '';
						echo '<option '.$sel.' value="'.$item->model.'">'.$item->model.'</option>';
					}
				
			?>
		</select>
		<input type="checkbox" id="filtr_all" <?php if ($all == 'true') echo 'checked'; ?> class="chb filtr_el" /> Все&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="checkbox" id="filtr_delivered" <?php if ($delivered == 'true') echo 'checked'; ?> class="chb filtr_el" /> Доставленные&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="checkbox" id="filtr_sold" <?php if ($sold == 'true') echo 'checked'; ?> class="chb filtr_el" /> Проданные&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="checkbox" id="filtr_fresh" <?php if ($fresh == 'true') echo 'checked'; ?> class="chb filtr_el" /> В пути
	</div>
<?php 
	$i = 0;
	foreach($avto as $a)	
		{
			$i++;
			$title = $a->marka.' '.$a->model.' ('.$a->NomerKuzov.')';
			
			$img = $a->product_thumb_image;
?>
	<div class="row" >
		<div class="blockleft">
			<a href="index.php?option=com_user&view=user&layout=avto&Itemid=24&id=<?php echo $a->product_id; ?>" >
				<img 
					src="<?php echo $img; ?>" 
					width="90" 
					title="<?php echo $title; ?>" 
					alt="<?php echo $title; ?>" 
				>
			</a>
		</div>
		<div class="blocktext">
			<h2><a href="index.php?option=com_user&view=user&layout=avto&Itemid=24&id=<?php echo $a->product_id; ?>"><?php echo $title; ?></a></h2>
			<div class="blockright" style="float:right;width:200px;">
				<p>Цена на аукционе: <?php  echo round($a->AukcionnayaCena).' '.$a->ValutaAukcionnoiCeny; ?></p>
				<p>Цена на авто: <?php  echo $a->CenaProdaji.' '.$a->ValutaCenyProdaji; ?></p>
			</div>
			<div class="blockinfo">
				<span><?php echo $a->year; ?> г.</span> 
				<span>V: <?php echo $a->EngineSize; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Местоположение: 
				<?php echo '<a style="font-weight:bold;text-decoration:underline;color:black;" href="index.php?option=com_user&view=user&layout=etap&Itemid=24&id='.$a->product_id.'" >'.$a->etap_dostavki.'</a>, '.date("d.m.Y", strtotime($a->cdate)) ?>
			</div>
			<div onclick="document.location='index.php?option=com_user&view=user&layout=etap&Itemid=24&id=<?php echo $a->product_id; ?>'" style="cursor:pointer;" class="tagsarrow tagsarrow_<?php if ($a->etap_dostavki == 'Доставлен') echo 'green'; else echo 'blue'; ?>">
				<div class="tagsarrow_left"></div>
				<?php
					if ($a->etap_dostavki == 'Доставлен') 
						{
							echo $a->etap_dostavki; 
						}
					else 
						{
							echo 'В пути';
						}
				?>
			</div>
			<?php if ($a->product_publish == 'Y') { ?>
			<div class="tagsarrow tagsarrow_red">
				<div class="tagsarrow_left"></div>Продается
			</div>
			<?php } ?>
		</div>
		<div style="clear:both;"></div>
	</div>
<?php 	} ?>
</div>
<div class="pagination" >
	<div>
		Страница <?php echo $p ?> из <?php echo $countlist ?>
	</div>
	<?php
		if ($p > 1) echo '<a href="index.php?option=com_user&view=user&layout=avto&Itemid='.$_GET['Itemid'].'&p='.($p-1).'&marka='.$_GET['marka'].'&model='.$_GET['model'].'&delivered='.$_GET['delivered'].'">« « предыдущие</a>';
		if ($p < $countlist) echo '<a href="index.php?option=com_user&view=user&layout=avto&Itemid='.$_GET['Itemid'].'&p='.($p+1).'&marka='.$_GET['marka'].'&model='.$_GET['model'].'&delivered='.$_GET['delivered'].'">следующие » »</a>';
	?>
</div>
<?php  
				} 
	
		}
	else
		{
			echo 'error';
		}
?>