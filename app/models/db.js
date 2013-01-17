// Retrieve
var MongoClient = require('mongodb').MongoClient;

exports.connect = function (callback) {
	// Connect to the db
	MongoClient.connect('mongodb://localhost:27017/hyduino', function (err, db) {
		if (err) {
			console.dir(err);
		}
		callback(err, db);
	});
};
