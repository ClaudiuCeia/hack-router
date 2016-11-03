---
docid: benefits
title: Why use Codegen?
layout: docs
permalink: /docs/benefits.html
---

The [fredemmott/hack-router-codegen](https://github.com/fredemmott/hack-router-codegen)
project builds on top of of this project to automatically generate:

 - Full request routing objects and URI maps based on UriPatterns defined in the
   controllers
 - Per-controller parameter classes, allowing `$params->getFoo()` instead of
   `$params->getString('Foo')`; this allows the typechecker to catch more
   errors, and IDE autocomplete functionality to support parameters.
 - Per-controller UriBuilder classes, with similar benefits
