<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel vthang87\customfield\models\search\CustomFieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('customfield', 'Custom Fields');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custom-field-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('customfield', 'Create Custom Field'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'custom_field_id',
            'custom_field_group_id',
            'object_type',
            'name',
            'title',
            // 'type',
            // 'options:ntext',
            // 'position',
            // 'is_required',
            // 'created_at',
            // 'updated_at',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
