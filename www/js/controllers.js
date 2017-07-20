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
        $scope.selectedIndex = -1;
        $scope.searchTerm = "";
        $scope.searchBy = "name";

        $scope.filterProducts = function (value, index, array) {
          if(value[$scope.searchBy].toString().toLowerCase().indexOf($scope.searchTerm.toString().toLowerCase()) != -1){
            return true;
          }
        };

        $scope.startEditing = function (item) {
            item.editing = true;
        };

        $scope.stopEditing = function (item) {
            item.editing = false;
        };

        $scope.selectItem = function (index) {
          if($scope.selectedIndex == index){
              $scope.selectedIndex = -1;
          }else{
              $scope.selectedIndex = index;
          }
        };

        $scope.loadingData = $http.get(rootUrl + '/api/v1/products').then(function (response) {
            $scope.products = response.data;
            for(var i = 0; i < $scope.products.length; i++){
                $scope.editing = false;
            }
        });

    }])
    .controller('FinancialCtrl', ['$scope', function ($scope) {

    }])
    .controller('IncreaseBalanceCtrl', ['$scope', function ($scope) {

    }])
    .run(function () {
    });