<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model vthang87\customfield\models\CustomFieldListOfValue */

$this->title                   = $model->custom_field_list_of_value_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('customfield','Custom Field List Of Values'),'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custom-field-list-of-value-view">
    
    <h1><?=Html::encode($this->title)?></h1>
    
    <p>
        <?=Html::a(Yii::t('customfield','Update'),['update','id' => $model->custom_field_list_of_value_id],['class' => 'btn btn-primary'])?>
        <?=Html::a(Yii::t('customfield','Delete'),['delete','id' => $model->custom_field_list_of_value_id],[
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('customfield','Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ])?>
    </p>
    
    <?=DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'custom_field_list_of_value_id',
            'custom_field_id',
            'display_value',
            'position',
            'statusLabel',
            'created_at',
            'updated_at',
        ],
    ])?>

</div>
