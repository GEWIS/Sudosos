/**
 * Created by Rick Wouters on 15-7-2017.
 */
angular.module('sudosos.controllers', [])
    .controller('SudososCtrl', ['$scope', '$state', function ($scope) {
        $scope.user = {
            name: "Ge Bruiker",
            currentBalance: 42.69,
            committees: [
                {
                    id: 18,
                    name: "BAC"
                },
                {
                    id: 9,
                    name: "GEILER"
                }
            ]
        };

        $scope.currentCommittee = {
            committee: $scope.user.committees[0]
        };

        $scope.date = new Date();

    }])
    .controller('ManageCtrl', ['$scope', '$http', '$uibModal', 'rootUrl', function ($scope, $http, $uibModal, rootUrl) {
        $scope.transferAmount = {
            amount: 0
        };

        $scope.searchTerm = "";
        $scope.$watch('currentCommittee.committee', function () {
            var currentCommitteeId = $scope.currentCommittee.committee.id;
            $scope.loadingProducts = $http.get(rootUrl + '/products/owner/' + currentCommitteeId).then(function (response) {
                $scope.products = response.data;
                for (var i = 0; i < $scope.products.length; i++) {
                    $scope.products[i].amount = parseInt(Math.random() * 100);
                }
            });

            // Load the storages
            $scope.loadingStorages = $http.get(rootUrl + '/storages/owner/' + currentCommitteeId).then(function (response) {
                $scope.storages = response.data;

                $scope.storagePromises = [];
                // This loop takes every storage, and creates a promise that will get the products in that storage.
                for(var i = 0; i < $scope.storages.length; i++){
                    // This anonymous function is needed because of closure issues
                    (function (index) {
                        var promise = $http.get(rootUrl + '/storages/' + $scope.storages[index].id + "/stores").then(function (response) {
                            $scope.storages[index].items = response.data;
                        });
                        $scope.storagePromises.push(promise);
                    })(i);
                }

                // Run all promises
                return $q.all($scope.storagePromises);
            });

            $scope.loadingPOS = $http.get(rootUrl + '/pointsofsale/owner/' + currentCommitteeId).then(function (response) {
                $scope.pointsOfSale = response.data;
                for (var i = 0; i < $scope.pointsOfSale.length; i++) {
                    (function (index) {
                        var promise = $http.get(rootUrl + '/')
                    })(i);
                }
            });
        });

        $scope.dropStorage = function ($data, $event) {
            // If the dropped object has the category attribute, it is not a storage.
            if($data.category != null){
                return;
            }
            for(var i = 0; i < this.pointOfSale.storages.length; i++){
                if(this.pointOfSale.storages[i] == $data){
                    return;
                }
            }
            this.pointOfSale.storages.push($data);
        };

        $scope.dropProduct = function ($data, $event) {
            for(var i = 0; i < this.storage.items.length; i++){
                if(this.storage.items[i] == $data){
                    return;
                }
            }
            $scope.currentProduct = $data;
            $scope.currentStorage = this.storage;
            $scope.editModal = $uibModal.open({
                templateUrl: 'templates/transferAmountModalTemplate.html',
                size: 'sm',
                scope: $scope
            });
        };


        $scope.transferItems = function () {
            // If the amount is < 1, we shouldn't add it, as it does not make sense.
            if($scope.transferAmount.amount < 1){
                $scope.editModal.close();
                return;
            }

            // Check if the same object is already in the list: If this is the case, increase the amount
            for(var i = 0; i < $scope.currentStorage.items.length; i++){
                var currentItem = $scope.currentStorage.items[i];
                if(currentItem.id == $scope.currentProduct.id){
                    currentItem.amount += $scope.transferAmount.amount;
                    $http.put(rootUrl + "/storages/" + $scope.currentStorage.id + "/stock/" + currentItem.id,
                        {
                            value: $scope.transferAmount.amount
                        }
                    ).then(function (response) {
                        console.log(response);
                        $scope.editModal.close();
                    });
                    return;
                }
            }

            $http.post(rootUrl + "/storages/" + $scope.currentStorage.id + "/stores/" + $scope.currentProduct.id,
                {
                    value: $scope.transferAmount.amount
                }
            ).then(function (response) {
                console.log(response);
                $scope.currentProduct.amount = $scope.currentProduct.amount - $scope.transferAmount.amount;
                $scope.itemToAdd = angular.copy($scope.currentProduct);
                $scope.itemToAdd.amount = $scope.transferAmount.amount;
                $scope.currentStorage.items.push($scope.itemToAdd);
                $scope.editModal.close();
            });
        };
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
                    templateUrl: 'templates/editProductModalTemplate.html',
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
            $scope.$watch('currentCommittee.committee', function () {
                $scope.loadingData = $http.get(rootUrl + '/products/owner/' + $scope.currentCommittee.committee.id)
                    .then(function (response) {
                        $scope.products = response.data;
                        for(var i = 0; i < $scope.products.length; i++){
                            $scope.editing = false;
                        }
                    });
            });

        }])
    .controller('FinancialCtrl', ['$scope', function ($scope) {

    }])
    .controller('IncreaseBalanceCtrl', ['$scope', function ($scope) {

    }])
    .controller('ManageRolesCtrl', ['$scope', function ($scope) {

    }])
    .run(function () {
    });