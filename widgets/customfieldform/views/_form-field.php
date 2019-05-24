<?php
/**
 * Created by PhpStorm.
 * User: devlcs
 * Date: 11/2/16
 * Time: 5:07 PM
 */

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $custom_field \vthang87\customfield\models\CustomField */
/* @var $custom_field_value \vthang87\customfield\models\CustomFieldValue */
/* @var $object_id string */

/* @var $object \yii\base\Model */


use vthang87\customfield\components\CustomFieldCheckbox;
use vthang87\customfield\components\CustomFieldDate;
use vthang87\customfield\components\CustomFieldDateTime;
use vthang87\customfield\components\CustomFieldRadio;
use vthang87\customfield\components\CustomFieldSelect;
use vthang87\customfield\components\CustomFieldTime;
use vthang87\customfield\models\CustomField;
use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use kartik\widgets\Select2;
use kartik\widgets\TimePicker;
use yii\helpers\ArrayHelper;

?>
<?php
$form_field_name = Yii::$app->getModule('customfield')->formFieldName;
if (in_array($custom_field->type,CustomField::getListOfValueTypes())) {
    $custom_field_list_of_values = $custom_field->getAvailableCustomFieldListOfValues();
    $list_of_values              = ArrayHelper::map($custom_field_list_of_values,'custom_field_list_of_value_id','display_value');
    if ($custom_field->type == CustomFieldCheckbox::TYPE) {
        if (count($custom_field_list_of_values) > 0) {
            echo $form->field($object,'value')->checkboxList($list_of_values,[
                'separator' => '<br>',
                'id'        => "{$form_field_name}_{$custom_field->custom_field_id}_value",
                'name'      => "{$form_field_name}[$custom_field->custom_field_id][value]",
            ])->label($custom_field->title);
        }else {
            echo $form->field($object,'value')->checkbox([
                'label' => null,
                'id'    => "{$form_field_name}_{$custom_field->custom_field_id}_value",
                'name'  => "{$form_field_name}[$custom_field->custom_field_id][value]",
            ])->label($custom_field->title);
        }
    }elseif ($custom_field->type == CustomFieldRadio::TYPE) {
        if (count($custom_field_list_of_values) > 0) {
            echo $form->field($object,'value')->radioList($list_of_values,[
                'separator' => '<br>',
                'id'        => "{$form_field_name}_{$custom_field->custom_field_id}_value",
                'name'      => "{$form_field_name}[$custom_field->custom_field_id][value]",
            ])->label($custom_field->title);
        }
    }elseif ($custom_field->type == CustomFieldSelect::TYPE) {
        if (count($custom_field_list_of_values) > 0) {
            echo $form->field($object,'value')->widget(Select2::class,[
                'data'          => $list_of_values,
                'options'       => [
                    'placeholder' => Yii::t('customfield','Select...'),
                    'id'          => "{$form_field_name}_{$custom_field->custom_field_id}_value",
                    'name'        => "{$form_field_name}[$custom_field->custom_field_id][value]",
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label($custom_field->title);
        }
    }
}elseif ($custom_field->type == CustomFieldDate::TYPE) {
    echo $form->field($object,'value')->widget(DatePicker::class,[
        'options'       => [
            'placeholder' => Yii::t('customfield','Enter date...'),
            'id'          => "{$form_field_name}_{$custom_field->custom_field_id}_value",
            'name'        => "{$form_field_name}[$custom_field->custom_field_id][value]",
        ],
        'pluginOptions' => [
            'autoclose' => true,
            'format'    => 'dd/mm/yyyy',
        ],
    ])->label($custom_field->title);
}elseif ($custom_field->type == CustomFieldDateTime::TYPE) {
    echo $form->field($object,'value')->widget(DateTimePicker::class,[
        'options'       => [
            'placeholder' => Yii::t('customfield','Enter date...'),
            'id'          => "{$form_field_name}_{$custom_field->custom_field_id}_value",
            'name'        => "{$form_field_name}[$custom_field->custom_field_id][value]",
        ],
        'pluginOptions' => [
            'format'         => 'dd/mm/yyyy hh:ii',
            'todayHighlight' => true,
            'autoclose'      => true,
        ],
    ])->label($custom_field->title);
}elseif ($custom_field->type == CustomFieldTime::TYPE) {
    echo $form->field($object,'value')->widget(TimePicker::class,[
        'options' => [
            'id'   => "{$form_field_name}_{$custom_field->custom_field_id}_value",
            'name' => "{$form_field_name}[$custom_field->custom_field_id][value]",
        ],
    ]);
}else {
    echo $form->field($object,'value')->textInput([
        'maxlength' => true,
        'id'        => "{$form_field_name}_{$custom_field->custom_field_id}_value",
        'name'      => "{$form_field_name}[$custom_field->custom_field_id][value]",
    ])->label($custom_field->title);
    
} ?>