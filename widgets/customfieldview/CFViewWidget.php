<?php
/**
 * Created by PhpStorm.
 * User: tamtk92
 * Date: 5/28/18
 * Time: 3:58 PM
 */

namespace vthang87\customfield\widgets\customfieldview;


use yii\base\Widget;

class CFViewWidget extends Widget
{
    public $model;
    
    public function run()
    {
        return $this->render('_view-custom-fields',[
            'model' => $this->model,
        ]);
    }
}