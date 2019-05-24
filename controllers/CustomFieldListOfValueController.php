<?php

namespace vthang87\customfield\controllers;

use vthang87\customfield\models\CustomField;
use vthang87\customfield\models\RecordStatus;
use Yii;
use vthang87\customfield\models\CustomFieldListOfValue;
use vthang87\customfield\models\search\CustomFieldListOfValueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomFieldListOfValueController implements the CRUD actions for CustomFieldListOfValue model.
 */
class CustomFieldListOfValueController extends Controller{
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
	 * Lists all CustomFieldListOfValue models.
	 * @return mixed
	 */
	public function actionIndex(){
		$searchModel  = new CustomFieldListOfValueSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		return $this->render('index',[
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
	
	/**
	 * Displays a single CustomFieldListOfValue model.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionView($id){
		return $this->render('view',[
			'model' => $this->findModel($id),
		]);
	}
	
	/**
	 * Creates a new CustomFieldListOfValue model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $custom_field_id
	 *
	 * @return mixed
	 */
	public function actionCreate($custom_field_id){
		$model                  = new CustomFieldListOfValue();
		$model->custom_field_id = $custom_field_id;
		
		$custom_field = CustomField::findOne($custom_field_id);
		
		if($model->load(Yii::$app->request->post()) && $model->save()){
			return $this->redirect(['custom-field/view','id' => $model->custom_field_id]);
		}else{
			Yii::trace($model->getErrors());
			
			return $this->render('create',[
				'model'        => $model,
				'custom_field' => $custom_field,
			]);
		}
	}
	
	/**
	 * Updates an existing CustomFieldListOfValue model.
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
			return $this->redirect(['custom-field/view','id' => $model->custom_field_id]);
		}else{
			return $this->render('update',[
				'model' => $model,
			]);
		}
	}
	
	/**
	 * Deletes an existing CustomFieldListOfValue model.
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
		
		return $this->redirect(['custom-field/view','id' => $model->custom_field_id]);
	}
	
	/**
	 * Activates an existing CustomFieldListOfValue model.
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
		
		return $this->redirect(['custom-field/view','id' => $model->custom_field_id]);
	}
	
	/**
	 * Finds the CustomFieldListOfValue model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return CustomFieldListOfValue the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id){
		if(($model = CustomFieldListOfValue::findOne($id)) !== null){
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
		if(Yii::$app->request->post('CustomFieldListOfValue')){
			foreach(Yii::$app->request->post('CustomFieldListOfValue') as $k => $id){
				$custom_field_list_of_value = CustomFieldListOfValue::findOne($id);
				if($custom_field_list_of_value){
					$custom_field_list_of_value->position = $k;
					$custom_field_list_of_value->save(false);
				}
			}
		}
	}
}
