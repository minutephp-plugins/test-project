/// <reference path="E:/var/Dropbox/projects/minutephp/public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var MembersController = (function () {
        function MembersController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return MembersController;
    }());
    Admin.MembersController = MembersController;
    angular.module('MembersApp', ['MinuteFramework', 'gettext'])
        .controller('MembersController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', MembersController]);
})(Admin || (Admin = {}));
