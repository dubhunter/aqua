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
	_ensureNav: function () {
		if ($('#header').length == 0) {
			bView.appendTo('header', 'body');
		}
	},
	_ensurePage: function () {
		if ($('#page').length == 0) {
			bView.appendTo('page', 'body');
		}
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

var homeController = hyduinoController.extend({
	_init: function () {
		this.parent();
		this._ensureNav();
		this._ensurePage();
	},
	get: function () {
		this._setTitle('Hyduino');
		bView.appendTo('dashboard', '#page');
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

