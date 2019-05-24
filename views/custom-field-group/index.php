<?php

use vthang87\customfield\models\CustomFieldGroup;
use vthang87\customfield\models\RecordStatus;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\jui\Sortable;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel vthang87\customfield\models\search\CustomFieldGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('customfield','Custom Field Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custom-field-group-index">
	<?php echo $this->render('_search',['model' => $searchModel]); ?>

    <div class="panel panel-primary">
        <div class="panel-heading"><h4 class="panel-title"><?=Yii::t('customfield','Custom field groups')?></h4></div>
        <div class="panel-body">
            <p class="text-right">
				<?=Html::a('<i class="glyphicon glyphicon-plus"></i>',['create'],[
					'class' => 'btn
                btn-success',
				])?>
            </p>
			
			<?php
			$sortables = [];
			/**
			 * @var CustomFieldGroup $customFieldGroup
			 */
			foreach($dataProvider->models as $customFieldGroup){
				$actions     = [];
				$actions[]   = Html::a('<span class="glyphicon glyphicon-eye-open"></span>',[
					'view',
					'id' => $customFieldGroup->custom_field_group_id,
				],['title' => Yii::t('customfield','Update')]);
				$actions[]   = Html::a('<span class="glyphicon glyphicon-pencil"></span>',[
					'update',
					'id' => $customFieldGroup->custom_field_group_id,
				],['title' => Yii::t('customfield','Update')]);
				$actions[]   =
					
					$customFieldGroup->status == RecordStatus::STATUS_ACTIVE ? Html::a('<span class="glyphicon glyphicon-remove text-danger"></span>',[
						'deactivate',
						'id' => $customFieldGroup->custom_field_group_id,
					],[
						'title'        => Yii::t('customfield','Deactivate'),
						'data-confirm' => Yii::t('customfield','Are you sure you want to deactivate this item?'),
						'data-method'  => 'post',
					]) : Html::a('<span class="glyphicon glyphicon-ok text-success"></span>',[
						'activate',
						'id' => $customFieldGroup->custom_field_group_id,
					],[
						'title'        => Yii::t('customfield','Activate'),
						'data-confirm' => Yii::t('customfield','Are you sure you want to activate this item?'),
						'data-method'  => 'post',
					]);
				$sortables[] = [
					'content' =>
					//'<td>' . $customFieldGroup->custom_field_group_id . '</td>' .
						'<td class="text-center"><span class="glyphicon glyphicon-move sortable-handle" style="cursor: move"></span></td>' .
						'<td>' . $customFieldGroup->title . '</td>' .
						'<td>' . $customFieldGroup->name . '</td>' .
						'<td>' . $customFieldGroup->object_type . '</td>' .
						'<td class="text-center">' . $customFieldGroup->position . '</td>' .
						'<td class="text-center">' . RecordStatus::getStatusLabel($customFieldGroup->status) . '</td>' .
						//'<td>' . $formatter->asDatetime($customFieldGroup->created_at) . '</td>' .
						//'<td>' . $formatter->asDatetime($customFieldGroup->updated_at) . '</td>' .
						'<td class="text-center">' . implode('&nbsp;&nbsp;',$actions) . '</td>',
					'options' => [
						'id' => 'CustomFieldGroup_' . $customFieldGroup->custom_field_group_id,
					],
				];
			}
			
			$customFieldGroup = new CustomFieldGroup();
			echo '<table class="table table-bordered table-striped table-sortable">';
			echo '<thead><tr>';
			//echo '<th>' . Yii::t('app','Id') . '</th>';
			echo '<th></th>';
			echo '<th>' . $customFieldGroup->getAttributeLabel('title') . '</th>';
			echo '<th>' . $customFieldGroup->getAttributeLabel('name') . '</th>';
			echo '<th>' . $customFieldGroup->getAttributeLabel('object_type') . '</th>';
			echo '<th class="text-center">' . $customFieldGroup->getAttributeLabel('position') . '</th>';
			echo '<th class="text-center">' . $customFieldGroup->getAttributeLabel('status') . '</th>';
			//echo '<th>' . $customFieldGroup->getAttributeLabel('created_at') . '</th>';
			//echo '<th>' . $customFieldGroup->getAttributeLabel('updated_at') . '</th>';
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
                url: '" . Url::to(['sort']) . "',
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
