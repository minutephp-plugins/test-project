(function() {
    var BlogItem = (function (_super) {
        __extends(BlogItem, _super);
        function BlogItem(parent, data) {
            _super.call(this, parent);
            this.parent = parent;

            this.stories = (new StoryArray(this));

            this.attrs = ["blog_id","title"];
            this.extend(data);
        }
        return BlogItem;
    }(Minute.Item));
    var BlogItemArray = (function (_super) {
        __extends(BlogItemArray, _super);
        function BlogItemArray(parent) {
            _super.call(this, BlogItem, parent, 'blogs', 'Blog', 'blog_id', null);
            this.parent = parent;
        }
        return BlogItemArray;
    }(Minute.Items));
    var StoryItem = (function (_super) {
        __extends(StoryItem, _super);
        function StoryItem(parent, data) {
            _super.call(this, parent);
            this.parent = parent;


            this.attrs = ["post_id","blog_id","content"];
            this.extend(data);
        }
        return StoryItem;
    }(Minute.Item));
    var StoryItemArray = (function (_super) {
        __extends(StoryItemArray, _super);
        function StoryItemArray(parent) {
            _super.call(this, StoryItem, parent, 'stories', 'Post', 'post_id', 'blog_id');
            this.parent = parent;
        }
        return StoryItemArray;
    }(Minute.Items)); })();

(function() {
    var UserItem = (function (_super) {
        __extends(UserItem, _super);
        function UserItem(parent, data) {
            _super.call(this, parent);
            this.parent = parent;


            this.attrs = ["user_id","email"];
            this.extend(data);
        }
        return UserItem;
    }(Minute.Item));
    var UserItemArray = (function (_super) {
        __extends(UserItemArray, _super);
        function UserItemArray(parent) {
            _super.call(this, UserItem, parent, 'users', 'User', 'user_id', null);
            this.parent = parent;
        }
        return UserItemArray;
    }(Minute.Items)); })();

(function() {
    Minute.loadModels('blogs', new Blog(null), [
        {
            "blog_id": 1,
            "title": "blog title #1",
            "stories": [
                {
                    "post_id": 1,
                    "blog_id": 1,
                    "content": "post #1"
                },
                {
                    "post_id": 2,
                    "blog_id": 1,
                    "content": "post #2"
                }
            ]
        },
        {
            "blog_id": 2,
            "title": "blog title #2",
            "stories": [
                {
                    "post_id": 4,
                    "blog_id": 2,
                    "content": "post #4"
                },
                {
                    "post_id": 5,
                    "blog_id": 2,
                    "content": "post #5"
                }
            ]
        }
    ]);
})();

(function() {
    Minute.loadModels('users', new User(null), [
        {
            "user_id": 1,
            "email": "one@"
        },
        {
            "user_id": 2,
            "email": "two@"
        }
    ]);
})();

