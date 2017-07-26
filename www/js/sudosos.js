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
            );
        $urlRouterProvider.otherwise('/sudosos/products');
    }])
    .value("rootUrl", "http://sudosos.dev")
    .run(['$rootScope', '$state', function ($rootScope, $state) {

    }]);
