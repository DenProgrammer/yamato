<?php
// Защита от прямого доступа к файлу
defined('_JEXEC') or die('Restricted access');
?>
<script>
function getDataFromXML(data,tag)
	{
		var st_tag = '<'+tag+'>';
		var ed_tag = '</'+tag+'>';
		var st = data.indexOf(st_tag)+st_tag.length;
		var ed = data.indexOf(ed_tag);
		
		return data.substring(st,ed);
	}
function setPag(step)
	{
		var url = 'index.php?option=com_yfaq&view=ajax&action=text&tmpl=component';
		jQuery.get(url,{step:step},function(data){
			content = getDataFromXML(data,'content');
			jQuery("div.yfaqcontent").html(content);
		});
	}
jQuery('document').ready(function(){
	jQuery("#yfaq_btn").click(function(){
		var name = jQuery("#yfaq_name").attr("value");
		var email = jQuery("#yfaq_email").attr("value");
		var qwest = jQuery("#yfaq_qwest").attr("value");
		var capcha = jQuery("#yfaq_capcha").attr("value");
		
		var url = 'index.php?option=com_yfaq&view=ajax&action=save&tmpl=component';
		jQuery.post(url,{name:name,email:email,qwest:qwest,capcha:capcha},function(data){
			var content = getDataFromXML(data,'content');
			var error = getDataFromXML(data,'error');
			error = error - 1 + 1;
			alert(content);
			
			if (error == '0') 
				{
					jQuery("#yfaq_name").attr("value","");
					jQuery("#yfaq_email").attr("value","");
					jQuery("#yfaq_qwest").attr("value","");
					jQuery("#yfaq_capcha").attr("value","");
				}
		});
	});
	setPag(1);
});
</script>
<style>
div.yfaqbody{
	width:800px;
	margin-left:20px;
}
div.yfaqbody h3{
	color:#0e97c9;
	font:normal 24px Calibri;
}
div.yfaqform{
	color:#303030;
	font:normal 14px Calibri;
	float:right;
	width:350px;
	text-align:left;
}
div.yfaqform input[type=text]{
	width:350px;
	height:26px;
	border:solid 1px #c4c4c4;
	padding:0 5px;
}
div.yfaqform textarea{
	width:350px;
	height:105px;
	border:solid 1px #c4c4c4;
	resize:none;
}
img.capcha{
	border:solid 1px #946b73;
	vertical-align:middle;
}
div.yfaqform input.capcha{
	width:135px;
	vertical-align:middle;
	margin-left:20px;
}
#yfaq_btn{
	background:url(components/com_yfaq/images/btn.png) center center no-repeat;
	border:none;
	width:127px;
	height:30px;
	cursor:pointer;
}
div.yfaqcontent{
	margin-top:15px;
}
div.yfaq_qwest{
	padding-left:50px;
	background:url(components/com_yfaq/images/qwest.png) 10px 0px no-repeat;
	margin-top:10px;
}
div.yfaq_qwest_name{
	color:#d07c17;
	font-size:14px;
	font-weight:bold;
	text-align:left;
	padding-left:10px;
}
div.yfaq_cdate,div.yfaq_mdate{
	color:#808080;
	font-size:12px;
	text-align:left;
	padding-left:10px;
}
div.yfaq_qwest_text{
	color:#3e3e3e;
	font-size:14px;
	margin-top:10px;
	text-align:left;
}
div.yfaq_answer{
	padding-left:50px;
	background:url(components/com_yfaq/images/ansver.png) 10px 0px no-repeat;
	margin-top:10px;
}
div.yfaq_answer_name{
	color:#d10000;
	font-size:14px;
	font-weight:bold;
	text-align:left;
	padding-left:10px;
}
div.yfaq_answer_text{
	color:#3a65ab;
	font-size:14px;
	margin-top:10px;
	text-align:left;
}

ul.yfaq_pagination{
	padding-left:0px;
	display:block;
	text-align:center;
}
ul.yfaq_pagination li{
	list-style:none;
	display:inline-block;
	margin:0 5px;
	cursor:pointer;
}
ul.yfaq_pagination li.active a{
	color:red;
	font-weight:bold;
}
</style>
<h3>Вопрос-Ответ</h3>
<div class="yfaqbody">
	<div class="yfaqform">
	<div style="text-align:center;">Ваш вопрос</div>
		<label>Имя*</label>
		<input type="text" id="yfaq_name"/>
		<label>e-mail*</label>
		<input type="text" id="yfaq_email"/>
		<label>Ваш вопрос*</label>
		<textarea id="yfaq_qwest"></textarea>
		<label>Проверочный код</label><br>
		<div>
			<img class="capcha" src="components/com_yfaq/images/capcha/<?php echo $this->capcha[$this->rand]; ?>.gif"/>
			<input type="text" class="capcha" id="yfaq_capcha"/>
		</div>
		<br>
		<input type="button" id="yfaq_btn" value=" "/>
	</div>
	<div class="yfaqcontent">
	
	</div>
</div>