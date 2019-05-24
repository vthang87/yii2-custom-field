<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model vthang87\customfield\models\CustomFieldListOfValue */

$this->title                   = Yii::t('customfield','Update {modelClass}: ',[
        'modelClass' => 'Custom Field List Of Value',
    ]) . $model->custom_field_list_of_value_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('customfield','Custom Field Groups'),'url' => ['custom-field-group/index']];
$this->params['breadcrumbs'][] = [
    'label' => $model->customField->customFieldGroup->title,
    'url'   => ['custom-field-group/view','id' => $model->customField->custom_field_group_id],
];
$this->params['breadcrumbs'][] = ['label' => $model->customField->name,'url' => ['custom-field/view','id' => $model->custom_field_id]];
$this->params['breadcrumbs'][] = Yii::t('customfield','Update');
?>
<div class="custom-field-list-of-value-update">
    
    <?=$this->render('_form',[
        'model' => $model,
    ])?>

</div>
