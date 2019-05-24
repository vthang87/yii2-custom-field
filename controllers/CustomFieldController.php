<?php

namespace vthang87\customfield\controllers;

use vthang87\customfield\models\CustomField;
use vthang87\customfield\models\CustomFieldGroup;
use vthang87\customfield\models\form\CustomFieldForm;
use vthang87\customfield\models\RecordStatus;
use vthang87\customfield\models\search\CustomFieldListOfValueSearch;
use vthang87\customfield\models\search\CustomFieldSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * CustomFieldController implements the CRUD actions for CustomField model.
 */
class CustomFieldController extends Controller{
	/**
	 * @inheritdoc
	 */
	public function behaviors(){
		return [
			'verbs' => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}
	
	/**
	 * Lists all CustomField models.
	 * @return mixed
	 */
	public function actionIndex(){
		$searchModel  = new CustomFieldSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		return $this->render('index',[
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
	
	/**
	 * Displays a single CustomField model.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionView($id){
		$customFieldListOfValueSearchModel                  = new CustomFieldListOfValueSearch();
		$customFieldListOfValueSearchModel->custom_field_id = $id;
		
		$customFieldListOfValueDataProvider = $customFieldListOfValueSearchModel->search(Yii::$app->request->queryParams);
		$model                              = $this->findModel($id);
		if(in_array($model->type,CustomField::getListOfValueTypes()) && $customFieldListOfValueDataProvider->count <= 0){
			Yii::$app->getSession()->setFlash('danger','Missing list of values for ' . $model->type . '.');
		}
		
		return $this->render('view',[
			'model'                              => $model,
			'customFieldListOfValueSearchModel'  => $customFieldListOfValueSearchModel,
			'customFieldListOfValueDataProvider' => $customFieldListOfValueDataProvider,
		]);
	}
	
	/**
	 * Creates a new CustomField model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $custom_field_group_id
	 *
	 * @return mixed
	 */
	public function actionCreate($custom_field_group_id){
		$model                        = new CustomField();
		$model->custom_field_group_id = $custom_field_group_id;
		
		$custom_field_group = CustomFieldGroup::findOne($custom_field_group_id);
		$model->object_type = $custom_field_group->object_type;
		
		if($model->load(Yii::$app->request->post()) && $model->save()){
			return $this->redirect(['view','id' => $model->custom_field_id]);
		}else{
			return $this->render('create',[
				'model'              => $model,
				'custom_field_group' => $custom_field_group,
			]);
		}
	}
	
	
	/**
	 * Updates an existing CustomField model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionUpdate($id){
		$model = $this->findModel($id);
		
		if($model->load(Yii::$app->request->post()) && $model->save()){
			return $this->redirect(['view','id' => $model->custom_field_id]);
		}else{
			return $this->render('update',[
				'model' => $model,
			]);
		}
	}
	
	
	/**
	 * Deletes an existing CustomField model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionDeactivate($id){
		$model = $this->findModel($id);
		
		$model->status = RecordStatus::STATUS_INACTIVE;
		
		$model->save();
		
		return $this->redirect(['custom-field-group/view','id' => $model->custom_field_group_id]);
	}
	
	/**
	 * Activates an existing CustomField model.
	 * If activation is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionActivate($id){
		$model = $this->findModel($id);
		
		$model->status = RecordStatus::STATUS_ACTIVE;
		
		$model->save();
		
		return $this->redirect(['custom-field-group/view','id' => $model->custom_field_group_id]);
	}
	
	/**
	 * Finds the CustomField model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return CustomField the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id){
		if(($model = CustomField::findOne($id)) !== null){
			return $model;
		}else{
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
	
	/**
	 * Sets the sort order of Status models.
	 *
	 * @throws HttpException
	 */
	public function actionSort(){
		if(Yii::$app->request->post('CustomField')){
			foreach(Yii::$app->request->post('CustomField') as $k => $id){
				$custom_field = CustomField::findOne($id);
				if($custom_field){
					$custom_field->position = $k;
					$custom_field->save(false);
				}
			}
		}
	}
}
