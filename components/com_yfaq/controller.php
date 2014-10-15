<?php
// Защита от прямого доступа к файлу
defined('_JEXEC') or die('Restricted access');
// Подключаем библеотеку контроллера Joomla
jimport('joomla.application.component.controller');
// Создаем класс контроллера
class YfaqController extends JController
{
	public function getPagination($pmax,$countrow,$p)
		{
			if (!$p>1) $p = 1;
			$a = $p*$pmax;
			
			$countlist = ceil($countrow/$pmax);
			
			$prev = $p-1;
			if ($prev<1) $prev = 1;
			$next = $p+1;
			if ($next>$countlist) $next = $countlist;
			$pag .=  '';
			if ($countlist>1)
				{
					$pag = '<ul class="yfaq_pagination">';
					$pag .= '<li class="pagination-start"><a class="pagenav" onclick="setPag(1)">В начало</a></li>';
					$pag .= '<li class="pagination-prev"><a class="pagenav" onclick="setPag('.$prev.')">Назад</a></li>';
					for($i=1;$i<=$countlist;$i++)
						{
							if ($p === $i) $sel = 'class="active"'; else $sel = '';
							$pag .= '<li '.$sel.'><a class="pagenav" onclick="setPag('.$i.')" title="'.$i.'">'.$i.'</a></li>';
						}
					$pag .= '<li class="pagination-next"><a class="pagenav" onclick="setPag('.$next.')" title="Вперёд">Вперёд</a></li>';
					$pag .= '<li class="pagination-end"><a class="pagenav" onclick="setPag('.$countlist.')" title="В конец">В конец</a></li>
					</ul>';
				}
		
			return $pag;
		}
}

