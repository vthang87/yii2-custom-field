<?php
/**
 * Created by PhpStorm.
 * User: devlcs
 * Date: 11/2/16
 * Time: 2:11 PM
 */
/* @var $this yii\web\View */
///* @var $object_id string */

/* @var $model \yii\db\ActiveRecord */

use vthang87\customfield\models\CustomFieldGroup;
use vthang87\customfield\models\CustomFieldValue;
use vthang87\customfield\models\CustomField;
use yii\helpers\Html;

?>
<?php
$object_type         = get_class($model);
$object_id           = $model->getPrimaryKey();
$custom_field_groups = CustomFieldGroup::getAvailableCustomFieldGroups($object_type) ?>
<?php
/**
 * @var CustomFieldGroup $group
 */
foreach ($custom_field_groups as $group) {
    $panel_id = 'panel_' . $group->custom_field_group_id . '_group';
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <?=Html::a($group->title,'#' . $panel_id,['data-toggle' => 'collapse'])?>
            </h4>
        </div>
        <?php
        echo '<div id=' . $panel_id . ' class="panel-collapse collapse in">' ?>
        <div class="panel-body">
            <?php
            $custom_fields = $group->getAvailableCustomFields($object_type);
            echo '<table class="table table-striped .table-hover">';
            echo '<tbody>';
            /**
             * @var CustomField $field
             */
            foreach ($custom_fields as $field) {
                /**
                 * @var CustomFieldValue $custom_field_value
                 */
                $custom_field_values = $field->getAvailableCustomFieldValues($object_id);
                if ($custom_field_values != null && count($custom_field_values) > 0) {
                    $values = [];
                    foreach ($custom_field_values as $custom_field_value) {
                        $values[] = $custom_field_value->customFieldListOfValue != null ? $custom_field_value->customFieldListOfValue->display_value : $custom_field_value->value;
                    }
                    
                    if ($custom_field_value != null) {
                        echo '<tr>';
                        echo '<th class="col-xs-5">';
                        echo $field->title;
                        echo '</th>';
                        echo '<td class="col-xs-7">';
                        echo implode('<br>',$values);
                        echo '</td>';
                        echo '</tr>';
                    }
                }
            }
            echo '</tbody>';
            echo '</table>';
            ?>
        </div>
        <?php echo '</div>'; ?>
    </div>
<?php } ?>
