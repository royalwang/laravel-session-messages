# Laravel Session Messages
### Provides:
* multiple session messages
* flash messages ( just for the next request )
* persistent messages ( will display until removed from PHP code ) 
* removable messages ( user must press x or they will remain for another request ) 

#### Installation

* Go to your laravel directory and run
```
    composer require tarach/laravel-session-messages
```
* Go to your `config/app.php` and append fallowing providers
```php
    'providers' => [
        // ...
        Tarach\LSM\Providers\SessionMessageServiceProvider::class,
    ],
```
* ( optional ) in `config/app.php` append facade with any name you like `SessionMessage` is not mandatory
```php
    'aliases' => [
        // ...
        'SessionMessage'  => Tarach\LSM\SessionMessageFacade::class,
    ],
```
* to the view you want the messages to be displayed add
```
    @include('tlsm::messages')
```
* run `php artisan vendor:publish` This command will cause the fallowing:
  - `<tlsm>/resources` will be copied to `/resources/tlsm`
  - `<tlsm>/config/routes.php` will be copied to `/config/tlsm.routes.php` and will be loaded instead
  - views from `/resources/tlsm/views` will be used when using `@include('tlsm::messages')` instead of ones in `<tlsm>` dir
* add `messages.css` and `messages.js` ( requires jQuery ) from `/resources/tlsm/assets` to your elixir mix. Or copy them to public directory and include in your template
### Usage
##### basic
```php
tlsm_session_message()->notify('Message');
/* or */
tlsm_session_message('Message'); // same as above
```
instead of notify you can use `failure`, `success`, `warning`

##### display message just for the next request ( default )
```php
tlsm_session_message('Message')
      ->setMethod(\Tarach\LSM\Message::METHOD_FLASH)
      ->save();
```

##### display message on every request until removed manually
```php
tlsm_session_message('Message')
      ->setMethod(\Tarach\LSM\Message::METHOD_PERSIST)
      ->save();
```

##### display message on every request until user will press 'x' making ajax request to `/session_message/remove/{id}`
```php
tlsm_session_message('Message')
      ->setMethod(\Tarach\LSM\Message::METHOD_REMOVABLE)
      ->save();
```
##### append CSS class
```php
$Message = tlsm_session_message('Message');
$Message->setClasses($Message->getClasses().' your-class')
        ->save();
```
##### travers through all saved messages
```php
foreach(tlsm_session_message() as $Message)
{
    /* @var $Message \Tarach\LSM\Message */
    // ...
}
```
##### get message by its index ( numeric id ) and check whether it exists
```php
  $Message = new \Tarach\LSM\Message(0, tlsm_session_message());
  if($Message->exists()) {
      // ...
  }
```
##### remove message
```php
  tlsm_session_message('this is saved to session right away')->remove();
```

~Happy coding :)
