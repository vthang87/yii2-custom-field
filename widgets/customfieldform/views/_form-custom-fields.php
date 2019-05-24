<?php
/**
 * Created by PhpStorm.
 * User: devlcs
 * Date: 11/2/16
 * Time: 2:11 PM
 */
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

/* @var $model \yii\db\ActiveRecord */

use vthang87\customfield\components\CustomFieldCheckbox;
use vthang87\customfield\models\CustomFieldGroup;
use yii\widgets\ActiveForm;
use vthang87\customfield\models\CustomFieldValue;
use vthang87\customfield\models\CustomField;
use yii\helpers\Html;

?>
<?php
$object_type         = get_class($model);
$object_id           = $model->getPrimaryKey();
$custom_field_groups = $model->getActiveGroups() ?>
<?php
/**
 * @var CustomFieldGroup $group
 */
$form_field_name = Yii::$app->getModule('customfield')->formFieldName;
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
            <?php $custom_fields = $group->getAvailableCustomFields($object_type) ?>
            <?php
            /**
             * @var CustomField $field
             */
            foreach ($custom_fields as $field) {
                
                $object = CustomField::getCustomFieldTypeClass($field->type);
                
                if (isset($model->customFields)) {
                    if (isset($model->customFields[$field->custom_field_id])) {
                        $object->setAttributes($model->customFields[$field->custom_field_id]);
                    }
                }
                
                
                /**
                 * @var CustomFieldValue $custom_field_value
                 */
                $custom_field_values = $field->getAvailableCustomFieldValues($object_id);
                $custom_field_value  = new CustomFieldValue();
                if ($custom_field_values != null && count($custom_field_values) > 0) {
                    if (count($custom_field_values) == 1) {
                        $custom_field_value = $custom_field_values[0];
                        $object->setValue($custom_field_value->value);
                    }else {
                        $value = [];
                        foreach ($custom_field_values as $cfv) {
                            $value[] = $cfv->value;
                        }
                        $object->setValue($value);
                    }
                }
                
                /**
                 * Prepare form
                 */
                echo $form->field($object,'custom_field_value_id')->hiddenInput([
                    'maxlength' => true,
                    'value'     => $custom_field_value->custom_field_value_id,
                    'id'        => "{$form_field_name}_{$field->custom_field_id}custom_field_value_id",
                    'name'      => "{$form_field_name}[$field->custom_field_id][custom_field_value_id]",
                ])->label(null,['style' => 'display:none']);
                
                echo $form->field($object,'custom_field_id')->hiddenInput([
                    'maxlength' => true,
                    'value'     => $field->custom_field_id,
                    'id'        => "{$form_field_name}_{$field->custom_field_id}_custom_field_id",
                    'name'      => "{$form_field_name}[$field->custom_field_id][custom_field_id]",
                ])->label(null,['style' => 'display:none']);
                
                echo $form->field($object,'object_id')->hiddenInput([
                    'maxlength' => true,
                    'value'     => $object_id,
                    'id'        => "{$form_field_name}_{$field->custom_field_id}object_id",
                    'name'      => "{$form_field_name}[$field->custom_field_id][object_id]",
                ])->label(null,['style' => 'display:none']);
                
                echo $form->field($object,'type')->hiddenInput([
                    'maxlength' => true,
                    'value'     => $field->type,
                    'id'        => "{$form_field_name}_{$field->custom_field_id}type",
                    'name'      => "{$form_field_name}[$field->custom_field_id][type]",
                ])->label(null,['style' => 'display:none']);
                
                if ($field->type == CustomFieldCheckbox::TYPE) {
                    echo $form->field($object,'is_array')->hiddenInput([
                        'maxlength' => true,
                        'value'     => true,
                        'id'        => "{$form_field_name}_{$field->custom_field_id}is_array",
                        'name'      => "{$form_field_name}[$field->custom_field_id][is_array]",
                    ])->label(null,['style' => 'display:none']);
                }
                
                /**
                 * Render form based on type
                 */
                echo $this->render('_form-field',[
                    'form'               => $form,
                    'object'             => $object,
                    'custom_field'       => $field,
                    'custom_field_value' => $custom_field_value,
                ]);
            } ?>
        </div>
        <?php echo '</div>' ?>
    </div>
<?php } ?>

<?=$form->errorSummary($model);?>
