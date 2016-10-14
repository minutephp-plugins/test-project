<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller {

    use Minute\Event\Dispatcher;
    use Minute\Event\UserMailEvent;

    class Test2 {
        /**
         * @var Dispatcher
         */
        private $dispatcher;

        /**
         * Test2 constructor.
         *
         * @param Dispatcher $dispatcher
         */
        public function __construct(Dispatcher $dispatcher) {
            $this->dispatcher = $dispatcher;
        }

        public function index() {
            $event = new UserMailEvent(1);
            $event->setData('user_account_verify');
            $this->dispatcher->fire(UserMailEvent::USER_SEND_EMAIL, $event);
            //$this->dispatcher->fire(UserPaymentEvent::USER_FIRST_PAYMENT, $event);
        }
    }
}