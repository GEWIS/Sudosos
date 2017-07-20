/**
 * Created by s156386 on 20-7-2017.
 */
angular.module('sudosos.directives', [])
    .directive("fileinput", [
        function() {
            return {
                scope: {
                    fileinput: "=",
                    filepreview: "="
                },
                link: function(scope, element, attributes) {
                    element.bind("change", function(changeEvent) {
                        scope.fileinput = changeEvent.target.files[0];
                        var reader = new FileReader();
                        reader.onload = function(loadEvent) {
                            scope.$apply(function() {
                                scope.filepreview = loadEvent.target.result;
                            });
                        };
                        reader.readAsDataURL(scope.fileinput);
                    });
                }
            };
        }
    ]);