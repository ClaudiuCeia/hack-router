HackRouter
==========

Build a URI map based on static functions in your classes.

State
=====

Experimental, API is incomplete, API is unstable, code is poorly tested. **DO NOT USE**

Concept
=======

A controller (`URIRoutable`) defines its' own URI in a static function. The URI is defined as a sequence of `URIPart`s.
`URIPart`s could be a static string (eg a path component), or a named parameter. For example:

```Hack
use FredEmmott\HackRouter\URIPart;
use FredEmmott\HackRouter\URIStaticPart;
use FredEmmott\HackRouter\URIRoutable;
use FredEmmott\HackRouter\URIIntParam;
use FredEmmott\HackRouter\URIStringParam;

class BlogPostController implements URIRoutable {
  public static function getURIParts(): Vector<URIPart> {
    // eg '/blog/123/hello_world'
    return Vector {
      new URIStaticPart('blog'),
      new URIIntParam('id'),
      new URIStringParam('tagline'),
    };
  }
}
```

As this is a bit verbose, a short-hand is supported:

```Hack
use FredEmmott\HackRouter\URIPart;
use FredEmmott\HackRouter\URIParam;
use FredEmmott\HackRouter\URIRoutable;

class BlogPostController implements URIRoutable {
  public static function getURIParts(): Vector<URIPart> {
    // eg '/blog/123/hello_world'
    return Vector {
      URIPart::string('blog'),
      URIParam::int('id'),
      URIParam::string('tagline'),
    };
  }
}
