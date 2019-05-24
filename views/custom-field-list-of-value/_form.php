<?php

use vthang87\customfield\models\RecordStatus;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model vthang87\customfield\models\CustomFieldListOfValue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="custom-field-list-of-value-form">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?=Html::encode($this->title)?></h3>
        </div>
        <div class="panel-body">
			<?php $form = ActiveForm::begin(); ?>
			
			<?=$form->field($model,'custom_field_id')->hiddenInput()->label(null,['style' => 'display:none'])?>
			
			<?=$form->field($model,'display_value')->textInput(['maxlength' => true])?>
			
			<?=$form->field($model,'position')->textInput(['type' => 'number'])?>
			
			<?=$form->field($model,'status')->dropDownList(RecordStatus::getStatusList())?>

            <div class="form-group">
				<?=Html::submitButton($model->isNewRecord ? Yii::t('customfield','Create') : Yii::t('customfield','Update'),['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
            </div>
			
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
