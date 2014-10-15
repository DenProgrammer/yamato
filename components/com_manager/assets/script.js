
var car_template = '';
car_template += '<div class="car">';
car_template += '		<div class="car_image" >';
car_template += '			<a href="index.php?option=com_manager&layout=edit&car_id=%ID%&Itemid=32" >';
car_template += '				<img width="150" src="%IMAGE%" border="0" />';
car_template += '			</a>';
car_template += '		</div>';
car_template += '		<div class="car_details">';
car_template += '			<div class="car_title" >';
car_template += '				<a href="index.php?option=com_manager&layout=edit&car_id=%ID%&Itemid=32" >';
car_template += '					%NAME%';
car_template += '				</a>';
car_template += '			</div>';
car_template += '			<div class="car_nomer" >%NOMER%</div>';
car_template += '			<div class="car_year" >%YEAR%</div>';
car_template += '			<div class="car_price" >%PRICE%</div>';
car_template += '			<div class="car_cagent" >Контрагент: %CAGENT%</div>';
car_template += '			<div class="car_probeg" >Пробег: %PROBEG%</div>';
car_template += '		</div>';
car_template += '	</div>';


jQuery('document').ready(function($){
	var url_tpl = 'index.php?option=com_manager&Itemid=32';
	var search_param = '';
	var limit = parseInt($('#limit').val());
	
	$('#add_btn').data('offset', 0);
	
	$('#car_marka').change(function(){
		search();
	});
	$('#car_model').change(function(){
		search();
	});
	$('#car_year1').change(function(){
		search();
	});
	$('#car_year2').change(function(){
		search();
	});
	$('#car_search').change(function(){
		search();
	});
	$('#car_cagent').change(function(){
		search();
	});
	
	function search() {		
		get_search_param();
		if (search_param){
			document.location = url_tpl + search_param;
		}
	}
	
	function get_search_param() {
		var marka = $('#car_marka').val();
		var model = $('#car_model').val();
		var year1 = $('#car_year1').val();
		var year2 = $('#car_year2').val();
		var search = $('#car_search').val();
		var cagent = $('#car_cagent').val();
		var all = $('#filtr_all').is(':checked');	
		var delivered = $('#filtr_delivered').is(':checked');
		var sold = $('#filtr_sold').is(':checked');
		var fresh = $('#filtr_fresh').is(':checked');
		
		search_param = '';
		search_param += '&marka=' + marka;
		search_param += '&model=' + model;
		search_param += '&search=' + search;
		search_param += '&year1=' + year1;
		search_param += '&year2=' + year2;
		search_param += '&cagent=' + cagent;
		search_param += '&all=' + all;
		search_param += '&delivered=' + delivered;
		search_param += '&sold=' + sold;
		search_param += '&fresh=' + fresh;
	}
	
	function getReport() {
		var cagent = $('#car_cagent').val();
		var date1 = $('#date1').val();
		var date2 = $('#date2').val();
		if (cagent) {
			$('img.preloader').css('display', 'block');
			$.get('index.php?option=com_sincronise&type=showOrderFinans&ajax=1', {date1:date1, date2:date2, cagent:cagent}, function(data){
				$('.report_content').html(data);
				$('img.preloader').css('display', 'none');
			})
		}
	}
	
	$('.filtr_el').change(function() {
		if ($(this).attr('type') == 'checkbox' && $(this).attr('id') != 'filtr_all' && $(this).is(':checked') == false) {
			$('#filtr_all').removeAttr('checked');
		}
		var all = $('#filtr_all').is(':checked');
		if (all == true) {
			$('.chb').attr('checked','checked');
		}
		
		search();
	});
	
	$('#add_btn').click(function(){
		var offset = $('#add_btn').data('offset');
		offset += limit;
		get_search_param();
		$('#add_btn').data('offset', offset);
		$('img.preloader').css('display', 'block');
		$.get('index.php?option=com_manager&view=manager&layout=ajax&tmpl=ajax' + search_param, {offset: offset}, function(data) {
			data = $.parseJSON(data);
			html = ''; item = '';
			$.each(data.cars, function(i, el){
				var cagent = (el.cagent == null) ? '' : el.cagent;
				item = car_template;
				item = item.replace('%IMAGE%', el.image);
				item = item.replace('%ID%', el.id);
				item = item.replace('%ID%', el.id);
				item = item.replace('%NAME%', el.name);
				item = item.replace('%NOMER%', el.nomer);
				item = item.replace('%YEAR%', el.year);
				item = item.replace('%PRICE%', el.price);
				item = item.replace('%CAGENT%', cagent);
				item = item.replace('%PROBEG%', el.probeg);
				html += item;
			});
			$('.cars_list').append(html);
			if (data.is_lost == true){
				$('#add_btn').css('display', 'none');
			}
		$('img.preloader').css('display', 'none');
		});
	});
	
	function formReset(){
		$('#car_marka').val('');
		$('#car_model').val('');
		$('#car_year1').val('');
		$('#car_year2').val('');
		$('#car_search').val('');
		$('#car_cagent').val('');
		$('#add_btn').data('offset', -50);
		search();
	}
	
	$('#reset').click(function(){
		formReset();
	});
	
	if ($('#reset_main_list')){
		$('#reset_main_list').click(function(){
			formReset();
			return false;
		});
	}
	
	$('#cars_page_li').click(function(){
		$('#reports_page_li').css('display', 'block');
		$('#cars_page_li').css('display','none');
		$('.cars_page').css('display','block');
		$('.reports_page').css('display','none');
	});
	$('#reports_page_li').click(function(){
		$('#reports_page_li').css('display', 'none');
		$('#cars_page_li').css('display','block');
		$('.cars_page').css('display','none');
		$('.reports_page').css('display','block');
	});
	
	$('#staged_page').click(function(){
		$('#images_page').css('display','inline-block');
		$('#staged_page').css('display','none');
		$('.car_single_staged').css('display','block');
		$('.car_single_image').css('display','none');
	});
	$('#images_page').click(function(){
		$('#images_page').css('display','none');
		$('#staged_page').css('display','inline-block');
		$('.car_single_staged').css('display','none');
		$('.car_single_image').css('display','block');
	});
	$('#report_send').click(function(){
		getReport();
	});
	$('#search_img').click(function(){
		search();
	});
	
	getReport();
	
	$('#add_btn').data('offset', -50).click();
	
	
	$('.deleteimage').click(function(){
		var fileid = $(this).data('fileid');
		
		if (confirm('Изображение будет удалено, продолжить?')){
			$.get('index.php?option=com_manager&view=api&tmpl=ajax', {action: 'deleteimage', fileid: fileid}, function(data){
				data = $.parseJSON(data);
				
				if (data.status == true){
					$('#imagecont_' + fileid).remove();
				} else {
					alert('Ошибка удаления');
				}
			});
		}
	});
	
	
	$('div.topmenu ul.menu').prepend('<li id="menuscroll" data-open="close"><a href="#"><span>Меню</span></a></li>')
	
	$('#menuscroll').click(function(){
		var open = $(this).data('open');
		
		if (open == 'close'){
			$('div.topmenu').animate({height: 250}, 1000);
			$(this).data('open', 'open');
		}
		if (open == 'open'){
			$('div.topmenu').animate({height: 35}, 1000);
			$(this).data('open', 'close');
		}
	});
	
});