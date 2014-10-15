<?php
// Защита от прямого доступа к файлу
defined('_JEXEC') or die('Restricted access');
?>
<content>
<?php echo $this->data->msg; ?>
</content>
<error>
<?php echo $this->data->error; ?>
</error>