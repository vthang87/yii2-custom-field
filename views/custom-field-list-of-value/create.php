<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model vthang87\customfield\models\CustomFieldListOfValue */
/* @var $custom_field vthang87\customfield\models\CustomField */

$this->title                   = Yii::t('customfield','Create Custom Field List Of Value');
$this->params['breadcrumbs'][] = ['label' => Yii::t('customfield','Custom Field Groups'),'url' => ['custom-field-group/index']];
$this->params['breadcrumbs'][] = [
    'label' => $custom_field->customFieldGroup->title,
    'url'   => ['custom-field-group/view','id' => $custom_field->custom_field_group_id],
];
$this->params['breadcrumbs'][] = ['label' => $custom_field->name,'url' => ['custom-field/view','id' => $custom_field->custom_field_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custom-field-list-of-value-create">
    
    <?=$this->render('_form',[
        'model' => $model,
    ])?>

</div>
