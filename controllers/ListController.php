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
						'actions' => ['children', 'parents'],
						'allow' => true,
						'roles' => $this->module->permissions,
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'children' => ['get'],
					'parents' => ['get'],
				],
			],
		];
	}

	public function actionChildren($id = 0) {
		$item = Region::findOne($id);
		$done = !!$item;

		return $this->respond([
			'error' => !$done,
			'message' => \Yii::t($this->module->messageCategory, $done ? 'operation succeeded' : 'no matched data'),
			'data' => $done ? $item->children : [],
		]);
	}

	public function actionParents($id) {
		$item = Region::findOne($id);
		$done = !!$item;

		return $this->respond([
			'error' => !$done,
			'message' => \Yii::t($this->module->messageCategory, $done ? 'operation succeeded' : 'no matched data'),
			'data' => $done ? $item->children : [],
		]);
	}

}
