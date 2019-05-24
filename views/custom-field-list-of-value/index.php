<?php

use vthang87\customfield\models\CustomFieldListOfValue;
use vthang87\customfield\models\RecordStatus;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel vthang87\customfield\models\search\CustomFieldListOfValueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('customfield','Custom Field List Of Values');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custom-field-list-of-value-index">
    
    <h1><?=Html::encode($this->title)?></h1>
    
    <p>
        <?=Html::a(Yii::t('customfield','Create Custom Field List Of Value'),['create'],['class' => 'btn btn-success'])?>
    </p>
    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'custom_field_list_of_value_id',
            'custom_field_id',
            'display_value',
            'position',
            'created_at',
            // 'updated_at',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);?>
</div>
