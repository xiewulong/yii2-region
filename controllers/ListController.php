<?php
namespace yii\region\controllers;

use Yii;
use yii\components\Controller;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

use yii\region\models\Region;

class ListController extends Controller {

	public $defaultAction = 'children';

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['children'],
						'allow' => true,
						'roles' => $this->module->permissions,
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'children' => ['get'],
				],
			],
		];
	}

	public function actionChildren($id = 0) {
		if($id == 0) {
			$items = Region::find()
				->select(['id', 'name'])
				->where(['parent_id' => $id])
				->all();
			$done = true;
		} else {
			$item = Region::findOne($id);
			$done = !!$item;
			$items = $done ? $item->getChildren()
				->select(['id', 'name'])
				->all() : [];
		}

		return $this->respond([
			'error' => !$done,
			'message' => \Yii::t($this->module->messageCategory, $done ? 'operation succeeded' : 'no matched data'),
			'data' => $items,
		]);
	}

}
