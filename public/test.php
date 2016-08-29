<div aria-label="Login" ng-cloak ng-init="providers = session.providers">
    <div class="row">
        <div class="col-xs-12">
            <h4 class="minute-heading" align="center" translate="">Sign In</h4>
            <button ng-show="!modal" class="close-button btn btn-sm btn-default btn-transparent pull-right">&times;</button>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger alert-dismissible" role="alert" ng-show="!socket.error">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" aria-hidden="true">&times;</button>
                <ng-switch on="socket.error">
                    <span translate ng-switch-when="EMAIL_INVALID">Email is not registered.</span>
                    <span translate ng-switch-when="PASSWORD_INVALID">Password is incorrect.</span>
                    <span translate ng-switch-default>Unable to process login.</span>
                </ng-switch>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div ng-repeat="provider in providers" ng-show="provider.enabled">
                    <div ng-if="provider.name === 'Email'">
                        <form>
                            <div class="form-group">
                                <label for="email" ng-show="provider.showLabels"><span translate="">Email
                                        address:</span></label>
                                <div ng-class="{'input-group':provider.showIcons}">
                                    <div ng-show="provider.showIcons" class="input-group-addon"><i
                                            class="fa fa-envelope"></i></div>
                                    <input type="email" class="form-control auto-focus" id="email"
                                           placeholder="Registered Email address"
                                           ng-model="data.email" ng-required="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" ng-show="provider.showLabels"><span translate="">Password:</span></label>

                                <div ng-class="{'input-group':provider.showIcons}">
                                    <div ng-show="provider.showIcons" class="input-group-addon"><i class="fa fa-key"></i></div>
                                    <input type="password" class="form-control" id="password"
                                           placeholder="Account Password" ng-model="data.password" ng-required="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-default btn-primary pull-right">
                                    <span translate="">Sign in</span> <i class="fa fa-fw fa-angle-right"></i>
                                </button>

                                <div class="visible-xs">
                                    <div class="clearfix"></div>
                                    <br>
                                </div>

                                <div class="pull-left small">
                                    <div class="padded-bottom">
                                        <a ng-href="/auth/forgot"><span translate="">I forgot my password</span></a>
                                    </div>
                                    <div>
                                        <a ng-href="/auth/signup"><span translate="">New user? Sign up now!</span></a>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="text-center visible-sm" style="margin:20px;" ng-show="!$last">
                                <hr style="width:40%;margin-top:10px;" class="pull-left">
                                <span>OR</span>
                                <hr style="width:40%;margin-top:10px;" class="pull-right">
                            </div>

                            <br class="visible-xs">
                        </form>
                    </div>
                    <div ng-if="provider.name !== 'Email'">
                        <div class="padded-bottom">
                            <button type="button" class="btn btn-block btn-social btn-default btn-flat" ng-click="">
                                <i class="fa fa-{{provider.icon}}"></i> <span translate="">Sign in using</span>
                                {{provider.name}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>