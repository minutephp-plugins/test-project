<?php

define('DEBUG_MODE', true);

use App\Config\BootLoader;
use Auryn\Injector;
use Minute\Apache\ApacheFile;
use Minute\App\App;
use Minute\Auth\CheckUserLogin;
use Minute\Auth\CreateNewUser;
use Minute\Auth\UpdateUserData;
use Minute\Bug\Catcher;
use Minute\Cache\QCache;
use Minute\Component\CmsComponent;
use Minute\Config\Config;
use Minute\Controller\Runnable;
use Minute\Database\Database;
use Minute\Docker\DockerFile;
use Minute\Event\AdminEvent;
use Minute\Event\AppEvent;
use Minute\Event\AuthEvent;
use Minute\Event\Binding;
use Minute\Event\CmsEvent;
use Minute\Event\ControllerEvent;
use Minute\Event\Dispatcher;
use Minute\Event\DockerEvent;
use Minute\Event\MemberEvent;
use Minute\Event\ModelEvent;
use Minute\Event\ProviderEvent;
use Minute\Event\PurchaseEvent;
use Minute\Event\RawMailEvent;
use Minute\Event\RedirectEvent;
use Minute\Event\RequestEvent;
use Minute\Event\ResponseEvent;
use Minute\Event\RouterEvent;
use Minute\Event\SessionEvent;
use Minute\Event\TodoEvent;
use Minute\Event\UserAdminEvent;
use Minute\Event\UserForgotPasswordEvent;
use Minute\Event\UserLoginEvent;
use Minute\Event\UserProfileEvent;
use Minute\Event\UserSignupEvent;
use Minute\Event\UserUpdateDataEvent;
use Minute\Event\UserUploadEvent;
use Minute\Http\HttpRequestEx;
use Minute\Http\HttpResponseEx;
use Minute\Log\LoggerEx;
use Minute\Log\PaymentLogger;
use Minute\Mail\EventMailer;
use Minute\Mail\SesMailer;
use Minute\Menu\AdminMenu;
use Minute\Menu\AffiliateMenu;
use Minute\Menu\ArMenu;
use Minute\Menu\AuthMenu;
use Minute\Menu\AwsMenu;
use Minute\Menu\BugMenu;
use Minute\Menu\CmsMenu;
use Minute\Menu\CronMenu;
use Minute\Menu\MailMenu;
use Minute\Menu\MemberMenu;
use Minute\Menu\MinifyMenu;
use Minute\Menu\PaymentMenu;
use Minute\Menu\ProductMenu;
use Minute\Menu\ProjectMenu;
use Minute\Menu\SupportMenu;
use Minute\Menu\TodoMenu;
use Minute\Menu\TranslateMenu;
use Minute\Menu\UserMenu;
use Minute\Panel\BugPanel;
use Minute\Panel\MailPanel;
use Minute\Panel\PaymentPanel;
use Minute\Panel\PluginPanel;
use Minute\Panel\ProjectPanel;
use Minute\Panel\SupportPanel;
use Minute\Panel\UserPanel;
use Minute\Payment\Processor;
use Minute\Payment\ProviderInfo;
use Minute\Profile\UserProfile;
use Minute\Render\ModelPrinter;
use Minute\Render\Output;
use Minute\Render\Problem;
use Minute\Render\SessionPrinter;
use Minute\Router\CmsRouter;
use Minute\Routing\Router;
use Minute\Session\Session;
use Minute\Todo\ProductTodo;
use Minute\Upload\S3Uploader;

require_once('../vendor/autoload.php');

$frameworkListeners = [ //we will have to move some of these to the plugins they're linked to like LoginHandler
                        //framework
                        ['event' => RequestEvent::REQUEST_HANDLE, 'handler' => [Router::class, 'handle']],
                        ['event' => ResponseEvent::RESPONSE_RENDER, 'handler' => [Output::class, 'send']],
                        ['event' => ResponseEvent::RESPONSE_ERROR, 'handler' => [Problem::class, 'send']],
                        ['event' => AuthEvent::AUTH_CHECK_ACCESS, 'handler' => [Session::class, 'checkAccess']],
                        ['event' => ControllerEvent::CONTROLLER_EXECUTE, 'handler' => [Runnable::class, 'execute']],
                        ['event' => RedirectEvent::REDIRECT, 'handler' => [Output::class, 'redirect']],
                        ['event' => ModelEvent::IMPORT_MODELS_AS_JS, 'handler' => [ModelPrinter::class, 'importModels']],
                        ['event' => SessionEvent::IMPORT_SESSION_AS_JS, 'handler' => [SessionPrinter::class, 'importSession']],

                        //admin
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [AdminMenu::class, 'adminLinks']],
                        ['event' => AdminEvent::IMPORT_ADMIN_DASHBOARD_PANELS, 'handler' => [PluginPanel::class, 'adminDashboardPanel']],

                        //admin
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [AffiliateMenu::class, 'adminLinks']],

                        //auth
                        ['event' => UserLoginEvent::USER_LOGIN_AUTHENTICATE, 'handler' => [CheckUserLogin::class, 'authenticate']],
                        ['event' => UserSignupEvent::USER_SIGNUP_BEGIN, 'handler' => [CreateNewUser::class, 'signup']],
                        ['event' => UserUpdateDataEvent::USER_UPDATE_DATA, 'handler' => [UpdateUserData::class, 'update']],
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [AuthMenu::class, 'adminLinks']],

                        //autoresponder
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [ArMenu::class, 'adminLinks']],

                        //aws
                        ['event' => RawMailEvent::MAIL_SEND_RAW, 'handler' => [SesMailer::class, 'sendMail']],
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [AwsMenu::class, 'adminLinks']],
                        ['event' => UserUploadEvent::USER_UPLOAD_FILE, 'handler' => [S3Uploader::class, 'upload']],
                        ['event' => DockerEvent::DOCKER_INCLUDE_FILES, 'handler' => [DockerFile::class, 'create'], 'priority' => 100],
                        ['event' => DockerEvent::DOCKER_INCLUDE_FILES, 'handler' => [ApacheFile::class, 'config'], 'priority' => 1],
                        ['event' => DockerEvent::DOCKER_INCLUDE_FILES, 'handler' => [DockerFile::class, 'finish'], 'priority' => -100],

                        //bug
                        ['event' => AppEvent::APP_INIT, 'handler' => [Catcher::class, 'register']],
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [BugMenu::class, 'adminLinks']],
                        ['event' => AdminEvent::IMPORT_ADMIN_DASHBOARD_PANELS, 'handler' => [BugPanel::class, 'adminDashboardPanel']],

                        //cms
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [CmsMenu::class, 'adminLinks']],
                        ['event' => MemberEvent::IMPORT_MEMBERS_MENU_LINKS, 'handler' => [CmsMenu::class, 'memberLinks']],
                        ['event' => CmsEvent::IMPORT_CMS_COMPONENT, 'handler' => [CmsComponent::class, 'render']],
                        ['event' => RouterEvent::ROUTER_GET_FALLBACK_RESOURCE, 'handler' => [CmsRouter::class, 'handle'], 'priority' => 100],

                        //cron
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [CronMenu::class, 'adminLinks']],

                        //mail
                        ['event' => UserForgotPasswordEvent::USER_FORGOT_PASSWORD, 'handler' => [EventMailer::class, 'sendMail'], 'data' => 'user_forgot_email'],
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [MailMenu::class, 'adminLinks']],
                        ['event' => AdminEvent::IMPORT_ADMIN_DASHBOARD_PANELS, 'handler' => [MailPanel::class, 'adminDashboardPanel']],

                        //members
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [MemberMenu::class, 'adminLinks']],
                        ['event' => MemberEvent::IMPORT_MEMBERS_MENU_LINKS, 'handler' => [MemberMenu::class, 'memberLinks']],
                        ['event' => MemberEvent::IMPORT_MEMBERS_TOOLBAR_LINKS, 'handler' => [MemberMenu::class, 'toolbarLinks']],
                        ['event' => MemberEvent::IMPORT_MEMBERS_PROFILE_SHORTCUTS, 'handler' => [MemberMenu::class, 'profileLinks']],

                        //minify
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [MinifyMenu::class, 'adminLinks']],

                        //payment
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [PaymentMenu::class, 'adminLinks']],
                        ['event' => AdminEvent::IMPORT_ADMIN_DASHBOARD_PANELS, 'handler' => [PaymentPanel::class, 'adminDashboardPanel']],
                        ['event' => 'payment.*', 'handler' => [PaymentLogger::class, 'log']],
                        ['event' => ProviderEvent::IMPORT_PROVIDERS_LIST, 'handler' => [ProviderInfo::class, 'describe']],
                        ['event' => UserAdminEvent::IMPORT_ADMIN_USER_PANEL, 'handler' => [PaymentMenu::class, 'adminUserPanels']],
                        ['event' => PurchaseEvent::PURCHASE_GET_LINK, 'handler' => [Processor::class, 'createBuyLink']],

                        //product
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [ProductMenu::class, 'adminLinks']],
                        ['event' => TodoEvent::IMPORT_TODO_ADMIN, 'handler' => [ProductTodo::class, 'adminTodo']],

                        //project
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [ProjectMenu::class, 'adminLinks']],
                        ['event' => AdminEvent::IMPORT_ADMIN_DASHBOARD_PANELS, 'handler' => [ProjectPanel::class, 'adminDashboardPanel']],
                        ['event' => MemberEvent::IMPORT_MEMBERS_MENU_LINKS, 'handler' => [ProjectMenu::class, 'memberLinks']],

                        //support
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [SupportMenu::class, 'adminLinks']],
                        ['event' => MemberEvent::IMPORT_MEMBERS_MENU_LINKS, 'handler' => [SupportMenu::class, 'memberLinks']],
                        ['event' => AdminEvent::IMPORT_ADMIN_DASHBOARD_PANELS, 'handler' => [SupportPanel::class, 'adminDashboardPanel']],

                        //todos
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [TodoMenu::class, 'adminLinks']],

                        //translate
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [TranslateMenu::class, 'adminLinks']],

                        //user
                        ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [UserMenu::class, 'adminLinks']],
                        ['event' => UserAdminEvent::IMPORT_ADMIN_USER_PANEL, 'handler' => [UserMenu::class, 'adminUserPanels']],
                        ['event' => AdminEvent::IMPORT_ADMIN_DASHBOARD_PANELS, 'handler' => [UserPanel::class, 'adminDashboardPanel']],
                        ['event' => UserProfileEvent::IMPORT_USER_GET_PROFILE_FIELDS, 'handler' => [UserProfile::class, 'getFields']],
                        //['event' => UserErrorEvent::USER_MAIL_BOUNCE, 'handler' => [Someclass, 'sendMail']],
];

$injector = new Injector;

$injector->share(Binding::class);
$injector->share(BootLoader::class);
$injector->share(Config::class);
$injector->share(Database::class);
$injector->share(Dispatcher::class);
$injector->share(HttpRequestEx::class);
$injector->share(HttpResponseEx::class);
$injector->share(LoggerEx::class);
$injector->share(QCache::class);
$injector->share(Router::class);
$injector->share(Session::class);
$injector->share($injector);

$injector->define(Binding::class, [':defaultListeners' => $frameworkListeners]);

@unlink('c:/tmp/d.sql');

/** @var App $app */
$app = $injector->make('Minute\App\App');
$app->run();

