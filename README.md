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
        Tarach\LSM\Providers\SessionMessageProvider::class,
    ],
```
* ( optional ) in `config/app.php` append facade with any name you like. `SessionMessage` is not mandatory.
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
#### Usage
###### basic
```php
    tlsm_messages()->notify('Message');
    // or
    tlsm_messages('Message'); // same as above
```
instead of notify you can use `failure`, `success`, `warning`

###### display message just for the next request ( default )
```php
    tlsm_messages('Message')
        ->flash()
        ->save()
        // or
        ->setMethod(\Tarach\LSM\Message::METHOD_FLASH) 
        ->save();
```

###### display message on every request until removed manually
```php
tlsm_messages('Message')
      ->persist()
      ->save()
      // or
      ->setMethod(\Tarach\LSM\Message::METHOD_PERSIST)
      ->save();
```

###### display message on every request until user will press 'x' making ajax request to `/session_message/remove/{id}`
```php
tlsm_messages('Message')
      ->removable()
      ->save()
      // or
      ->setMethod(\Tarach\LSM\Message::METHOD_REMOVABLE)
      ->save();
```
###### append CSS class
```php
$Message = tlsm_messages('Message');

$Message->addClasses('your-class');
        ->save();
// or
$Message->addClasses(['your-class', 'other-class']);
        ->save();
// or
$Message->setClasses($Message->getClasses().' your-class')
        ->save();
```
###### travers through all saved messages
```php
foreach(tlsm_messages() as $Message)
{
    /* @var $Message \Tarach\LSM\Message\Message */
    // ...
}
```
###### get message by its index ( numeric id ) and check whether it exists
```php
  $Message = new \Tarach\LSM\Message\Message(0);
  if($Message->exists()) {
      // ...
  }
```
###### remove message
```php
  tlsm_messages('this is saved to session right away as notify')->remove();
```

~Happy coding :)
