<?php
// Защита от прямого доступа к файлу
defined('_JEXEC') or die('Restricted access');
// Подключаем библиотеку представления Joomla
jimport('joomla.application.component.view');
// Создаем свой класс, расширяя JView
class YfaqViewAjax extends JView {
    
	// Перезаписуем метод display класса JView
    function display($tpl = null) 
		{
			$action = JRequest::getVar('action');
			
			switch($action)
				{
					case 'save':
						{
							$this->data = $this->get('Save');
							
							break;
						}
					case 'text':
						{
							$this->data = $this->get('Data');
							
							break;
						}
				}
			// Отображаем представление
			parent::display($tpl);
        }
}

