/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/*!****************************************************!*\
  !*** ./vendor/xiewulong/yii2-region/js/linkage.js ***!
  \****************************************************/
/***/ function(module, exports) {

	'use strict';
	
	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();
	
	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
	
	/*!
	 * linkage
	 * xiewulong <xiewulong@vip.qq.com>
	 * create: 2016/12/13
	 * version: 0.0.1
	 */
	
	(function ($, document, undefined) {
		var RegionLinkage = function () {
			function RegionLinkage(target, url, hint) {
				_classCallCheck(this, RegionLinkage);
	
				this.$target = $(target);
				this.url = url;
				this.hint = hint;
				this.itemClass = 'J-x-region-linkage-item';
	
				this.$hidden = this.$target.find('input[type=hidden]');
				this.$target.children().not(this.$hidden).addClass(this.itemClass);
				this.$template = this.$target.find('.' + this.itemClass).eq(0).clone();
				this.$templateSelect = this.$template.get(0).tagName.toLowerCase() == 'select' ? this.$template : this.$template.find('select');
	
				!this.value && this.changed(this.$target.find('select:last'));
	
				this.events();
			}
	
			_createClass(RegionLinkage, [{
				key: 'clear',
				value: function clear() {
					this.value = null;
				}
			}, {
				key: 'render',
				value: function render(items) {
					var options = ['<option value="0">' + this.hint + '</option>'];
	
					items.map(function (item) {
						options.push('<option value="' + item.id + '">' + item.name + '</option>');
					});
	
					this.$templateSelect.html(options.join(''));
	
					return this.$template.clone();
				}
			}, {
				key: 'changed',
				value: function changed(select) {
					var _this2 = this;
	
					var $select = $(select),
					    $item = $select.hasClass(this.itemClass) ? $select : $select.parents('.' + this.itemClass),
					    value = +$select.val();
	
					$item.nextAll('.' + this.itemClass).remove();
	
					if (!value) {
						this.clear();
						return;
					}
	
					$.ajax({
						url: this.url,
						data: { id: value },
						method: 'get',
						dataType: 'json',
						success: function success(d) {
							if (d.error) {
								return;
							}
	
							if (d.data.length) {
								_this2.clear();
								$item.after(_this2.render(d.data));
							} else {
								_this2.value = value;
							}
						}
					});
				}
			}, {
				key: 'events',
				value: function events() {
					var _this = this;
					this.$target.on('change', 'select', function () {
						_this.changed(this);
					});
				}
			}, {
				key: 'value',
				get: function get() {
					return this.$hidden.val();
				},
				set: function set(value) {
					this.$hidden.val(value);
				}
			}]);
	
			return RegionLinkage;
		}();
	
		$.fn.regionLinkage = function (action, hint) {
			return this.each(function () {
				new RegionLinkage(this, action, hint);
			});
		};
	})(jQuery, document);

/***/ }
/******/ ]);
//# sourceMappingURL=linkage.js.map