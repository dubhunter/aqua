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
		bRunner.once('eventSocket', function () {
			hyduino.startEventSocket();
		});
		return bRunner.once('powerStatus', function (){
			hyPower.status().done(function (data){
				hyduino.power(data.status);
			});
		});
	},
	_setTitle: function (title) {
		if (title) {
			title = ' - ' + title;
		} else {
			title = '';
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
	}
});

var timersInstanceController = pageController.extend({
	post: function () {
		hyTimers.update(this._getParam('id'), this._getParams()).done(function (data){
			bView.update($('form[action="/timers/' + data.id + '"]'), data);
		});
	},
	destroy: function () {
		hyTimers.remove(this._getParam('id'), this._getParams()).done(function (data){
			$('form[action="/timers/' + data.id + '"]').parents('.timersRow').remove();
		});
	}
});

var alertsController = pageController.extend({
	get: function () {
		this._setTitle('Alerts');
		return hyTriggers.all().done(function (data) {
			bView.replaceInto('alerts', '#page', data);
		});
	}
});

var chartsController = pageController.extend({
	_charts: {},
	_chart: function ($chart, title, data){
		var series = [{
			'name': title,
			'data': []
		}];
		var date;
		var value = 0;
		var sum = 0;
		var sumCount = 0;
		var interval = 1800 * 1000; // 30 minutes
		var intervalCount = 0;
		var start = new Date(data.events[0].date);
		for (var i = 0; i < data.events.length; i++) {
			date = new Date(data.events[i].date);
			value = parseInt(data.events[i].data);
			if (isNaN(value)) {
				continue;
			}
			if (date.getTime() > (start.getTime() + (interval * intervalCount) + interval) || i == data.events.length - 1) {
				series[0].data.push([
					(start.getTime() + (interval * intervalCount)),
					Math.round(sum / sumCount)
				]);
				sum = 0;
				sumCount = 0;
				intervalCount++;
			}
			sum += value;
			sumCount++;
		}
		$.log(series);
		this._charts[$chart.attr('id')].chart = new Highcharts.Chart({
			credits: {enabled: false},
			colors: hyduino.highchartsColors,
			chart: {
				width: parseFloat($chart.width()),
				height: parseFloat($chart.height()),
				renderTo: $chart.attr('id'),
				defaultSeriesType: 'area'
			},
			xAxis: {
				type: 'datetime',
				dateTimeLabelFormats: { // don't display the dummy year
					month: '%e. %b',
					year: '%b'
				}
			},
			plotOptions: {
				area: {
//					fillColor: {
//						linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
//						stops: [
//							[0, hyduino.highchartsColors[0]],
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
					threshold: null
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
		});
//		this._charts[$chart.attr('id')].loader.remove();
	},
	get: function () {
		var self = this;
		this._setTitle('Charts');
		bView.replaceInto('charts', '#page');
		var from = new Date();
		from.setDate(from.getDate() - 7);
		hyEvents.range('light', Math.round(from.getTime() / 1000)).done(function (data) {
			var $chart = $('#graphLight');
			self._charts[$chart.attr('id')] = {};
			self._chart($chart, 'Light Sensor', data);
		});
		hyEvents.range('liquid', Math.round(from.getTime() / 1000)).done(function (data) {
			var $chart = $('#graphLiquid');
			self._charts[$chart.attr('id')] = {};
			self._chart($chart, 'Liquid Sensor', data);
		});
	}
});