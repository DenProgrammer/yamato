<?php
// Защита от прямого доступа к файлу
defined('_JEXEC') or die('Restricted access');
// Подключаем библеотеку контроллера Joomla
jimport('joomla.application.component.controller');
// Создаем класс контроллера
class YfaqController extends JController
{
	public function getPagination()
		{
			$id = JRequest::getInt('id');
			$cid = JRequest::getInt('cid');
			$p = JRequest::getInt('p');
			if (!$p>0) $p = 0;
			$pmax = 10;
			$a = $p*$pmax;
			
			$db = JFactory::getDBO();
			$sql = 'SELECT COUNT(`id`) AS `countid` FROM `#__npo`';
			$db->setQuery($sql);
			$countrow = $db->LoadResult();
			
			$countlist = ceil($countrow/$pmax);
			
			$prev = $p-1;
			if ($prev<0) $prev = 0;
			$next = $p+1;
			if ($next>=$countlist) $next = $countlist-1;
		
			if ($countlist>1)
				{
					$pag = '<ul>';
					$pag .= '<li class="pagination-start"><a class="pagenav" href="index.php?option=com_npo&cid='.$cid.'">В начало</a></li>';
					$pag .= '<li class="pagination-prev"><a class="pagenav" href="index.php?option=com_npo&cid='.$cid.'&p='.$prev.'">Назад</a></li>';
					for($i=0;$i<$countlist;$i++)
						{
							if ($p === $i) $sel = 'class="active"'; else $sel = '';
							$pag .= '<li '.$sel.'><a class="pagenav" href="index.php?option=com_npo&cid='.$cid.'&p='.$i.'" title="'.($i+1).'">'.($i+1).'</a></li>';
						}
					$pag .= '<li class="pagination-next"><a class="pagenav" href="index.php?option=com_npo&cid='.$cid.'&p='.$next.'" title="Вперёд">Вперёд</a></li>';
					$pag .= '<li class="pagination-end"><a class="pagenav" href="index.php?option=com_npo&cid='.$cid.'&p='.($countlist-1).'" title="В конец">В конец</a></li>
					</ul>';
				}
		
			return $pag;
		}
}

