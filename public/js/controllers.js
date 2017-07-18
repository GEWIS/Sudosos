/**
 * Created by s156386 on 15-7-2017.
 */
angular.module('sudosos.controllers', [])
    .controller('SudososCtrl', ['$scope', '$state', function ($scope, $state) {
        $scope.state = $state;
        $scope.stateNames = {
            "sudosos.products": "Products",
            "sudosos.financial": "Financial",
            "sudosos.increaseBalance" : "Increase balance"
        };
    }])
    .controller('ProductsCtrl',['$scope', 'rootUrl', function ($scope, rootUrl) {
        $scope.products = [
            {
                "id":"18341b00-6ada-11e7-ac1c-4ffbc8896728",
                "owner_id":"166204b0-6ada-11e7-bd33-61619c67bf83",
                "name":"Hilario Marvin MD",
                "price":1749,
                "image":"\/tmp\/d50e631eb9c6770a962627d54d8e0349.jpg",
                "tray_size":15,
                "category":"ticket",
                "created_at":"2017-07-17 10:24:19",
                "updated_at":"2017-07-17 10:24:19",
                "deleted_at":null
            },
            {
                "id":"183486c0-6ada-11e7-bb81-bd8c5294d079",
                "owner_id":"16866e90-6ada-11e7-a421-49b330b5f3ba",
                "name":"Cheyenne Glover",
                "price":543,
                "image":"\/tmp\/8dab7d4d8e52ce8f9c1c562fe34cff62.jpg",
                "tray_size":18,
                "category":"drink",
                "created_at":"2017-07-17 10:24:19",
                "updated_at":"2017-07-17 10:24:19",
                "deleted_at":null
            },
            {
                "id":"1834c360-6ada-11e7-9a11-f13d279c2323",
                "owner_id":"16a97b50-6ada-11e7-ac2d-d5144c1f6e8d",
                "name":"Geraldine Klocko",
                "price":1595,
                "image":"\/tmp\/5db7061bd67ca45a32f6d9e280471cb8.jpg",
                "tray_size":11,
                "category":"food",
                "created_at":"2017-07-17 10:24:19",
                "updated_at":"2017-07-17 10:24:19",
                "deleted_at":null
            },
            {
                "id":"18351480-6ada-11e7-b2d9-5b355f8b4cd1",
                "owner_id":"16c94130-6ada-11e7-8cfa-3777798da8ba",
                "name":"Ms. Elyssa Harber",
                "price":1145,
                "image":"\/tmp\/d8dcef9d7ad513162c8ce0b11741a253.jpg",
                "tray_size":12,
                "category":"ticket",
                "created_at":"2017-07-17 10:24:19",
                "updated_at":"2017-07-17 10:24:19",
                "deleted_at":null
            },
            {
                "id":"18354730-6ada-11e7-a87d-0dc99e12f7f3",
                "owner_id":"16ebaf60-6ada-11e7-b79f-ad98b3518909",
                "name":"Kay Bernhard",
                "price":1599,
                "image":"\/tmp\/daf789147a8dd82d972005edc7412135.jpg",
                "tray_size":7,
                "category":"food",
                "created_at":"2017-07-17 10:24:19",
                "updated_at":"2017-07-17 10:24:19",
                "deleted_at":null
            },
            {
                "id":"183596a0-6ada-11e7-84ed-f984c765683c",
                "owner_id":"17085c50-6ada-11e7-a009-7f5d8f4df171",
                "name":"Dr. Kristian Wolf",
                "price":950,
                "image":"\/tmp\/27b764b5348b5afdea66bddfb1cc8443.jpg",
                "tray_size":13,
                "category":"ticket",
                "created_at":"2017-07-17 10:24:19",
                "updated_at":"2017-07-17 10:24:19",
                "deleted_at":null
            },
            {
                "id":"1835d390-6ada-11e7-a149-4f279a3602a9",
                "owner_id":"1727ad60-6ada-11e7-92c8-49a92fbf225b",
                "name":"Elmo Ernser",
                "price":1568,
                "image":"\/tmp\/2165d70702e608e03c47cd479e47c798.jpg",
                "tray_size":17,
                "category":"food",
                "created_at":"2017-07-17 10:24:19",
                "updated_at":"2017-07-17 10:24:19",
                "deleted_at":null
            },
            {
                "id":"18362140-6ada-11e7-bbd4-61afbbd5ccdf",
                "owner_id":"17467ca0-6ada-11e7-9325-3de83c5b1bf2",
                "name":"Litzy Littel",
                "price":883,
                "image":"\/tmp\/02b732a94fcf2dac924530e4b2dc361b.jpg",
                "tray_size":20,
                "category":"other",
                "created_at":"2017-07-17 10:24:19",
                "updated_at":"2017-07-17 10:24:19",
                "deleted_at":null
            },
            {
                "id":"18366000-6ada-11e7-ae7c-d7d97137c343",
                "owner_id":"17695760-6ada-11e7-a769-6d6b60a4605f",
                "name":"Keyon Mueller PhD",
                "price":1606,
                "image":"\/tmp\/6d597d7fd280764d1d80936a315b9429.jpg",
                "tray_size":13,
                "category":"food",
                "created_at":"2017-07-17 10:24:19",
                "updated_at":"2017-07-17 10:24:19",
                "deleted_at":null
            }
        ];
    }])
    .controller('FinancialCtrl', ['$scope', function ($scope) {

    }])
    .run(function () {
        console.log("Controllers loaded");
    });