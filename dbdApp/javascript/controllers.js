var hyduinoController = bController.extend({
	_init: function () {
		bRunner.once('throbber', function () {
			bView.replaceInto('throbber', '#hyduino');
		});
		bRunner.once('throbber', function () {
			bView.replaceInto('throbber', '#hyduino');
		});
		if (bourbon.getEvent().type == 'statechange') {
			bAjax.abortAll();
			if ($this.controller && $this.method) {
				bRunner.clearTimed($this.controller, $this.method);
			}
			$this.controller = this._getController();
			$this.method = this._getMethod();
			$this.params = this._getParams();
			$this.url = this._getUrl();
			$this.url_params = this._getUrl(true);
		}
		hyduino.startEventListener();
		return bRunner.once('powerStatus', function (){
			hyPower.status().done(function (data){
				hyduino.power(data.status);
			});
		});
	},
	_setTitle: function (title) {
		if (title) {
			title = ' - ' + title;
		}
		this.parent('Hyduino' + title);
	},
	autoExec: function () {
//		hyduino.power($this.power ? 'on' : 'off');
//		bRunner.timed($this.controller, 'timePast', headsup.intervalTime, function (){
//			$('.time').each(function (){
//				bView.update($(this));
//			});
//		});
	}
});

var pageController = hyduinoController.extend({
	_init: function () {
		this.parent();
		this._ensureNav();
		this._ensurePage();
	},
	_ensureNav: function () {
		var data = {}, selected = $this.controller.replace('Controller', '');
		data[selected] = true;
		if ($('#header').length == 0) {
			bView.appendTo('header', 'body', data);
		} else {
			bView.update('header', data);
		}
	},
	_ensurePage: function () {
		if ($('#page').length == 0) {
			bView.appendTo('page', 'body');
		}
	}
});

var powerController = hyduinoController.extend({
	post: function () {
		hyPower.on();
	},
	destroy: function () {
		hyPower.off();
	}
});

var homeController = pageController.extend({
	get: function () {
		this._setTitle();
		bView.replaceInto('dashboard', '#page');
	}
});

var timersController = pageController.extend({
	get: function () {
		this._setTitle('Timers');
		hyTimers.all().done(function (data) {
			bView.replaceInto('timers', '#page', data);
		});
	}
});

var alertsController = pageController.extend({
	get: function () {
		this._setTitle('Alerts');
		hyTriggers.all().done(function (data) {
			bView.replaceInto('alerts', '#page', data);
		});
	}
});