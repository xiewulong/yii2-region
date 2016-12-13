<?php
/*!
 * yii - widget - region linkage
 * xiewulong <xiewulong@vip.qq.com>
 * https://github.com/xiewulong/yii2-region
 * https://raw.githubusercontent.com/xiewulong/yii2-region/master/LICENSE
 * create: 2016/12/12
 * update: 2016/12/13
 * since: 0.0.1
 */

namespace yii\region\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use yii\region\assets\LinkageAsset;
use yii\region\models\Region;

class Linkage extends Widget {

	public $hint = 'please select';

	public $name;

	public $value;

	public $action = '/region';

	public $options = [];

	public $selectOptions = [];

	public $template = '{select}';

	public $top = 0;

	protected $item;

	protected $id;

	public $id_pre = 'J-x-region-linkage';

	public $messageCategory = 'region';

	public function init() {
		parent::init();

		if($this->value) {
			$this->item = Region::findOne($this->value);
		}

		if(isset($this->options['id'])) {
			$this->id = $this->options['id'];
		} else {
			$this->options['id'] = $this->randomId;
		}

		if(!isset($this->selectOptions['size'])) {
			$this->selectOptions['size'] = 1;
		}

		LinkageAsset::register($this->view);
		$this->view->registerJs("$('#$this->randomId').regionLinkage('$this->action', '$this->hint')", 3);
	}

	public function run() {
		return Html::tag('div', $this->content, $this->options);
	}

	protected function getContent() {
		$content = [$this->hiddenInput];

		if($this->item) {
			foreach($this->item->getLinkageList($this->top) as $list) {
				$content[] = $this->renderListBox($list['items'], $list['active'] ? : null);
			}
		} else {
			$content[] = $this->renderListBox(Region::find()
				->where(['parent_id' => $this->top])
				->all());
		}

		return implode('', $content);
	}

	protected function renderListBox($items, $selection = null) {
		return strtr($this->template, [
			'{select}' => Html::ListBox(null, $selection, ArrayHelper::merge(['0' => $this->hint], ArrayHelper::map($items, 'id', 'name')), $this->selectOptions)
		]);
	}

	protected function getHiddenInput() {
		return Html::hiddenInput($this->name, $this->item && !$this->item->children ? $this->item->id : null);
	}

	protected function getRandomId() {
		if($this->id === null) {
			$this->id = $this->id_pre . time() . str_pad(mt_rand(0, 9999), 4, 0, STR_PAD_LEFT);
		}

		return $this->id;
	}

}
