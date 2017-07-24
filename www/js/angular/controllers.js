/**
 * Created by s156386 on 15-7-2017.
 */
angular.module('sudosos.controllers', [])
    .controller('SudososCtrl', ['$scope', '$state', function ($scope) {
        $scope.user = {
            name: "Ge Bruiker",
            currentBalance: 42.69,
            committees: [
                "BAC",
                "GEILER",
                "EJC17-34"
            ]
        };

        $scope.currentCommittee = {
            committee: $scope.user.committees[0]
        };

        $scope.date = new Date();

    }])
    .controller('ProductsCtrl',['$scope', '$http', 'rootUrl', function ($scope, $http, rootUrl) {
        $scope.searchTerm = "";
        $scope.loadingData = $http.get(rootUrl + '/api/v1/products').then(function (response) {
            $scope.products = response.data;
        });
    }])
    .controller('FinancialCtrl', ['$scope', function ($scope) {

    }])
    .controller('IncreaseBalanceCtrl', ['$scope', function ($scope) {

    }])
    .run(function () {
    });