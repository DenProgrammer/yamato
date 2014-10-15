<?php if(!defined( '_JEXEC' ) ) die( 'Direct Access is not allowed.' ); ?>
<link rel="stylesheet" type="text/css" href="components/com_manager/assets/print.css" />
<div class="print-content" >
	<div class="head">
		<img src="images/logo.png" />
		<div class="head_text">
			<h2>Автосалон «Ямато»</h2>
			Бишкек, Элебесова, 120 (пересекает ул. Фере)<br />
			+996 (312) 390505   +996 (559) 390505
		</div>
	</div>
	<hr />
	<div class="topinfo" >
		<div class="title" >
			<span class="marka">
				<?php echo JString::strtolower($this->product->marka); ?>
			</span>
			<span class="model">
				<?php echo $this->product->model; ?>
			</span>
			<?php echo $this->product->year; ?> г. 
			&nbsp;
			(<?php echo substr($this->product->NomerKuzov,-4) ?>) 
		</div>
		<div class="price" ><?php echo round($this->product->price).' '.$this->product->currency; ?></div>
	</div>
	<hr />
	<div class="imagelist" >
		<img class="mainimage" src="components/com_virtuemart/shop_image/product/<?php echo $this->product->product_full_image ?>">
		<?php
			$i = 0;
			foreach($this->product->images as $image) {
				echo '<img class="image" src="'.$image->file_url.'">';
				$i++;
				if ($i>=12) break;
			}
		?>
	</div>
	<hr />
	<div>
		<table width="100%" >
			<tr>
				<td>
					<table class="avtoparams" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>Год выпуска</td>
							<td><?php if ($this->product->year > 1900) echo $this->product->year; else echo '-'; ?></td>
						</tr>
						<tr>
							<td>Обьем</td>
							<td><?php if ($this->product->EngineSize) echo $this->product->EngineSize; else echo '-'; ?></td>
						</tr>
						<tr>
							<td>КПП</td>
							<td><?php if ($this->product->TipKPP) echo $this->product->TipKPP; else echo '-'; ?></td>
						</tr>
						<tr>
							<td>Пробег</td>
							<td><?php if ($this->product->Probeg) echo $this->product->Probeg; else echo '-'; ?></td>
						</tr>
						<tr>
							<td>Кузов</td>
							<td><?php if ($this->product->TipKuzova) echo $this->product->TipKuzova; else echo '-'; ?></td>
						</tr>
						<tr>
							<td>Тип топлива</td>
							<td><?php if ($this->product->TipTopliva) echo $this->product->TipTopliva; else echo '-'; ?></td>
						</tr>
						<tr><td>Тип салона</td><td><?php echo $this->product->TipSalona; ?></td></tr>
						<tr><td>Цвет салона</td><td><?php echo $this->product->CvetSalona; ?></td></tr>
					</table>
				</td>
				<td>
					<div class="avtodesc">
						<?php if ($this->product->product_desc) echo 'Описание авто:<br>'.$this->product->product_desc.'<br><br>'; ?>
						<?php if ($this->product->contact) echo 'Контактная информация:<br>'.$this->product->contact.'<br><br>'; ?>
					</div>
					<a href="javascript:window.print();" style="float: right;"><img src="images/print.png" /></a>
				</td>
			</tr>
		</table>
	</div>
</div>
 