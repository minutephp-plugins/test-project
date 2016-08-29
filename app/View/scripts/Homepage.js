/// <reference path="E:/var/Dropbox/projects/minutephp/public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var HomepageController = (function () {
        function HomepageController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return HomepageController;
    }());
    Admin.HomepageController = HomepageController;
    angular.module('HomepageApp', ['MinuteFramework', 'gettext'])
        .controller('HomepageController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', HomepageController]);
})(Admin || (Admin = {}));
