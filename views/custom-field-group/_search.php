<?php

use vthang87\customfield\models\CustomFieldGroup;
use vthang87\customfield\models\RecordStatus;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model vthang87\customfield\models\search\CustomFieldGroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="custom-field-group-search">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
				<?=Html::encode(Yii::t('customfield','Search'))?>
            </h3>
        </div>
        <div class="panel-body">
			<?php $form = ActiveForm::begin([
				'action' => ['index'],
				'method' => 'get',
			]); ?>

            <div class="row">
                <div class="col-md-4">
		            <?=$form->field($model,'title')?>
                </div>
                <div class="col-md-4">
					<?=$form->field($model,'object_type')->dropDownList(Yii::$app->getModule('customfield')->models,[
						'prompt' => Yii::t('customfield','Select'),
					])?>
                </div>
                <div class="col-md-4">
					<?php echo $form->field($model,'status')->dropDownList(RecordStatus::getStatusList(),['prompt' => 'Select...']) ?>
                </div>
            </div>
            <div class="form-group">
				<?=Html::submitButton(Yii::t('customfield','Search'),['class' => 'btn btn-primary'])?>
				<?=Html::a(Yii::t('customfield','Reset'),['index'],[
					'class' => 'btn btn-flat btn-default',
					'title' => Yii::t('customfield','Reset Grid'),
				])?>
            </div>
			
			<?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
