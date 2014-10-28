<?php
// Защита от прямого доступа к файлу
defined('_JEXEC') or die('Restricted access');
// Подключаем библиотеку представления Joomla
jimport('joomla.application.component.view');
// Создаем свой класс, расширяя JView
class YfaqViewYfaq extends JView {
    
	protected $msg=null;
        
	// Перезаписуем метод display класса JView
    function display($tpl = null) 
		{
			$this->id = JRequest::getVar('id');
			$this->action = JRequest::getVar('action');
			
			if ($this->action == 'save') 
				{
					$this->get("Save");
					header("Location: index.php?option=com_yfaq"); 
					exit;
				}
			if ($this->action == 'delete') 
				{
					$this->get("Delete");
					header("Location: index.php?option=com_yfaq"); 
					exit;
				}
			
			if ($this->id>0)
				{
					$this->data = $this->get('Data');
					$tpl = 'form';
				}
			else 
				{
					$this->data = $this->get('Data');
				}
				
			// Отображаем представление
			parent::display($tpl);
        }
}

