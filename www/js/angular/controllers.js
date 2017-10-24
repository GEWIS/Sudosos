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

        $scope.isDragging = false;
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

                $scope.POSPromises = [];
                for (var i = 0; i < $scope.pointsOfSale.length; i++) {
                    (function (index) {
                        var promise = $http.get(rootUrl + '/pointsofsale/' + $scope.pointsOfSale[index].id + "/stores").then(function (response) {
                            $scope.pointsOfSale[index].storages = response.data;
                        });
                        $scope.POSPromises.push(promise);
                    })(i);
                }
                return $q.all($scope.POSPromises);
            });
        });

        $scope.dropStorage = function ($data, $event) {
            console.log("Item dropped");
            // If the dropped object has the category attribute, it is not a storage.
            if($data.category === null){
                return;
            }

            if(this.pointOfSale.storages === null){

            }
            // Do not include duplicate storages
            for(var i = 0; i < this.pointOfSale.storages.length; i++){
                if(this.pointOfSale.storages[i].id === $data.id){
                    return;
                }
            }
            $http.post(rootUrl + '/pointsofsale/' + this.pointOfSale.id + '/stores/' + $data.id).then(function (response) {

            });
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
                    // Add the products to the item in the database
                    $http.put(rootUrl + "/storages/" + $scope.currentStorage.id + "/stock/" + currentItem.id,
                        {
                            value: currentItem.pivot.stock + $scope.transferAmount.amount
                        }
                    ).then(function (response) {
                        // Close the edit modal
                        $scope.editModal.close();
                        // Check if all items are moved: If so, remove the item from the source storage
                        if($scope.storageToStorage && ($scope.currentProduct.pivot.stock === 0)) {
                            for (var j = 0; j < $scope.currentProduct.storage.items.length; j++) {
                                if ($scope.currentProduct.storage.items[j].id === $scope.currentProduct.id) {
                                    // Delete the product from the storage on the server
                                    (function (index) {
                                        $http.delete(rootUrl + '/storages/' + $scope.currentProduct.storage.id + '/stores/' + $scope.currentProduct.id)
                                            .then(function (response) {
                                                // Remove the item in the original storage and set the ite
                                                $scope.currentProduct.storage.items.splice(index, 1);
                                            });
                                    })(j);
                                }
                            }
                        }
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
            // Check if all items from the storage are moved and remove the object from source storage
            if($scope.storageToStorage && ($scope.currentProduct.pivot.stock === 0)) {
                for (var j = 0; j < $scope.currentProduct.storage.items.length; j++) {
                    if ($scope.currentProduct.storage.items[j].id === $scope.currentProduct.id) {
                        // Delete the product from the storage on the server
                        (function (index) {
                            $http.delete(rootUrl + '/storages/' + $scope.currentProduct.storage.id + '/stores/' + $scope.currentProduct.id)
                                .then(function (response) {
                                    // Remove the item in the original storage and set the ite
                                    $scope.currentProduct.storage.items.splice(index, 1);
                                    $scope.itemToAdd.storage = $scope.currentStorage;
                                    $scope.currentStorage.items.push($scope.itemToAdd);
                                });
                        })(j);
                    }
                }
            }
        };

        $scope.removeItemFromStorage = function (event) {
            event.stopPropagation();
            for(var i = 0; i < this.storage.items.length; i++){
                if(this.storage.items[i].id === this.item.id){
                    this.storage.items.splice(i, 1);
                }
            }
            $http.delete(rootUrl + "/storages/" + this.storage.id + "/stores/" + this.item.id)
                .then(function (response) {

                });
        };
        // Remove a storage from a point of sale
        $scope.removeStorageFromPOS = function (event) {
            event.stopPropagation();
            for(var i = 0; i < this.pointOfSale.storages.length; i++){
                if(this.pointOfSale.storages[i].id === this.storage.id){
                    this.pointOfSale.items.splice(i, 1);
                }
            }
            $http.delete(rootUrl + "/pointsofsale/" + this.storage.id + "/stores/" + this.item.id)
                .then(function (response) {

                });
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
        };

        // The function that processes the keypresses, and catches the enter press
        $scope.stockKeyPress = function (item, storage, event) {
            if(event.keyCode === 13){
                $scope.stopEditing(item, storage);
            }
        }
    }])
    .controller('ProductsCtrl',['$scope', '$http', '$uibModal', 'rootUrl',
        function ($scope, $http, $uibModal, rootUrl) {
            $scope.searchTerm = "";
            $scope.searchBy = "name";
            $scope.imageSrc = "http://gewis.nl/willem";
            $scope.categories = ["other", "ticket", "food"];
            $scope.newItemAdded = false;

            $scope.filterProducts = function (value, index, array) {
                if(value[$scope.searchBy].toString().toLowerCase().indexOf($scope.searchTerm.toString().toLowerCase()) !== -1){
                    return true;
                }
            };

            $scope.startEditing = function (item) {
                item.editing = true;
            };

            $scope.stopEditing = function (item) {
                item.editing = false;
            };

            $scope.addProduct = function () {
                $scope.newItemAdded = true;
                $scope.selectedProduct = {
                    name: "",
                    price: 1.00,
                    tray_size: 24,
                    category: "other",
                    owner_id: $scope.currentCommittee.committee.id
                };
                $scope.imageSrc = "/img/beer_placeholder.svg";

                $scope.editModal = $uibModal.open({
                    templateUrl: 'templates/editProductModalTemplate.html',
                    size: 'sm',
                    scope: $scope
                });
            };

            $scope.editProduct = function () {
                for (var i = 0; i < $scope.products.length; i++){
                    if($scope.products[i].id === $scope.selectedId){
                        $scope.selectedProduct = $scope.products[i];
                    }
                }
                $scope.selectedProduct.price = $scope.selectedProduct.price / 100;
                $scope.editModal = $uibModal.open({
                    templateUrl: 'templates/editProductModalTemplate.html',
                    size: 'sm',
                    scope: $scope
                });
            };

            $scope.deleteProduct = function () {
                $http.delete(rootUrl + "/products/" + $scope.selectedProduct.id).then(function () {
                    for(var i = 0; i < $scope.products.length; i++){
                        if($scope.products[i].id === $scope.selectedProduct.id){
                            $scope.products.splice(i, 1);
                        }
                    }
                });
                $scope.editModal.close();
            };

            $scope.closeModal = function () {
                $scope.editModal.close();
                $scope.selectedProduct.price = parseInt($scope.selectedProduct.price * 100);

                if($scope.newItemAdded){
                    $http.post(rootUrl + "/products", $scope.selectedProduct)
                        .then(function () {
                            $scope.products.push($scope.selectedProduct);
                        });

                }else{
                    $http.put(rootUrl + "/products/" + $scope.selectedProduct.id, $scope.selectedProduct)
                        .then(function () {});
                }
                $scope.newItemAdded = false;

            };

            $scope.selectItem = function (id) {
                if($scope.selectedId === id){
                    $scope.selectedId = null;
                }else{
                    $scope.selectedId = id;
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