var mongo = require('../models/db');

exports.run = function (req, res) {
	mongo.connect(function (err, db) {
		db.collection('times').find().toArray(function(err, items) {
			res.send(items);
		});
	});
};