<?php
/*!
 * yii - asset - region linkage
 * xiewulong <xiewulong@vip.qq.com>
 * https://github.com/xiewulong/yii2-region
 * https://raw.githubusercontent.com/xiewulong/yii2-region/master/LICENSE
 * create: 2016/12/12
 * update: 2016/12/12
 * since: 0.0.1
 */

namespace yii\region\assets;

use Yii;
use yii\components\AssetBundle;

class LinkageAsset extends AssetBundle {

	public $sourcePath = '@yii/region/dist';

	public function init() {
		parent::init();

		$this->js[] = 'js/linkage' . $this->minimal . '.js';
	}

}
