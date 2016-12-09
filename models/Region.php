<?php
namespace yii\region\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\components\ActiveRecord;

/**
 * Region model
 *
 * @since 0.0.1
 * @property {integer} $id
 * @property {integer} $parent_id
 * @property {string} $name
 * @property {integer} $operator_id
 * @property {integer} $creator_id
 * @property {integer} $created_at
 * @property {integer} $updated_at
 */
class Region extends ActiveRecord {

	public $messageCategory = 'region';

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%region}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			TimestampBehavior::className(),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			['name', 'trim'],
			['name', 'required'],

			[['creator_id', 'operator_id'], 'filter', 'filter' => function($value) {
				return \Yii::$app->user->isGuest ? 0 : \Yii::$app->user->identity->id;
			}],

			// Query data needed
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		$scenarios = parent::scenarios();

		$scenarios['add'] = [
			'parent_id',
			'name',
			'creator_id',
			'operator_id',
		];

		$scenarios['edit'] = [
			'parent_id',
			'name',
			'operator_id',
		];

		return $scenarios;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => \Yii::t($this->messageCategory, 'region id'),
			'parent_id' => \Yii::t($this->messageCategory, 'parent'),
			'name' => \Yii::t($this->messageCategory, 'name'),
			'operator_id' => \Yii::t($this->messageCategory, 'operator id'),
			'creator_id' => \Yii::t($this->messageCategory, 'creator id'),
			'created_at' => \Yii::t($this->messageCategory, 'created time'),
			'updated_at' => \Yii::t($this->messageCategory, 'updated time'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeHints() {
		return [
			'id' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'region id'),
			]),
			'parent_id' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'parent'),
			]),
			'name' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'name'),
			]),
		];
	}

	/**
	 * Running a common Handler
	 *
	 * @since 0.0.1
	 * @return {boolean}
	 */
	public function commonHandler() {
		return $this->save();
	}

	/**
	 * Return children
	 *
	 * @since 0.0.1
	 * @return {array}
	 */
	public function getChildren() {
		return static::find()
			->where(['parent_id' => $this->id])
			->all();
	}

}
