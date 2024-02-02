/* http://keith-wood.name/maxlength.html
 Textarea Max Length for jQuery v1.0.1.
 Written by Keith Wood (kwood{at}iinet.com.au) May 2009.
 Dual licensed under the GPL (http://dev.jquery.com/browser/trunk/jquery/GPL-LICENSE.txt) and
 MIT (http://dev.jquery.com/browser/trunk/jquery/MIT-LICENSE.txt) licenses.
 Please attribute the author if you use it. */
(function($) {
	var g = 'maxlength';
	function MaxLength() {
		this._defaults = {
			max : 200,
			showFeedback : true,
			feedbackText : '{r} characters remaining ({m} maximum)'
		}
	}
	$.extend(MaxLength.prototype, {
		markerClassName : 'hasMaxLength',
		_feedbackClass : 'maxlength-feedback',
		setDefaults : function(a) {
			$.extend(this._defaults, a || {});
			return this
		},
		_attachMaxLength : function(c, d) {
			c = $(c);
			if (c.hasClass(this.markerClassName)) {
				return
			}
			c.addClass(this.markerClassName).bind('keypress.maxlength', function(a) {
				var b = String.fromCharCode(a.charCode == undefined ? a.keyCode : a.charCode);
				return (b == '\u0000' || $(this).val().length < e.settings.max)
			}).bind('keyup.maxlength', function() {
				$.maxlength._checkLength($(this))
			});
			var e = {
				settings : $.extend({}, this._defaults)
			};
			$.data(c[0], g, e);
			this._changeMaxLength(c, d)
		},
		_changeMaxLength : function(a, b, c) {
			a = $(a);
			if (!a.hasClass(this.markerClassName)) {
				return
			}
			b = b || {};
			if ( typeof b == 'string') {
				var d = b;
				b = {};
				b[d] = c
			}
			var e = $.data(a[0], g);
			$.extend(e.settings, b);
			var f = a.nextAll('.' + this._feedbackClass);
			if (e.settings.showFeedback && f.length == 0) {
				a.after('<span class="' + this._feedbackClass + '"></span>')
			}
			if (!e.settings.showFeedback && f.length > 0) {
				f.remove()
			}
			this._checkLength(a)
		},
		_checkLength : function(a) {
			var b = $.data(a[0], g);
			var c = a.val();
			if (c.length > b.settings.max) {
				c = c.substring(0, b.settings.max);
				a.val(c)
			}
			if (b.settings.showFeedback) {
				a.nextAll('.' + this._feedbackClass).text(b.settings.feedbackText.replace(/\{c\}/, c.length).replace(/\{m\}/, b.settings.max).replace(/\{r\}/, b.settings.max - c.length))
			}
		},
		_destroyMaxLength : function(a) {
			a = $(a);
			if (!a.hasClass(this.markerClassName)) {
				return
			}
			a.removeClass(this.markerClassName).unbind('.maxlength').nextAll('.' + this._feedbackClass).remove();
			$.removeData(a[0], g)
		},
		_settingsMaxLength : function(a) {
			var b = $.data(a, g);
			return b.settings
		}
	});
	var h = ['settings'];
	$.fn.maxlength = function(a) {
		var b = Array.prototype.slice.call(arguments, 1);
		if ($.inArray(a, h) > -1) {
			return $.maxlength['_' + a + 'MaxLength'].apply($.maxlength, [this[0]].concat(b))
		}
		return this.each(function() {
			if ( typeof a == 'string') {
				$.maxlength['_' + a + 'MaxLength'].apply($.maxlength, [this].concat(b))
			} else {
				$.maxlength._attachMaxLength(this, a || {})
			}
		})
	};
	$.maxlength = new MaxLength()
})(jQuery);
