

/*****************************************global vars****************************************/

	var steck = new Array();
	var activ_elem = 0;
	var br_countitem = 0;
	var br_itemwidth = 0;
	var br_left = 0;
	var showwinaut = false;

/******************************************functions*****************************************/
	function getDataFromXML(data,tag)
		{
			var st_tag = '<'+tag+'>';
			var ed_tag = '</'+tag+'>';
			var st = data.indexOf(st_tag)+st_tag.length;
			var ed = data.indexOf(ed_tag);
			
			return data.substring(st,ed);
		}
	function showLogin()
		{
		
		}
	function logout()
		{
			jQuery("div.loginform input[type=submit]").click();
		}
	
	jQuery("document").ready(function(){
		br_itemwidth = jQuery(".banneritem_slider").css("width").replace('px','');
		br_itemwidth = br_itemwidth -1 + 4;
		br_countitem = jQuery(".banneritem_slider").length;
	
		var br_mainwidth = br_itemwidth*br_countitem;
		var br_mainheight = jQuery(".banneritem_slider").css("height").replace('px','');
		jQuery(".bannergroup_slider").css("width",br_mainwidth);
		jQuery(".moduletable_slider").css("height",br_mainheight);
		
		jQuery(".br_prev").click(function(){
			br_itemwidth = br_itemwidth - 1 + 1;
			br_left = br_left - 1 + 1;
			br_left = br_left - br_itemwidth;
			if (br_left>=0) jQuery(".bannergroup_slider").animate({'left':-br_left},800); else br_left = 0;
		});
		jQuery(".br_next").click(function(){
			br_itemwidth = br_itemwidth - 1 + 1;
			br_left = br_left - 1 + 1;
			br_left = br_left + br_itemwidth;
			if (br_left <= (br_countitem-3)*br_itemwidth)
				{
					jQuery(".bannergroup_slider").animate({'left':-br_left},800);
				}
			else
				{
					jQuery(".bannergroup_slider").animate({'left':0},800);
					br_left = 0;
				}
		});
		
		if (br_countitem>3)
			{
				setTimeout("nextSlide()",5000);
			}
		else
			{
				jQuery('.brcatnav').css('display','none');
			}
		
		
		//авторизация
		
		jQuery("div.moduletable_lgn a.login").click(function(){
			showwinaut = true;
			jQuery("div.moduletable-login").css("display","block");
		});
		jQuery("div.moduletable-login").click(function(){
			showwinaut = true;
		});
		jQuery("body").click(function(){
			if (showwinaut ==  false) jQuery("div.moduletable-login").css("display","none");
			showwinaut = false;
		})
	});
	
function nextSlide()
	{
		br_itemwidth = br_itemwidth - 1 + 1;
		br_left = br_left - 1 + 1;
		br_left = br_left + br_itemwidth;
		if (br_left <= (br_countitem-3)*br_itemwidth)
			{
				jQuery(".bannergroup_slider").animate({'left':-br_left},800);
			}
		else
			{
				jQuery(".bannergroup_slider").animate({'left':0},800);
				br_left = 0;
			}
		setTimeout("nextSlide()",5000);
	}
function setUrl(url)
	{
		showPreloader();
		jQuery.get(url,{},function(data){
			jQuery("#result").html(data);
			hidePreloader();
		});
	}
function saveUrl(url)
	{
		steck[steck.length] = url;
		activ_elem = steck.length-1;
	}
function mainFind(model)
	{
		model = jQuery.trim(model);
		
		var content = '';
		var url = '';
		//поиск в продуктах
		url = 'index.php?option=com_sincronise';
		jQuery.get(url,{type:'findProduct',model:model,ajax:1},function(data){
			content = getDataFromXML(data,'content');
			
			jQuery("div.rb_nal table tbody").html(content);
		});
		
		showPreloader();
		url = 'parsers/pricesTableRaAE.php';
		jQuery.get(url,{art:model},function(data){
			data = data.replace('th','td');
			jQuery("div.rb_oae").html(data);
			jQuery("div.rb_oae table tr:first-child").remove();
			jQuery("div.rb_oae table tr th:last-child").remove();
			jQuery("div.rb_oae table tr td:last-child").remove();
			
			jQuery("div.rb_oae table tr th:last-child").remove();
			jQuery("div.rb_oae table tr td:last-child").remove();
			
			jQuery("div.rb_oae table tr:first-child").append("<th>&nbsp;</th>");
			
			jQuery('table.PriceOnlineParts tr').each(function(i,elem){
				if (i>0)
					{
						var detcode = '';
						var detname = '';
						var detdesc = '';
						var detprice = '';
						var detmarka = '';
						jQuery(this).find('td').each(function(j,el){
							if (j==1) detmarka = jQuery(this).html();
							if (j==2) detcode = jQuery(this).html();
							if (j==3) detname = jQuery(this).html();
							if (j==3) detdesc = jQuery(this).html();
							if (j==9) detprice = jQuery(this).html();
						});
						
						detprice = parseFloat(detprice);
						if (detprice>0)
							{
								jQuery(this).append("<td><input type='button' value='Купить'/></td>");
								jQuery(this).addClass('dcode_'+detcode).click(function(){
									selectAEDetail(detcode,detname,detdesc,detprice,detmarka);
								});
							}
						else
							{
								jQuery(this).append("<td>&nbsp;</td>");
							}
					}
			});
			
			hidePreloader();
		});
		
		jQuery(".moduletable-findresult").css("display","block");
	}
	function selectAEDetail(detcode,detname,detdesc,detprice,detmarka)
		{
			url = 'index.php?option=com_sincronise';
			jQuery.get(url,{type:'createAEProduct',detcode:detcode,detname:detname,detdesc:detdesc,detprice:detprice,detmarka:detmarka,ajax:1},function(data){
				var url = getDataFromXML(data,'url');
				var status = getDataFromXML(data,'status');
				
				if (status=='1') document.location = url;
			});
		}
	function rollout()
		{
		
		}
	//добавление изделия в виртуемарт
	function addToWm(num)
		{
			alert(num);
		}
	function showPreloader()
		{
			jQuery(".frame_prldr").css("display","block");
		}
	function hidePreloader()
		{
			jQuery(".frame_prldr").css("display","none");
		}