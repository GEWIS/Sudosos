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
            amount: 0,
            trays: 0
        };

        $scope.searchTerm = "";
        $scope.$watch('currentCommittee.committee', function () {
            var currentCommitteeId = $scope.currentCommittee.committee.id;
            $scope.loadingProducts = $http.get(rootUrl + '/products/owner/' + currentCommitteeId).then(function (response) {
                $scope.products = response.data;
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
                            var items = $scope.storages[index].items;
                            for(var j = 0; j < items.length; j++){
                                items[j].editing = false;
                                items[j].storage = $scope.storages[index];
                            }
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
            if($data.category !== null){
                return;
            }
            if(this.pointOfSale.storages === null){
                
            }
            for(var i = 0; i < this.pointOfSale.storages.length; i++){
                if(this.pointOfSale.storages[i] == $data){
                    return;
                }
            }
            this.pointOfSale.storages.push($data);
        };

        $scope.dropProduct = function ($data, storage) {
            for(var i = 0; i < this.storage.items.length; i++){
                if(this.storage.items[i] == $data){
                    return;
                }
            }
            // Check if items are transferred from one storage to another or not
            $scope.storageToStorage = $data.hasOwnProperty('pivot');

            // Reset the counters for the amount of trays/items to transfer
            $scope.transferAmount = {
                amount: 0,
                trays: 0
            };

            $scope.currentProduct = $data;
            $scope.currentStorage = storage;
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


            // Check if the same object is already in the storage: If this is the case, increase the amount
            for(var i = 0; i < $scope.currentStorage.items.length; i++){
                var currentItem = $scope.currentStorage.items[i];
                currentItem.storage = $scope.currentStorage;
                if(currentItem.id === $scope.currentProduct.id){

                    // If a product is transferred from a storage to a storage, decrease the stock of the source storage
                    if($scope.storageToStorage){
                        $scope.currentProduct.pivot.stock -= $scope.transferAmount.amount;
                        $http.put(rootUrl + '/storages/' + $scope.currentProduct.storage.id + '/stock/' + $scope.currentProduct.id,
                            {
                                value: $scope.currentProduct.pivot.stock
                            }
                        ).then(function (response) {

                        });
                    }

                    $http.put(rootUrl + "/storages/" + $scope.currentStorage.id + "/stock/" + currentItem.id,
                        {
                            value: currentItem.pivot.stock + $scope.transferAmount.amount
                        }
                    ).then(function (response) {
                        // Close the edit modal
                        $scope.editModal.close();
                    });
                    currentItem.pivot.stock += $scope.transferAmount.amount;
                    return;
                }
            }

            // If the item is not yet present in the source storage, this code gets executed
            // Decrease the stock of the source item if storage to storage
            if($scope.storageToStorage){
                $scope.currentProduct.pivot.stock -= $scope.transferAmount.amount;
                $http.put(rootUrl + '/storages/' + $scope.currentProduct.storage.id + '/stock/' + $scope.currentProduct.id,
                    {
                        value: $scope.currentProduct.pivot.stock
                    }
                ).then(function (response) {

                });
            }
            // Add the item
            $http.post(rootUrl + "/storages/" + $scope.currentStorage.id + "/stores/" + $scope.currentProduct.id,
                {
                    value: $scope.transferAmount.amount
                }
            ).then(function (response) {
                // Copy the item so that the properties adjust do not change at the original item
                $scope.itemToAdd = angular.copy($scope.currentProduct);
                $scope.itemToAdd.pivot = {
                    stock: 0
                };

                $scope.itemToAdd.editing = false;
                $scope.itemToAdd.pivot.stock = $scope.transferAmount.amount;

                $scope.currentStorage.items.push($scope.itemToAdd);

                $scope.editModal.close();
            });
            // Check if all items of a product are transferred
            if($scope.storageToStorage && $scope.transferAmount.amount === $scope.currentProduct.stock){
                for(var i = 0; i < $scope.currentProduct.storage.items; i++){
                    if($scope.currentProduct.storage.items[i].id === $scope.currentProduct.id){
                        // Delete the product from the storage on the server
                        $http.delete(rootUrl + '/storages/' + $scope.currentProduct.storage.id + '/stores/' + $scope.currentProduct.id)
                            .then(function (response) {
                                // Remove the item in the original storage and set the ite
                                $scope.currentProduct.storage.items.splice(i, 1);
                                $scope.itemToAdd.storage = $scope.currentStorage;
                                $scope.currentStorage.items.push($scope.itemToAdd);
                            });
                    }
                }
            }
        };

        // This function is needed to automatically add multiply the amount of trays to get the amount of items
        $scope.addTrays = function () {
            $scope.transferAmount.amount = $scope.transferAmount.trays * $scope.currentProduct.tray_size;
        };

        // The function that is called when the input field is blurred
        $scope.stopEditing = function (item, storage) {
            item.editing = false;
            // Update the value in the database
            $http.put(rootUrl + "/storages/" + storage.id + "/stock/" + item.id,
                {
                    value: item.pivot.stock
                }
            ).then(function (response) {
            });
        }
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