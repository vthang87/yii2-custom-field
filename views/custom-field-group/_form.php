<?php

use vthang87\customfield\models\CustomFieldGroup;
use vthang87\customfield\models\RecordStatus;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model vthang87\customfield\models\CustomFieldGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="custom-field-group-form">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?=Html::encode($this->title)?></h3>
        </div>
        <div class="panel-body">
			<?php $form = ActiveForm::begin(); ?>
			
			<?=$form->field($model,'object_type')->dropDownList(Yii::$app->getModule('customfield')->models,[
				'prompt' => Yii::t('customfield','Select'),
			])?>
			
			<?=$form->field($model,'title')->textInput(['maxlength' => true])?>
			
			<?=$form->field($model,'position')->textInput(['type' => 'number'])?>
			
			<?=$form->field($model,'status')->dropDownList(RecordStatus::getStatusList())?>

            <div class="form-group">
				<?=Html::submitButton($model->isNewRecord ? Yii::t('customfield','Create') : Yii::t('customfield','Update'),['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
            </div>
			
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
