<?php 
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;
use Symfony\Component\Security\Core\Exception\TooManyLoginAttemptsAuthenticationException;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class LoginFailureListener implements EventSubscriberInterface
{
    private $flashBag;

    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    public function onLoginFailure(LoginFailureEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof TooManyLoginAttemptsAuthenticationException) {
            $this->flashBag->add('error', 'You have exceeded the maximum number of login attempts. Please try again later.');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginFailureEvent::class => 'onLoginFailure',
        ];
    }
}
