var express = require('express');
var bodyParser = require('body-parser');

//Mongoose added
var mongoose = require('mongoose');
var Favorites = require('../models/favorites');

var Verify = require('./verify');

var favoriteRouter = express.Router();
favoriteRouter.use(bodyParser.json());
favoriteRouter.route('/')
    .get(Verify.verifyOrdinaryUser, function (req, res, next) {
    Favorites.find({"postedBy": req.decoded._id})
        .populate('postedBy')
        .populate('dishes')
        .exec(function (err, fav) {
        if (err) throw err;
        res.json(fav);
    });
})

    .post(Verify.verifyOrdinaryUser, function (req, res, next) {
    /*Favorites.findOne({"postedBy":req.decoded._id }, function (err, favs) { 
        if(!favs){
            Favorites.create(req.body, function (err, favs) {
                if (err) throw err;
                favs.postedBy = req.decoded._id; 
                console.log('your favorite has been created!');
                favs.dishes.push(req.body._id);
                favs.save(function (err, favs) {
                    if (err) throw err;
                    console.log('Dish added');
                    res.json(favs);
                }); 
            }); 

        }else{
            var test = favs.dishes.indexOf(req.body._id);
            if(test > -1){
                var err = new Error('This recipe is already in your favorite list');
                err.status = 401;
                return next(err);
            }else{
                favs.dishes.push(req.body._id);
                favs.save(function (err, favs) {
                    if (err) throw err;
                    console.log('Dish added');
                    res.json(favs);
                });
            }
        } 
    });
})*/
    var userId = req.decoded._id;

    Favorites
        .findOneAndUpdate({
        postedBy: userId
    }, {
        $addToSet: {
            dishes: req.body
        }
    }, {
        upsert: true,
        new: true
    }, function (err, favorite) {
        if (err) throw err;

        res.json(favorite);
    });
})
    .delete(Verify.verifyOrdinaryUser, function (req, res, next) {
    /*Favorites.remove({postedBy: req.decoded._id}, function (err, resp) {
        if (err) throw err;
        res.json(resp);
    });
});*/
    var userId = req.decoded._id;

    Favorites
        .findOneAndRemove({
        postedBy: userId
    }, function (err, resp) {
        if (err) throw err;
        res.json(resp);
    });
});
favoriteRouter.route('/:favId')
    .delete(Verify.verifyOrdinaryUser, function (req, res, next) {
    Favorites.findOne({postedBy: req.decoded._id}, function (err, favs) {
        if (err){ console.log(req.decoded._id + ' '+ favs); throw err;}
        if (favs) {
            var index = favs.dishes.indexOf(req.params.favId);
            console.log(index);
            if (index > -1) {
                favs.dishes.splice(index, 1);
            }
            favs.save(function (err, favorite) {
                if (err) throw err;
                res.json(favorite);
            });
        } else {
            var err = new Error('There\' no Favorites');
            err.status = 401;
            return next(err);
        }
    });
});
    /*var userId = req.decoded._id;

        Favorites.findOneAndUpdate({
            postedBy: userId
        }, {
            $pull: {
                dishes: req.params.favId
            }
        }, {
            new: true
        }, function (err, favorite) {
            if (err) throw err;

            res.json(favorite);
        });
    });*/


module.exports = favoriteRouter;