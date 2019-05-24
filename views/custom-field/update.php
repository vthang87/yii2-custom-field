<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model vthang87\customfield\models\CustomField */


$this->title                   = Yii::t('customfield','Update {modelClass}: ',[
        'modelClass' => 'Custom Field',
    ]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('customfield','Custom Field Groups'),'url' => ['custom-field-group/index']];
$this->params['breadcrumbs'][] = [
    'label' => $model->customFieldGroup->title,
    'url'   => ['custom-field-group/view','id' => $model->custom_field_group_id],
];
$this->params['breadcrumbs'][] = ['label' => $model->name,'url' => ['view','id' => $model->custom_field_id]];
$this->params['breadcrumbs'][] = Yii::t('customfield','Update');
?>
<div class="custom-field-update">
    
    <?=$this->render('_form',[
        'model' => $model,
    ])?>

</div>
