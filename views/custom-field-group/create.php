<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model vthang87\customfield\models\CustomFieldGroup */

$this->title                   = Yii::t('customfield','Create Custom Field Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('customfield','Custom Field Groups'),'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custom-field-group-create">
    
    <?=$this->render('_form',[
        'model' => $model,
    ])?>

</div>
