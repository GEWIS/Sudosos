angular.module('sudosos', ['sudosos.controllers', 'sudosos.filters', 'sudosos.services', 'ui.router'])
    .config(function ($stateProvider, $urlRouterProvider) {
        $stateProvider.state('sudosos', {
            url: '/sudosos',
            abstract: true,
            templateUrl: 'sudosos.html',
            controller: 'SudososCtrl'
        })

            .state('sudosos.financial', {
                url: '/financial',
                views: {
                    'admin-panel-content': {
                        templateUrl: 'financial.html',
                        controller: 'FinancialCtrl'
                    }
                }
            })

            .state('sudosos.products', {
                url: '/products',
                views: {
                    'admin-panel-content': {
                        templateUrl: 'products.html',
                        controller: 'ProductsCtrl'
                    }
                }
            });
        $urlRouterProvider.otherwise('/sudosos/products');
    })
    .value("rootUrl", "http://sudosos.dev")
    .run(['$rootScope', '$state', function ($rootScope, $state) {

    }]);
