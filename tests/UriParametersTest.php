<?hh // strict

namespace FredEmmott\HackRouter;

use \FredEmmott\HackRouter\Tests\TestIntEnum;

final class UriParametersTest extends \PHPUnit_Framework_TestCase {
  public function testStringParam(): void {
    $parts = [new UriPatternStringParameter('foo')];
    $data = ImmMap { 'foo' => 'bar' };
    $this->assertSame(
      'bar',
      (new UriParameters($parts, $data))->getString('foo'),
    );
  }

  public function testIntParam(): void {
    $parts = [new UriPatternIntParameter('foo')];
    $data = ImmMap { 'foo' => '123' };
    $this->assertSame(
      123,
      (new UriParameters($parts, $data))->getInt('foo'),
    );
  }

  /**
   * @expectedException \HH\InvariantException
   */
  public function testFetchingStringAsInt(): void {
    $parts = [new UriPatternStringParameter('foo')];
    $data = ImmMap { 'foo' => 'bar' };
    (new UriParameters($parts, $data))->getInt('foo');
  }

  public function testEnumParam(): void {
    $parts = [new UriPatternEnumParameter(TestIntEnum::class, 'foo')];
    $data = ImmMap { 'foo' => (string) TestIntEnum::BAR };
    $value = (new UriParameters($parts, $data))->getEnum(
      TestIntEnum::class,
      'foo',
    );
    $this->assertSame(
      TestIntEnum::BAR,
      $value,
    );

    $typechecker_test = (TestIntEnum $x) ==> {};
    $typechecker_test($value);
  }

  public function testFromPattern(): void {
    $parts = (new UriPattern())
      ->literal('/')
      ->string('foo')
      ->literal('/')
      ->int('bar')
      ->literal('/')
      ->enum(TestIntEnum::class, 'baz')
      ->getParameters();
    $data = ImmMap {
      'foo' => 'some string',
      'bar' => '123',
      'baz' => (string) TestIntEnum::FOO,
    };
    $params = new UriParameters($parts, $data);
    $this->assertSame(
      'some string',
      $params->getString('foo'),
    );
    $this->assertSame(
      123,
      $params->getInt('bar'),
    );
    $this->assertSame(
      TestIntEnum::FOO,
      $params->getEnum(TestIntEnum::class, 'baz'),
    );
  }
}
