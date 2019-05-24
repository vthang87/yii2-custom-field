<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model vthang87\customfield\models\CustomField */
/* @var $custom_field_group vthang87\customfield\models\CustomFieldGroup */

$this->title                   = Yii::t('customfield','Create Custom Field');
$this->params['breadcrumbs'][] = ['label' => Yii::t('customfield','Custom Field Groups'),'url' => ['custom-field-group/index']];
$this->params['breadcrumbs'][] = ['label' => $custom_field_group->title,'url' => ['custom-field-group/view','id' => $custom_field_group->custom_field_group_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custom-field-create">
    
    <?=$this->render('_form',[
        'model' => $model,
    ])?>

</div>
