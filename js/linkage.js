/*!
 * linkage
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/12/13
 * version: 0.0.1
 */

(function($, document, undefined) {

	class RegionLinkage {

		constructor(target, url, hint) {
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

		get value() {
			return this.$hidden.val();
		}

		set value(value) {
			this.$hidden.val(value);
		}

		clear() {
			this.value = null;
		}

		render(items) {
			let options	= [`<option value="0">${this.hint}</option>`];

			items.map(function(item) {
				options.push(`<option value="${item.id}">${item.name}</option>`);
			});

			this.$templateSelect.html(options.join(''));

			return this.$template.clone();
		}

		changed(select) {
			let $select	= $(select),
				$item	= $select.hasClass(this.itemClass) ? $select : $select.parents('.' + this.itemClass),
				value	= + $select.val();

			$item.nextAll('.' + this.itemClass).remove();

			if(!value) {
				this.clear();
				return;
			}

			$.ajax({
				url: this.url,
				data: {id: value},
				method: 'get',
				dataType: 'json',
				success: (d) => {
					if(d.error) {
						return;
					}

					if(d.data.length) {
						this.clear();
						$item.after(this.render(d.data));
					} else {
						this.value = value;
					}
				},
			});
		}

		events() {
			let _this = this;
			this.$target.on('change', 'select', function() {
				_this.changed(this);
			});
		}

	}

	$.fn.regionLinkage = function(action, hint) {
		return this.each(function() {
			new RegionLinkage(this, action, hint);
		});
	};

})(jQuery, document);
