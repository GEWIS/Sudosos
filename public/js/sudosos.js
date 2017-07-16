angular.module('sudosos', ['sudosos.controllers', 'sudosos.filters', 'sudosos.services', 'ui.router'])
    .config(function ($stateProvider) {
        $stateProvider.state('sudosos', {
            url: '/sudosos',
            abstract: true,
            templateUrl: 'public/templates/sudosos.html',
            controller: 'SudososCtrl'
        });
    });
