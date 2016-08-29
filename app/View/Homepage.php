<div class="content-wrapper ng-cloak" ng-app="HomepageApp" ng-controller="HomepageController as mainCtrl" ng-init="init()" ng-cloak="">

    <div class="well" ng-repeat="blog in blogs">
        <p>Blog: {{blog.title}}</p>

        <div class="well" ng-repeat="story in blog.stories">
            <p>Story: {{story.content}}</p>

            <div class="well" ng-repeat="comment in story.comments">
                <p>Comment: {{comment.comment}} by {{comment.commenter.email}} / {{comment.commenter.user_id}}</p>
            </div>

            <div>
                <button type="button" class="btn btn-flat btn-default btn-xs" ng-click="story.comments.loadPrevPage()" ng-disabled="!story.comments.hasLessPages()"><i class="fa fa-angle-left"></i>
                    Back
                </button>
                <button type="button" class="btn btn-flat btn-default btn-xs" ng-click="story.comments.loadNextPage()" ng-disabled="!story.comments.hasMorePages()">Next <i
                        class="fa fa-angle-right"></i></button>
            </div>
        </div>

        <div>
            <button type="button" class="btn btn-flat btn-default btn-xs" ng-click="blog.stories.loadPrevPage()" ng-disabled="!blog.stories.hasLessPages()"><i class="fa fa-angle-left"></i> Back
            </button>
            <button type="button" class="btn btn-flat btn-default btn-xs" ng-click="blog.stories.loadNextPage()" ng-disabled="!blog.stories.hasMorePages()">Next <i class="fa fa-angle-right"></i>
            </button>
        </div>
    </div>

    <div class="well">
        <h3>Site users</h3>
        <div class="well" ng-repeat="user in users">
            <p>User: {{user.email}}</p>
        </div>

        <div>
            <button type="button" class="btn btn-flat btn-default btn-xs" ng-click="users.loadPrevPage()" ng-disabled="!users.hasLessPages()"><i class="fa fa-angle-left"></i> Back
            </button>
            <button type="button" class="btn btn-flat btn-default btn-xs" ng-click="users.loadNextPage()" ng-disabled="!users.hasMorePages()">Next <i class="fa fa-angle-right"></i>
            </button>
        </div>        
    </div>
</div>
