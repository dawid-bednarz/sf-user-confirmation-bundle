# INSTALLATION
`composer require dawid-bednarz/sf-confirmation-bundle`

####1. Create entities file
```php
namespace App\Entity\User;

use DawBed\PHPUserActivateToken\UserActivateToken as Base;

class UserActivateToken extends Base
{
}
```

#### 2. Create user_confirmation_bundle.yaml in your ~/config/packages directory
```yaml
dawbed_user_confirmation_bundle:
    entities:
      UserActivateToken: 'App\Entity\User\UserActivateToken'
```

# COMMANDS
Checking if you have all registered listeners
```
bin/console dawbed:debug:event_listener  
```
# EVENTS
You must:
- extend support request/response/error registration process
#### Registration required handle process
services.yaml
```yaml
    App\EventListener\User\Registration\ResponseListener:
        tags:
            - { name: kernel.event_listener, event: !php/const DawBed\UserRegistrationBundle\Event\Events::REGISTRATION_RESPONSE }
    App\EventListener\User\Registration\ErrorListener:
        tags:
            - { name: kernel.event_listener, event: !php/const DawBed\UserRegistrationBundle\Event\Events::REGISTRATION_ERROR }
    App\EventListener\User\Registration\InvalidTokenListener:
        tags:
            - { name: kernel.event_listener, event: !php/const DawBed\UserRegistrationBundle\Event\Events::REGISTRATION_INVALID_CONFIRMATION_TOKEN }
    App\EventListener\User\Registration\RefreshTokenListener:
        tags:
            - { name: kernel.event_listener, event: !php/const DawBed\UserRegistrationBundle\Event\Events::REGISTRATION_REFRESH_CONFIRMATION_TOKEN }
```
Look on the below to see example php handler listener
```php
namespace App\EventListener\Registration\User;

class ResponseListener
{
    function __invoke(ResponseInterfaceEvent $event): void
    {
        $response = new Response();
        $user = $event->getUser();
        $response->setContent('...');

        $event->setResponse($response);
    }
}
```
Example Registration Error Listener
```php
namespace App\EventListener\Registration\User;

class ErrorListener
{
    public function __invoke(ErrorEvent $event)
    {
        $form = $event->getForm();
        $response = new Response();
        $response->setContent('...');
        $event->setResponse($response);
    }
}
```
Example Invalid Token Confirmation Listener
```php
namespace App\EventListener\User\Registration;

use DawBed\UserRegistrationBundle\Event\Registration\InvalidTokenEvent;

class InvalidTokenListener
{
    function __invoke(InvalidTokenEvent $event): void
    {
        $response = new Response();
        $form = $event->getForm();
        $message = $event->getMessage();
        if ($event->isConsumed()) {
            $response->setContent('...');
        } elseif ($event->isExpired()) {
            $response->setContent('...');
        }
        $event->setResponse($response);
    }
}
```
Example Refresh Token Confirmation Listener
```php
namespace App\EventListener\User\Registration;

class RefreshTokenListener
{
    function __invoke(RefreshTokenEvent $event): void
    {
        $response = new Response();
        $user = $event->getUser(); // user with new activate token
        $response->setContent('...');

        $event->setResponse($response);
    }
}
```
# COMMANDS
Checking if you have all registered listeners
```
bin/console dawbed:debug:event_listener  
```
