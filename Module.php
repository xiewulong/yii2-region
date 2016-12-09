<?php
/*!
 * yii2 - module - region
 * xiewulong <xiewulong@vip.qq.com>
 * https://github.com/xiewulong/yii2-region
 * https://raw.githubusercontent.com/xiewulong/yii2-region/master/LICENSE
 * create: 2016/12/9
 * update: 2016/12/9
 * since: 0.0.1
 */

namespace yii\region;

use Yii;

class Module extends \yii\components\Module {

	public $defaultRoute = 'list';

	public $messageCategory = 'region';

	public $permissions;

}
