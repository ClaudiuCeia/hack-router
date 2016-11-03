---
docid: getting-started
title: Getting started with HackRouter
layout: docs
permalink: docs/getting-started.html
---

A simple typed request router, built on top of `nikic/fast-route`. Example:

```php
<?hh // strict
/** TResponder can be whatever you want; in this case, it's a
 * callable, but classname<MyWebControllerBase> is also a
 * common choice.
 */
type TResponder = (function(ImmMap<string, string>):string);

final class BaseRouterExample extends BaseRouter<TResponder> {
  protected function getRoutes(
  ): ImmMap<HttpMethod, ImmMap<string, TResponder>> {
    return ImmMap {
      HttpMethod::GET => ImmMap {
        '/' =>
          ($_params) ==> 'Hello, world',
        '/user/{user_name}' =>
          ($params) ==> 'Hello, '.$params['user_name'],
      },
      HttpMethod::POST => ImmMap {
        '/' => ($_params) ==> 'Hello, POST world',
      },
    };
  }
}
```

Simplified for conciseness - see
[`examples/BaseRouterExample.php`](https://github.com/FredEmmott/hack-router/blob/master/examples/BaseRouterExample.php) for
full executable example.

