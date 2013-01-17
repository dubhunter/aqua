/**
 * Module dependencies.
 */

var express = require('express'),
	http = require('http');

var app = express();

app.configure(function () {
	app.enable('trust proxy');
	app.set('port', process.env.PORT || 3001);
	app.set('views', __dirname + '/views');
	app.set('controllers', __dirname + '/controllers');
	app.set('view engine', 'hbs');
	app.use(express.favicon());
	app.use(express.logger('dev'));
	app.use(express.bodyParser());
	app.use(express.methodOverride());
	app.use(express.cookieParser('your secret here'));
	app.use(express.session());
//	app.use(app.router);
//	app.use(express.static(path.join(__dirname, 'public')));
});

app.configure('development', function () {
	app.use(express.errorHandler());
});

app.get('/', require(app.set('controllers') + '/homeController.js').get);
app.get('/json', require(app.set('controllers') + '/testController.js').get);
app.get('/api/run', require(app.set('controllers') + '/runController.js').run);

http.createServer(app).listen(app.get('port'), function () {
	console.log("Express server listening on port " + app.get('port'));
});
