/**
 * Created by s156386 on 15-7-2017.
 */
angular.module('sudosos.filters', [])
    .filter('ucFirst', function () {
        return function (input) {
            return input.charAt(0).toUpperCase() + input.slice(1);
        }
    });