bView.DEFAULT = 'hyduinoView';

var hyduinoView = bView.extend({
	init: function (){
		this.initLinks();
		this.initForms();
	},
	initLinks: function (){
		var submit = function (e){
			e.preventDefault();
			var $a = $(this);
			if ($a.is('.disabled') || $a.is('.loading') || $a.attr('disabled')) {
				return false;
			}
			switch (true) {
				case $a.is('@post'):
					$a.addClass('loading');
					bourbon.run(e, $a.attr('href'), 'post');
					break;
				case $a.is('@put'):
					$a.addClass('loading');
					bourbon.run(e, $a.attr('href'), 'put');
					break;
				case $a.is('@delete'):
					$a.addClass('loading');
					bourbon.run(e, $a.attr('href'), 'destroy');
					break;
				default:
					History.pushState(null, $a.attr('title'), $a.attr('href'));
					break;
			}
			return false;
		};
		this.node.find('a[href^="/"]').click(submit);
	},
	initForms: function () {
		var submit = function (e){
			e.preventDefault();
			var $f = $(this);
			if ($f.is('.submitting') || $f.is('.loading')) {
				return false;
			}
			switch (true) {
				case $f.is('[method="get"]'):
					$f.addClass('loading');
					bourbon.run(e, $f.attr('action'), 'get', $f.serializeAssoc());
					break;
				case $f.is('[method="post"]'):
					$f.addClass('loading');
					bourbon.run(e, $f.attr('action'), 'post', $f.serializeAssoc());
					break;
				case $f.is('[method="put"]'):
					$f.addClass('loading');
					bourbon.run(e, $f.attr('action'), 'put', $f.serializeAssoc());
					break;
				case $f.is('[method="delete"]'):
					$f.addClass('loading');
					bourbon.run(e, $f.attr('action'), 'delete', $f.serializeAssoc());
					break;
			}
			return false;
		};
		this.node.find('form[action^="/"]').submit(submit);
	}
});

var viewPowerButtons = hyduinoView.extend({
	init: function () {
		this.parent();
		this.node.find('a').click(function (e) {
			$(this).find('i').attr('class', 'icon-refresh icon-spin');
		});
	}
});

var viewTimers = hyduinoView.extend({
	init: function () {
		this.parent();
		this.node.find('a@new').click(function (e) {
			e.preventDefault();
			bView.insertAfter('timersRow', $(this).parent('h1'), {
				id: 'new',
				start: '00:00:00',
				stop: '00:00:00',
				enabled: true,
				editing: true
			});
		});
	}
});

var viewTimersRow = hyduinoView.extend({
	init: function () {
		this.parent();
		this.node.find('@switch').bootstrapSwitch();
		this.node.find('a@edit').click(function (e) {
			e.preventDefault();
			bView.update($(this), {editing: true}, true);
		});
	}
});