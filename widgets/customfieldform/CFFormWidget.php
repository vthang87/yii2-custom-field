<?php
/**
 * Created by PhpStorm.
 * User: tamtk92
 * Date: 5/28/18
 * Time: 3:58 PM
 */

namespace vthang87\customfield\widgets\customfieldform;


use yii\base\Widget;

class CFFormWidget extends Widget
{
    public $model;
    public $form;
    
    public function run()
    {
        return $this->render('_form-custom-fields',[
            'form'  => $this->form,
            'model' => $this->model,
        ]);
    }
}