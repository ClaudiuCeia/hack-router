---
docid: uri-patterns
title: UriPatterns
layout: docs
permalink: /docs/uri-patterns.html
---

Generate FastRoute fragments, URIs (for linking), and retrieve URI parameters in a consistent and type-safe way:

```php
<?hh // strict
final class UserPageController extends WebController {
  public static function getUriPattern(): UriPattern {
    return (new UriPattern())
      ->literal('/users/')
      ->string('user_name');
  }
  // ...
}
```

Parameters can be retrevied, with types checked at runtime both against the values, and the definition:

```php
public function getResponse(): string {
  return 'Hello, '.$this->getUriParameters()->getString('user_name');
}
```

You can also generate links to controllers:

```php
$link = UserPageController::getUriBuilder()
  ->setString('user_name', 'Mr Hankey')
  ->getPath();
```

These examples are simplified for conciseness - see examples/UriPatternsExample.php for full executable example.
