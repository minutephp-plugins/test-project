<div id="landing" class="background-cover" ng-style="{'background-image': model.backgroundImage && 'url(' + model.backgroundImage + ')'}">
    <div class="overlay" ng-style="{opacity: model.backgroundOpacity || 1}"></div>
    <div class="container-fluid">
        <div id="navtop">
            <nav class="navbar navbar-inverse transparent">
                <div ng-component="menu"></div>
            </nav>

            <div class="container">
                <div class="row">
                    <div class="{{'col-md-' + (!!model.videoThumb && (12 - (model.thumbSize || 6)) || 12)}}
                    {{(!!model.videoThumb && model.thumbPosition === 'left') && ('col-md-push-' + (model.thumbSize || 6)) || ''}}">
                        <div class="heading-text">
                            <h1 ng-bind-html="model.heading | markdown"></h1>

                            <h3 ng-bind-html="model.subHeading | markdown"></h3>

                            <p>&nbsp;</p>

                            <a class="btn btn-primary btn-xlarge" ng-bind-html="model.signupButtonCta | markdown" ng-if="model.signupButtonCta"
                               ng-href="{{model.signupButtonLink || '#/signup'}}" ng-click=""></a>

                            <p>&nbsp;</p>

                            <small ng-bind-html="model.textUnderSignupButton | markdown"></small>
                        </div>
                    </div>
                    <div class="col-md-{{(model.thumbSize || 6)}} {{model.thumbPosition === 'left' && ('col-md-pull-' + (12 - (model.thumbSize || 6))) || ''}}" ng-if="!!model.videoThumb">
                        <a ng-href="{{model.videoUrl}}"><img ng-src="{{model.videoThumb}}" class="thumbnail"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>