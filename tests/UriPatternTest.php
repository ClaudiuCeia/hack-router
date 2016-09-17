<?hh // strict

namespace FredEmmott\HackRouter;

use \FredEmmott\HackRouter\Tests\TestStringEnum;
use \FredEmmott\HackRouter\Tests\TestIntEnum;

final class UriPatternTest extends \PHPUnit_Framework_TestCase {
  public function testLiteral(): void {
    $pattern = (new UriPattern())
      ->literal('/foo')
      ->getFastRouteFragment();
    $this->assertSame('/foo', $pattern);
  }

  public function testMultipleLiterals(): void {
    $pattern = (new UriPattern())
      ->literal('/foo')
      ->literal('/bar')
      ->getFastRouteFragment();
    $this->assertSame('/foo/bar', $pattern);
  }

  public function testStringParamFragment(): void {
    $pattern = (new UriPattern())
      ->literal('/~')
      ->string('username')
      ->getFastRouteFragment();
    $this->assertSame('/~{username}', $pattern);
  }

  public function testStringParamAssertSucceeds(): void {
    $this->assertSame(
      (new UriPatternStringParameter('foo'))->assert('foo'),
      'foo',
    );
  }

  public function testIntParamFragment(): void {
    $pattern = (new UriPattern())
      ->literal('/blog/')
      ->int('post_id')
      ->getFastRouteFragment();
    $this->assertSame('/blog/{post_id:\d+}', $pattern);
  }

  public function testIntParamAssertSucceeds(): void {
    $this->assertSame(
      (new UriPatternIntParameter('foo'))->assert('123'),
      123, // not a string
    );
  }

  public function exampleInvalidInts(): array<array<string>> {
    return [
      ['foo'],
      ['0123foo'],
      ['0.123foo'],
      ['0.123'],
      ['0x1e3'],
    ];
  }

  /**
   * @dataProvider exampleInvalidInts
   * @expectedException \HH\InvariantException
   */
  public function testIntParamAssertThrows(string $input): void {
    (new UriPatternIntParameter('foo'))->assert($input);
  }

  public function TestStringEnumParamFragment(): void {
    $pattern = (new UriPattern())
      ->literal('/foo/')
      ->enum(TestStringEnum::class, 'my_param')
      ->getFastRouteFragment();
    $this->assertSame(
      '/foo/{my_param:(?:herp|derp)}',
      $pattern,
    );
  }

  public function TestStringEnumParamAssertSucceeds(): void {
    $this->assertSame(
      TestStringEnum::FOO,
      (new UriPatternEnumParameter(TestStringEnum::class, 'param_name'))
        ->assert((string) TestStringEnum::FOO),
    );
  }

  public function TestIntEnumParamAssertSucceeds(): void {
    $this->assertSame(
      TestIntEnum::FOO,
      (new UriPatternEnumParameter(TestStringEnum::class, 'param_name'))
        ->assert((string) TestIntEnum::FOO),
    );
  }

  /**
   * @expectedException UnexpectedValueException
   */
  public function testEnumParamAssertFails(): void {
    (new UriPatternEnumParameter(TestStringEnum::class, 'param_name'))
      ->assert('not a valid enum value');
  }
}
