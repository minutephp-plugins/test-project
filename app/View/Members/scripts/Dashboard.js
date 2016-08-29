/// <reference path="E:/var/Dropbox/projects/minutephp/public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var DashboardController = (function () {
        function DashboardController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return DashboardController;
    }());
    Admin.DashboardController = DashboardController;
    angular.module('DashboardApp', ['MinuteFramework', 'gettext'])
        .controller('DashboardController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', DashboardController]);
})(Admin || (Admin = {}));
