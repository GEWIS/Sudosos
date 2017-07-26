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
    .controller('ManageCtrl', ['$scope', function ($scope) {
        
    }])
    .controller('ProductsCtrl',['$scope', '$http', '$uibModal', 'rootUrl',
        function ($scope, $http, $uibModal, rootUrl) {
        $scope.selectedIndex = -1;
        $scope.searchTerm = "";
        $scope.searchBy = "name";
        $scope.imageSrc = "http://gewis.nl/willem";
        $scope.categories = ["other", "ticket", "food"];

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

        $scope.editProduct = function () {
            $scope.selectedProduct = $scope.products[$scope.selectedIndex];
            $scope.editModal = $uibModal.open({
                templateUrl: 'templates/modal/editProductModalTemplate.html',
                size: 'sm',
                scope: $scope
            });
        };

        $scope.closeModal = function () {
            $scope.editModal.close();
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
    .controller('POSCtrl', ['$scope', '$http', '$uibModal', 'rootUrl',
        function ($scope, $http, $uibModal, rootUrl) {
            $scope.selectedIndex = -1;
            $scope.searchTerm = "";
            $scope.searchBy = "name";

            $scope.filterPOSs = function (value, index, array) {
                if (value[$scope.searchBy].toString().toLowerCase().indexOf($scope.searchTerm.toString().toLowerCase()) != -1) {
                    return true;
                }
            };

            $scope.startEditing = function (item) {
                item.editing = true;
            };

            $scope.stopEditing = function (item) {
                item.editing = false;
            };

            $scope.addPOS = function() {
                $scope.editModal = $uibModal.open({
                    templateUrl: 'templates/modal/editPOSModalTemplate.html',
                    size: 'sm',
                    scope: $scope
                });
            };

            $scope.editPOS = function () {
                $scope.selectedPOS = $scope.POSs[$scope.selectedIndex];
                $scope.editModal = $uibModal.open({
                    templateUrl: 'templates/modal/editPOSModalTemplate.html',
                    size: 'sm',
                    scope: $scope
                });
            };

            $scope.closeModal = function () {
                $scope.editModal.close({});
            };

            $scope.selectItem = function (index) {
                if ($scope.selectedIndex == index) {
                    $scope.selectedIndex = -1;
                } else {
                    $scope.selectedIndex = index;
                }
            };

            $scope.loadingData = $http.get(rootUrl + '/api/v1/pointsofsale').then(function (response) {
                $scope.POSs = response.data;
                for (var i = 0; i < $scope.products.length; i++) {
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