<?php

use vthang87\customfield\models\CustomField;
use vthang87\customfield\models\RecordStatus;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\Sortable;
use yii\web\JsExpression;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model vthang87\customfield\models\CustomFieldGroup */
/* @var $customFieldSearchModel vthang87\customfield\models\search\CustomFieldSearch */
/* @var $customFieldDataProvider yii\data\ActiveDataProvider */

$this->title                   = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('customfield','Custom Field Groups'),'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custom-field-group-view">
    <h1><?=$this->title?></h1>
    <p>
		<?=Html::a(Yii::t('customfield','Update'),['update','id' => $model->custom_field_group_id],['class' => 'btn btn-primary'])?>
		<?=$model->status == RecordStatus::STATUS_ACTIVE ? Html::a(Yii::t('customfield','Deactivate'),['deactivate','id' => $model->custom_field_group_id],[
			'class' => 'btn btn-danger',
			'data'  => [
				'confirm' => Yii::t('customfield','Are you sure you want to deactivate this item?'),
				'method'  => 'post',
			],
		]) : Html::a(Yii::t('customfield','Activate'),['activate','id' => $model->custom_field_group_id],[
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
					'custom_field_group_id',
					'object_type',
					'name',
					'title',
				],
			])?>
        </div>
        <div class="col-md-6">
			<?=DetailView::widget([
				'model'      => $model,
				'attributes' => [
					'position',
					'created_at:datetime',
					'updated_at:datetime',
					'statusLabel',
				],
			])?>
        </div>
    </div>


    <div class="panel panel-primary">
        <div class="panel-heading"><h4 class="panel-title"><?=Yii::t('customfield','Custom fields')?></h4></div>
        <div class="panel-body">
            <p class="text-right">
				<?=Html::a('<i class="glyphicon glyphicon-plus"></i>',['custom-field/create','custom_field_group_id' => $model->custom_field_group_id],[
					'class' => 'btn
                btn-success',
				])?>
            </p>
			
			<?php
			$sortables = [];
			foreach($model->customFields as $customField){
				$actions     = [];
				$actions[]   = Html::a('<span class="glyphicon glyphicon-eye-open"></span>',[
					'custom-field/view',
					'id' => $customField->custom_field_id,
				],['title' => Yii::t('customfield','Update')]);
				$actions[]   = Html::a('<span class="glyphicon glyphicon-pencil"></span>',[
					'custom-field/update',
					'id' => $customField->custom_field_id,
				],['title' => Yii::t('customfield','Update')]);
				$actions[]   =
					$customField->status == RecordStatus::STATUS_ACTIVE ? Html::a('<span class="glyphicon glyphicon-remove text-danger"></span>',[
						'custom-field/deactivate',
						'id' => $customField->custom_field_id,
					],[
						'title'        => Yii::t('customfield','Deactivate'),
						'data-confirm' => Yii::t('customfield','Are you sure you want to deactivate this item?'),
						'data-method'  => 'post',
					]) : Html::a('<span class="glyphicon glyphicon-ok text-success"></span>',[
						'custom-field/activate',
						'id' => $customField->custom_field_id,
					],[
						'title'        => Yii::t('customfield','Activate'),
						'data-confirm' => Yii::t('customfield','Are you sure you want to activate this item?'),
						'data-method'  => 'post',
					]);
				$sortables[] = [
					'content' =>
						'<td class="text-center"><span class="glyphicon glyphicon-move sortable-handle" style="cursor: move"></span></td>' .
						'<td>' . $customField->title . '</td>' .
						'<td>' . $customField->name . '</td>' .
						'<td>' . $customField->type . '</td>' .
						'<td>' . $customField->object_type . '</td>' .
						'<td class="text-center">' . $customField->position . '</td>' .
						'<td class="text-center">' . ($customField->is_required == true ? '<i class="glyphicon glyphicon-ok text-success"></i>' : '<i class="glyphicon glyphicon-remove text-danger"></i>') .
						'</td>' .
						'<td class="text-center">
' . RecordStatus::getStatusLabel($customField->status) . '</td>' .
						'<td class="text-center">' . implode('&nbsp;&nbsp;',$actions) . '</td>',
					'options' => [
						'id' => 'CustomField_' . $customField->custom_field_id,
					],
				];
			}
			
			$customField = new CustomField();
			echo '<table class="table table-bordered table-striped table-sortable">';
			echo '<thead><tr>';
			echo '<th></th>';
			echo '<th>' . $customField->getAttributeLabel('title') . '</th>';
			echo '<th>' . $customField->getAttributeLabel('name') . '</th>';
			echo '<th>' . $customField->getAttributeLabel('type') . '</th>';
			echo '<th>' . $customField->getAttributeLabel('object_type') . '</th>';
			echo '<th class="text-center">' . $customField->getAttributeLabel('position') . '</th>';
			echo '<th class="text-center">' . $customField->getAttributeLabel('is_required') . '</th>';
			echo '<th class="text-center">' . $customField->getAttributeLabel('status') . '</th>';
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
                url: '" . Url::to(['custom-field/sort','id' => $model->custom_field_group_id]) . "',
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
