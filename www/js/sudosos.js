angular.module('sudosos', ['sudosos.controllers', 'sudosos.filters', 'sudosos.services', 'sudosos.directives',
    'ui.router', 'ui.bootstrap', 'cgBusy', 'tableSort', 'ngDraggable'])
    .config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
        $stateProvider.state('sudosos', {
            url: '/sudosos',
            abstract: true,
            templateUrl: 'templates/sudosos.html',
            controller: 'SudososCtrl'
        })

            .state('sudosos.financial', {
                url: '/financial',
                views: {
                    'admin-panel-content': {
                        templateUrl: 'templates/financial.html',
                        controller: 'FinancialCtrl'
                    }
                }
            })

            .state('sudosos.products', {
                url: '/products',
                views: {
                    'admin-panel-content': {
                        templateUrl: 'templates/products.html',
                        controller: 'ProductsCtrl'
                    }
                }
            })

            .state('sudosos.storages', {
                url: '/storages',
                views: {
                    'admin-panel-content': {
                        templateUrl: 'templates/storages.html',
                        controller: 'StoragesCtrl'
                    }
                }
            })

            .state('sudosos.pointsOfSale', {
                url: '/pointsOfSale',
                views: {
                    'admin-panel-content': {
                        templateUrl: 'templates/pointsOfSale.html',
                        controller: 'POSCtrl'
                    }
                }
            })
            .state('sudosos.personalHome', {
                url: '/personalHome',
                views: {
                    'admin-panel-content': {
                        templateUrl: 'templates/personalHome.html',
                        controller: 'personalHomeCtrl'
                    }
                }
            })

            .state('sudosos.manage', {
                url: '/manage',
                views: {
                    'admin-panel-content': {
                        templateUrl: 'templates/manage.html',
                        controller: 'ManageCtrl'
                    }
                }
            })

            .state('sudosos.increaseBalance', {
                    url: '/increasebalance',
                    views: {
                        'admin-panel-content': {
                            templateUrl: 'templates/increaseBalance.html',
                            controller: 'IncreaseBalanceCtrl'
                        }
                    }
                }
            )
            .state('sudosos.manageRoles', {
                    url: '/manageRoles',
                    views: {
                        'admin-panel-content': {
                            templateUrl: 'templates/manageRoles.html',
                            controller: 'ManageRolesCtrl'
                        }
                    }
                }
            );
        $urlRouterProvider.otherwise('/sudosos/products');
    }])
    .value("rootUrl", "http://sudosos.dev/api/v1")
    .run(['$rootScope', '$state', function ($rootScope, $state) {

    }]);
