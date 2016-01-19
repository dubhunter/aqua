var aquaController = bController.extend({
	_init: function () {
		bRunner.once('throbber', function () {
			bView.replaceInto('throbber', '#aqua');
		});
		bRunner.once('throbber', function () {
			bView.replaceInto('throbber', '#aqua');
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
		bRunner.once('eventSocket', function () {
			aqua.startEventSocket();
		});
		return bRunner.once('powerStatus', function (){
			hyPower.status().done(function (data){
				aqua.power(data.status);
			});
		});
	},
	_setTitle: function (title) {
		if (title) {
			title = ' - ' + title;
		} else {
			title = '';
		}
		this.parent('AquaPi' + title);
	},
	autoExec: function () {
//		aqua.power($this.power ? 'on' : 'off');
		bRunner.timed($this.controller, 'time', aqua.intervalTime, function (){
			$('.time').each(function (){
				bView.update($(this));
			});
		});
		if (bourbon.getEvent().type == 'statechange') {
			window.scrollTo(0, 1);
		}
	}
});

var pageController = aquaController.extend({
	_init: function () {
		var that = this, $D = $.Deferred();
		$.whenQueued(
			[this, this.parent],
			[this, this._ensureNav]
		).done(function (){
			that._ensurePage();
			$D.resolve();
		});
		return $D.promise();
	},
	_ensureNav: function () {
		var head = {}, $D = $.Deferred(), selected = $this.controller.replace('Controller', '');
		head[selected] = true;
		if ($('#header').length == 0) {
			hyEvents.all(null, 0, 1).done(function (data){
				head['online'] = (new Date()).getTime() - $.global.parseDate(data.events[0].date).getTime() <= 60000;
				bView.appendTo('header', 'body', head);
				$D.resolve();
			});
		} else {
			var view = bView.templateView('header');
			head['online'] = view.data['online'];
			head['power'] = view.data['power'];
			bView.update('header', head);
			$D.resolve();
		}
		return $D.promise();
	},
	_ensurePage: function () {
		if ($('#page').length == 0) {
			bView.appendTo('page', 'body');
		}
	}
});

var powerController = aquaController.extend({
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
		var dash = {};
		var timerFetch = hyTimers.all(0, 1).done(function (data) {
			var timer = false;
			if (data.timers.length > 0) {
				timer = data.timers[0];
			}
			dash['timer'] = timer;
		});
		var levelFetch = hyReservoir.get().done(function (data) {
			dash['level'] = Math.round(data['level']);
			dash['runrate'] = data['runrate'];
		});
		var lightFetch = hyEvents.all('light', 0, 1).done(function (data) {
			var light = 0;
			if (data.events.length > 0) {
				light = data.events[0]['data'];
			}
			dash['light'] = light / 1000;
		});
		var tempFetch = hyEvents.all('temp', 0, 1).done(function (data) {
			var temp = 0;
			if (data.events.length > 0) {
				temp = data.events[0]['data'];
			}
			dash['temp'] = Math.round(temp);
		});
		return $.when(timerFetch, levelFetch, lightFetch, tempFetch).done(function (){
			bView.replaceInto('dashboard', '#page', dash);
		})
	}
});

var timersController = pageController.extend({
	get: function () {
		this._setTitle('Timers');
		return hyTimers.all().done(function (data) {
			bView.replaceInto('timers', '#page', data);
		});
	}
});

var timersCreateController = pageController.extend({
	post: function () {
		hyTimers.create(this._getParams()).done(function (data){
			bView.update($('form[action="/timers/new"]'), data);
		});
	},
	destroy: function () {
		$('form[action="/timers/new"]').parents('.timersRow').remove();
	}
});

var timersInstanceController = pageController.extend({
	post: function () {
		hyTimers.update(this._getParam('id'), this._getParams()).done(function (data){
			bView.update($('form[action="/timers/' + data.id + '"]'), data);
		});
	},
	destroy: function () {
		var id = this._getParam('id');
		hyTimers.remove(id).done(function (data){
			$('form[action="/timers/' + id + '"]').parents('.timersRow').remove();
		});
	}
});

var alertsController = pageController.extend({
	get: function () {
		this._setTitle('Alerts');
		return hyTriggers.all().done(function (data) {
			$.each(data['triggers'], function (i, item) {
				data['triggers'][i]['max_alert_interval'] = item['max_alert_interval'] / 60 / 60;
			});
			bView.replaceInto('alerts', '#page', data);
		});
	}
});

var alertsCreateController = pageController.extend({
	post: function () {
		var params = this._getParams();
		params['max_alert_interval'] = params['max_alert_interval'] * 60 * 60;
		hyTriggers.create(params).done(function (data){
			data['max_alert_interval'] = data['max_alert_interval'] / 60 / 60;
			bView.update($('form[action="/alerts/new"]'), data);
		});
	},
	destroy: function () {
		$('form[action="/alerts/new"]').parents('.alertsRow').remove();
	}
});

var alertsInstanceController = pageController.extend({
	post: function () {
		var params = this._getParams();
		params['max_alert_interval'] = params['max_alert_interval'] * 60 * 60;
		hyTriggers.update(this._getParam('id'), params).done(function (data){
			data['max_alert_interval'] = data['max_alert_interval'] / 60 / 60;
			bView.update($('form[action="/alerts/' + data.id + '"]'), data);
		});
	},
	destroy: function () {
		var id = this._getParam('id');
		hyTriggers.remove(id).done(function (data){
			$('form[action="/alerts/' + id + '"]').parents('.alertsRow').remove();
		});
	}
});

var chartsController = pageController.extend({
	_charts: {},
	_chart: function ($chart, title, data, max){
		var series = [{
			'name': title,
			'data': []
		}];
		var date;
		var value = 0;
		for (var i = 0; i < data.events.length; i++) {
			date = new Date(data.events[i].date);
			value = parseInt(data.events[i].data);
			series[0].data.push([
				date.getTime(),
				value
			]);
			if (max && value > max) {
				max = value;
			}
		}
		$.log(series);
		var options = {
			credits: {enabled: false},
			colors: aqua.highchartsColors,
			chart: {
				width: parseFloat($chart.width()),
				height: parseFloat($chart.height()),
				renderTo: $chart.attr('id'),
				defaultSeriesType: 'area'
			},
			xAxis: {
				type: 'datetime',
				dateTimeLabelFormats: { // don't display the dummy year
					hour: '%l:%M%P',
					month: '%e. %b',
					year: '%b'
				}
			},
			yAxis: {
				min: 0
			},
			plotOptions: {
				area: {
//					fillColor: {
//						linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
//						stops: [
//							[0, aqua.highchartsColors[0]],
//							[1, 'rgba(2,0,0,0)']
//						]
//					},
//					lineWidth: 2,
					marker: {
						enabled: false,
						states: {
							hover: {
								enabled: true,
								radius: 5
							}
						}
					},
					shadow: false,
					states: {
						hover: {
							lineWidth: 1
						}
					},
					threshold: null,
					tooltip: {
						dateTimeLabelFormats: {
							hour: '%A, %b %e, %l:%M%P'
						}
					}
				}
			},
//			title: {
//				text: title,
//				x: -20 //center
//			},
//			xAxis: {
////				categories: data.categories,
////				tickInterval: 7,
//				alternateGridColor: '#eef7f7'
//			},
//			yAxis: {
//				title: {
//					text: 'Volume'
//				},
//				plotLines: [{
//					value: 0,
//					width: 1,
//					color: '#808080'
//				}]
//			},
//			tooltip: {
//				formatter: function() {
//					return '<b>'+ this.series.name +'</b><br/>'+
//						this.x +': '+ this.y;
//				}
//			},
			series: series
		};
		if (max) {
			options['yAxis']['max'] = max;
		}
		this._charts[$chart.attr('id')].chart = new Highcharts.Chart(options);
//		this._charts[$chart.attr('id')].loader.remove();
	},
	get: function () {
		var self = this;
		this._setTitle('Charts');
		bView.replaceInto('charts', '#page');
		var from = new Date();
		from.setDate(from.getDate() - 1);
		var downsample = 1800; // 30 minutes
		hyEvents.summary('light', Math.round(from.getTime() / 1000), null, downsample).done(function (data) {
			var $chart = $('#graphLight');
			self._charts[$chart.attr('id')] = {};
			self._chart($chart, 'Light Sensor', data);
		});
		hyEvents.summary('temp', Math.round(from.getTime() / 1000), null, downsample).done(function (data) {
			var $chart = $('#graphTemp');
			self._charts[$chart.attr('id')] = {};
			self._chart($chart, 'Temp Sensor', data);
		});
		hyEvents.summary('liquid', Math.round(from.getTime() / 1000), null, downsample).done(function (data) {
			var $chart = $('#graphLiquid');
			self._charts[$chart.attr('id')] = {};
			self._chart($chart, 'Liquid Sensor', data, 100);
		});
	}
});
