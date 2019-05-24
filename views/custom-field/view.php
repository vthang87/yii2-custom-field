<?php

use vthang87\customfield\models\CustomFieldListOfValue;
use vthang87\customfield\models\RecordStatus;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\Sortable;
use yii\web\JsExpression;
use yii\widgets\DetailView;
use vthang87\customfield\models\CustomField;

/* @var $this yii\web\View */
/* @var $model vthang87\customfield\models\CustomField */
/* @var $customFieldListOfValueSearchModel \vthang87\customfield\models\search\CustomFieldListOfValueSearch */
/* @var $customFieldListOfValueDataProvider \yii\data\ActiveDataProvider */


$this->title                   = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('customfield','Custom Field Groups'),'url' => ['custom-field-group/index']];
$this->params['breadcrumbs'][] = [
	'label' => $model->customFieldGroup->title,
	'url'   => ['custom-field-group/view','id' => $model->custom_field_group_id],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custom-field-view">
    <h1><?=$this->title?></h1>
    <p>
		<?=Html::a(Yii::t('customfield','Update'),['update','id' => $model->custom_field_id],['class' => 'btn btn-primary'])?>
		<?=$model->status == RecordStatus::STATUS_ACTIVE ? Html::a(Yii::t('customfield','Deactivate'),['deactivate','id' => $model->custom_field_id],[
			'class' => 'btn btn-danger',
			'data'  => [
				'confirm' => Yii::t('customfield','Are you sure you want to deactivate this item?'),
				'method'  => 'post',
			],
		]) : Html::a(Yii::t('customfield','Activate'),['activate','id' => $model->custom_field_id],[
			'class' => 'btn btn-success',
			'data'  => [
				'confirm' => Yii::t('customfield','Are you sure you want to activate this item?'),
				'method'  => 'post',
			],
		])?>
    </p>
    <div class="row">
        <div class="col-md-6">
			<?=DetailView::widget([
				'model'      => $model,
				'attributes' => [
					'custom_field_id',
					'name',
					'title',
					'object_type',
					'type',
					[
						'label'     => Yii::t('customfield','Custom Field Group'),
						'attribute' => 'customFieldGroup.title',
					],
				],
			])?>
        </div>
        <div class="col-md-6">
			<?=DetailView::widget([
				'model'      => $model,
				'attributes' => [
					'options:ntext',
					'position',
					'is_required:boolean',
					'created_at:datetime',
					'updated_at:datetime',
					'statusLabel',
				],
			])?></div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading"><h4 class="panel-title"><?=Yii::t('customfield','List of values')?></h4></div>
        <div class="panel-body">
            <p class="text-right">
				<?=Html::a('<i class="glyphicon glyphicon-plus"></i>',[
					'custom-field-list-of-value/create',
					'custom_field_id' =>
						$model->custom_field_id,
				],[
					'class' => 'btn 
                    btn-success',
				])?>
            </p>
			
			<?php
			$sortables = [];
			$formatter = \Yii::$app->formatter;
			foreach($model->customFieldListOfValues as $customFieldListOfValue){
				$actions     = [];
				$actions[]   = Html::a('<span class="glyphicon glyphicon-pencil"></span>',[
					'custom-field-list-of-value/update',
					'id' => $customFieldListOfValue->custom_field_list_of_value_id,
				],['title' => Yii::t('customfield','Update')]);
				$actions[]   =
					$customFieldListOfValue->status == RecordStatus::STATUS_ACTIVE ? Html::a('<span class="glyphicon glyphicon-remove text-danger"></span>',[
						'custom-field-list-of-value/deactivate',
						'id' => $customFieldListOfValue->custom_field_list_of_value_id,
					],[
						'title'        => Yii::t('customfield','Deactivate'),
						'data-confirm' => Yii::t('customfield','Are you sure you want to deactivate this item?'),
						'data-method'  => 'post',
					]) : Html::a('<span class="glyphicon glyphicon-ok text-success"></span>',[
						'custom-field-list-of-value/activate',
						'id' => $customFieldListOfValue->custom_field_list_of_value_id,
					],[
						'title'        => Yii::t('customfield','Activate'),
						'data-confirm' => Yii::t('customfield','Are you sure you want to activate this item?'),
						'data-method'  => 'post',
					]);
				$sortables[] = [
					'content' =>
						'<td class="text-center"><span class="glyphicon glyphicon-move sortable-handle" style="cursor: move"></span></td>' .
						'<td>' . $customFieldListOfValue->display_value . '</td>' .
						'<td class="text-center">' . $customFieldListOfValue->statusLabel . '</td>' .
						'<td class="text-center">' . $customFieldListOfValue->position . '</td>' .
						'<td>' . $formatter->asDatetime($customFieldListOfValue->created_at) . '</td>' .
						'<td>' . $formatter->asDatetime($customFieldListOfValue->updated_at) . '</td>' .
						'<td class="text-center">
' . implode('&nbsp;&nbsp;',$actions) . '</td>',
					'options' => [
						'id' => 'CustomFieldListOfValue_' . $customFieldListOfValue->custom_field_list_of_value_id,
					],
				];
			}
			
			$customFieldListOfValue = new CustomFieldListOfValue();
			echo '<table class="table table-bordered table-striped table-sortable">';
			echo '<thead><tr>';
			echo '<th></th>';
			echo '<th>' . $customFieldListOfValue->getAttributeLabel('display_value') . '</th>';
			echo '<th class="text-center">' . $customFieldListOfValue->getAttributeLabel('status') . '</th>';
			echo '<th class="text-center">' . $customFieldListOfValue->getAttributeLabel('position') . '</th>';
			echo '<th>' . $customFieldListOfValue->getAttributeLabel('created_at') . '</th>';
			echo '<th>' . $customFieldListOfValue->getAttributeLabel('updated_at') . '</th>';
			echo '<th>' . '</th>';
			echo '</tr></thead>';
			echo Sortable::widget([
				'items'         => $sortables,
				'options'       => [
					//'class' => 'list-group',
					'tag' => 'tbody',
				],
				'itemOptions'   => ['tag' => 'tr'],
				'clientOptions' => [
					'cursor' => 'move',
					'axis'   => 'y',
					'update' => new JsExpression("function(event, ui){
                    console.log($(event.target).sortable('serialize'));
            $.ajax({
                type: 'POST',
                url: '" . Url::to(['custom-field-list-of-value/sort','id' => $model->custom_field_id]) . "',
                data: $(event.target).sortable('serialize') + '&_csrf=" . Yii::$app->request->getCsrfToken() . "',
                success: function() {
                location.reload();
                }
                });
                }"),
				],
			]);
			echo '</table>'
			?>
        </div>
    </div>
</div>