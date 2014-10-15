<?php
// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

function pr($var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}

class SincroniseViewSincronise extends JView
{
	protected $msg    = null;
	protected $prices = null;
	
	function display($tpl = null) {
		$pid = JRequest::getInt('pid');
		if (SincroniseModelSincronise::save_changes()) header("Location: index.php?option=com_sincronise");
		if (SincroniseModelSincronise::save_tchanges()) 
			{
				header("Location: index.php?option=com_sincronise&layout=tlist&pid=$pid&id=0");
			}
		
		$layout = JRequest::getVar('layout');
		
		switch($layout)
			{
				case 'cform':
					{
						$this->data = $this->get('CForm');
						break;
					}
				case 'cdelete':
					{
						$this->data = $this->get('CDelete');
						header("Location: index.php?option=com_sincronise");
						break;
					}
				case 'tdelete':
					{
						$this->data = $this->get('TDelete');
						header("Location: index.php?option=com_sincronise&layout=tlist&pid=$pid");
						break;
					}
				case 'tlist':
					{
						$obj = $this->get('TData');
						$this->data = $obj->list;
						$this->cat = $obj->cat;
						$this->pid = $pid;
						break;
					}
				case 'tform':
					{
						$this->data = $this->get('TForm');
						$this->pid = $pid;
						break;
					}
				default:
					{
						$this->data = $this->get('CData');
					}
			}
		
		// Отображаем представление
		parent::display($tpl);
	}
}
?>
