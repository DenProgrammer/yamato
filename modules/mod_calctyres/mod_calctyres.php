<?php
if (!defined('_VALID_MOS') && !defined('_JEXEC')) {
    die('Direct Access to ' . basename(__FILE__) . ' is not allowed.');
}

$db = & JFactory::getDBO();

$query  = "SELECT DISTINCT marka "
        . "FROM #__vm_product "
        . "WHERE product_type = 'rezina' AND marka <> 'NONE' "
        . "ORDER BY marka";
$db->setQuery($query);
$markas = $db->loadObjectList();

$query = "SELECT DISTINCT CONVERT(product_width, SIGNED) width "
        . "FROM #__vm_product "
        . "WHERE product_type = 'rezina' AND product_width > 0 "
        . "ORDER BY product_width";
$db->setQuery($query);
$width = $db->loadObjectList();

$query  = "SELECT DISTINCT CONVERT(product_height, SIGNED) height "
        . "FROM #__vm_product "
        . "WHERE product_type = 'rezina' AND product_height > 0 "
        . "ORDER BY product_height";
$db->setQuery($query);
$height = $db->loadObjectList();

$query  = "SELECT DISTINCT CONVERT(product_length, SIGNED) length "
        . "FROM #__vm_product "
        . "WHERE product_type = 'rezina' AND product_length > 0 "
        . "ORDER BY product_length";
$db->setQuery($query);
$length = $db->loadObjectList();
?>
<div class="calctyres">
    <h2>Подбор шин</h2>
    <div class="calctyres_row">
        Производитель<br />
        <select id="calctyres_marka">
            <option></option>
            <?php
            foreach ($markas as $item) {
                $sel = (JRequest::getVar('marka') == $item->marka) ? 'selected' : '';
                echo '<option ' . $sel . ' value="' . $item->marka . '">' . $item->marka . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="calctyres_row calctyres_sizes">
        <div class="calctyres_col">
            Ширина<br />
            <select id="calctyres_width">
                <option></option>
                <?php
                foreach ($width as $item) {
                    $sel = (JRequest::getVar('width') == $item->width) ? 'selected' : '';
                    echo '<option ' . $sel . ' value="' . $item->width . '">' . $item->width . '</option>';
                }
                ?>
            </select>
        </div>
        &nbsp;/&nbsp;
        <div class="calctyres_col">
            Профиль<br />
            <select id="calctyres_height">
                <option></option>
                <?php
                foreach ($height as $item) {
                    $sel = (JRequest::getVar('height') == $item->height) ? 'selected' : '';
                    echo '<option ' . $sel . ' value="' . $item->height . '">' . $item->height . '</option>';
                }
                ?>
            </select>
        </div>
        &nbsp;&nbsp;&nbsp;
        <div class="calctyres_col">
            Диаметр<br />
            <select id="calctyres_length">
                <option></option>
                <?php
                foreach ($length as $item) {
                    $sel = (JRequest::getVar('length') == $item->length) ? 'selected' : '';
                    echo '<option ' . $sel . ' value="' . $item->length . '">R' . $item->length . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <input name="send" type="button" value="Подобрать" />
    <input name="reset" type="button" value="Сбросить" />
</div>
<style>
    div.calctyres{
        background: #ebebeb;
        border-radius: 5px;
        width: 210px;
        padding: 5px;
        text-align: center;
        float: left;
        margin-right: 30px;
        margin-top: 3px;
    }
    div.calctyres_col{
        display: inline-block;
    }
    div.calctyres h2{
        margin-top: 3px;
        margin-bottom: 8px;
    }
    div.calctyres input[type='button']{
        background: -moz-linear-gradient(to bottom, #f90000 30%, #990000 100%) repeat-x scroll 0 0 #ed0000;
        background: -o-linear-gradient(to bottom, #f90000 30%, #990000 100%) repeat-x scroll 0 0 #ed0000;
        background: -webkit-linear-gradient(#f90000 30%, #990000 100%) repeat-x scroll 0 0 #ed0000;
        background: linear-gradient(to bottom, #f90000 30%, #990000 100%) repeat-x scroll 0 0 #ed0000;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
        color: #fff;
        padding: 5px 10px;
        margin: 8px auto;
        cursor: pointer;
    }
    div.calctyres input[name='reset']{
        background: -moz-linear-gradient(to bottom, #bbbbbb 30%, #999999 100%) repeat-x scroll 0 0 #ed0000;
        background: -o-linear-gradient(to bottom, #bbbbbb 30%, #999999 100%) repeat-x scroll 0 0 #ed0000;
        background: -webkit-linear-gradient(#bbbbbb 30%, #999999 100%) repeat-x scroll 0 0 #ed0000;
        background: linear-gradient(to bottom, #bbbbbb 30%, #999999 100%) repeat-x scroll 0 0 #ed0000;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
        color: #fff;
        padding: 5px 10px;
        margin: 8px auto;
        cursor: pointer;
    }
    div.calctyres_row{
        padding: 10px 5px;
        background-image: -moz-linear-gradient(#eaeaea, #f0f0f0 50%, #f7f7f7);
        background-image: -webkit-linear-gradient(#eaeaea, #f0f0f0 50%, #f7f7f7);
        background-image: -o-linear-gradient(#eaeaea, #f0f0f0 50%, #f7f7f7);
        background-image: linear-gradient(#eaeaea, #f0f0f0 50%, #f7f7f7);
        background-repeat: no-repeat;
        border-top: 1px solid #b6b6b6;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
    }
    #calctyres_marka{
        width: 90%;
    }
    div.calctyres_sizes select{
        width: 100%;
    }
    div.calctyres select{
        border: solid 1px #999999;
        box-shadow: 0 0 3px 2px rgba(0,0,0,0.2);
        border-radius: 10px;
        margin-top: 7px;
        margin-bottom: 3px;
        background: -moz-linear-gradient(to bottom, #ffffff 0%, #efefef 35%, #d8d8d8 83%, #f6f6f6 100%);
        background: -webkit-linear-gradient(to bottom, #ffffff 0%, #efefef 35%, #d8d8d8 83%, #f6f6f6 100%);
        background: -o-linear-gradient(#ffffff 0%, #efefef 35%, #d8d8d8 83%, #f6f6f6 100%);
        background: linear-gradient(to bottom, #ffffff 0%, #efefef 35%, #d8d8d8 83%, #f6f6f6 100%);
        padding: 0 3px;
    }
</style>
<script>
    jQuery(document).ready(function($) {
        $('div.calctyres input[name="send"]').click(function() {
            var marka = $('#calctyres_marka').val();
            var width = $('#calctyres_width').val();
            var height = $('#calctyres_height').val();
            var length = $('#calctyres_length').val();

            var url = 'index.php?option=com_virtuemart&page=shop.browse&category_id=<?php echo JRequest::getInt('category_id'); ?>&Itemid=<?php echo JRequest::getInt('Itemid'); ?>';

            if (marka)
                url += '&marka=' + marka;
            if (width)
                url += '&width=' + width;
            if (height)
                url += '&height=' + height;
            if (length)
                url += '&length=' + length;

            document.location = url;
        });
        $('div.calctyres input[name="reset"]').click(function() {
            $('#calctyres_marka').val('');
            $('#calctyres_width').val('');
            $('#calctyres_height').val('');
            $('#calctyres_length').val('');
            $('div.calctyres input[name="send"]').click();
        });
    });
</script>

