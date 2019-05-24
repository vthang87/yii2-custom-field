<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model vthang87\customfield\models\search\CustomFieldListOfValueSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="custom-field-list-of-value-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'custom_field_list_of_value_id') ?>

    <?= $form->field($model, 'custom_field_id') ?>

    <?= $form->field($model, 'display_value') ?>

    <?= $form->field($model, 'position') ?>

    <?= $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('customfield', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('customfield', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
