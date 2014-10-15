<?php
// Защита от прямого доступа к файлу
defined('_JEXEC') or die('Restricted access');
// Подключаем библиотеку представления Joomla
jimport('joomla.application.component.view');
// Создаем свой класс, расширяя JView
class YfaqViewQwest extends JView {
    
	protected $msg=null;
        
	// Перезаписуем метод display класса JView
    function display($tpl = null) 
		{
			$this->mid = JRequest::getVar('mid');
			
			$d = dir("components/com_yfaq/images/capcha");
			while ($entry = $d->read()){
				if (($entry!='.') and ($entry!='..')) $this->capcha[] = str_replace('.gif','',$entry);
			}
			$d->close(); 
			
			$this->rand = rand(0,(count($this->capcha)-1));
			$_SESSION['yfaq_capcha'] = $this->capcha[$this->rand];
			
			// Отображаем представление
			parent::display($tpl);
        }
}

