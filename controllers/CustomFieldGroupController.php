<?php

namespace vthang87\customfield\controllers;


use vthang87\customfield\models\RecordStatus;
use vthang87\customfield\models\search\CustomFieldSearch;
use Yii;
use vthang87\customfield\models\CustomFieldGroup;
use vthang87\customfield\models\search\CustomFieldGroupSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomFieldGroupController implements the CRUD actions for CustomFieldGroup model.
 */
class CustomFieldGroupController extends Controller{
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
	 * Lists all CustomFieldGroup models.
	 * @return mixed
	 */
	public function actionIndex(){
		$searchModel = new CustomFieldGroupSearch();
		
		
		$dataProvider = $searchModel->customSearch(Yii::$app->request->queryParams);
		
		return $this->render('index',[
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
	
	/**
	 * Displays a single CustomFieldGroup model.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionView($id){
		$customFieldSearchModel                        = new CustomFieldSearch();
		$customFieldSearchModel->custom_field_group_id = $id;
		$customFieldDataProvider                       = $customFieldSearchModel->search(Yii::$app->request->queryParams);
		
		return $this->render('view',[
			'model'                   => $this->findModel($id),
			'customFieldSearchModel'  => $customFieldSearchModel,
			'customFieldDataProvider' => $customFieldDataProvider,
		]);
	}
	
	/**
	 * Creates a new CustomFieldGroup model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate(){
		$model = new CustomFieldGroup();
		
		if($model->load(Yii::$app->request->post()) && $model->save()){
			return $this->redirect(['view','id' => $model->custom_field_group_id]);
		}else{
			return $this->render('create',[
				'model' => $model,
			]);
		}
	}
	
	/**
	 * Updates an existing CustomFieldGroup model.
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
			return $this->redirect(['view','id' => $model->custom_field_group_id]);
		}else{
			return $this->render('update',[
				'model' => $model,
			]);
		}
	}
	
	/**
	 * Deletes an existing CustomFieldGroup model.
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
		
		return $this->redirect([
			'view',
			'id' => $id,
		]);
	}
	
	/**
	 * Activate an existing CustomFieldGroup model.
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
		
		return $this->redirect([
			'view',
			'id' => $id,
		]);
	}
	
	/**
	 * Finds the CustomFieldGroup model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return CustomFieldGroup the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id){
		if(($model = CustomFieldGroup::findOne($id)) !== null){
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
		if(Yii::$app->request->post('CustomFieldGroup')){
			foreach(Yii::$app->request->post('CustomFieldGroup') as $k => $id){
				$custom_field_group = CustomFieldGroup::findOne($id);
				if($custom_field_group){
					$custom_field_group->position = $k;
					$custom_field_group->save(false);
				}
			}
		}
	}
}
