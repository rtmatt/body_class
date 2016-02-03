#  Body Class

Laravel Service provider built around [Agent](https://github.com/jenssegers/agent) to add browser classes to the body  HTML tag.

## Installation

Install using composer:

``` bash 

$ composer require rtmatt/body-class

```

Add service provider to ```config/app.php ```


``` php 

Rtmatt\BodyClass\BodyClassServiceProvider::class

```

## Usage
This requires your layout file to be ``` /resources/views/layouts/main.blade.php ```.  Support for multiple or other layouts may come in the future.

In file mentioned above, add the following to your body tag:

``` php 

<body{!! ($body_class) ? ' class="'.$body_class.'"' : '' !!}>

```

You are good to go!



