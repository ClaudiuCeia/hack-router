<?hh // strict

namespace FredEmmott\HackRouter;

use \FredEmmott\HackRouter\Tests\TestIntEnum;
use \FredEmmott\HackRouter\Tests\TestStringEnum;

final class RequestParametersTest extends \PHPUnit_Framework_TestCase {
  public function testStringParam(): void {
    $parts = [new StringRequestParameter('foo')];
    $data = ImmMap { 'foo' => 'bar' };
    $this->assertSame(
      'bar',
      (new RequestParameters($parts, $data))->getString('foo'),
    );
  }

  public function testIntParam(): void {
    $parts = [new IntRequestParameter('foo')];
    $data = ImmMap { 'foo' => '123' };
    $this->assertSame(
      123,
      (new RequestParameters($parts, $data))->getInt('foo'),
    );
  }

  /**
   * @expectedException \HH\InvariantException
   */
  public function testFetchingStringAsInt(): void {
    $parts = [new StringRequestParameter('foo')];
    $data = ImmMap { 'foo' => 'bar' };
    (new RequestParameters($parts, $data))->getInt('foo');
  }

  public function testEnumParam(): void {
    $parts = [new EnumRequestParameter(TestIntEnum::class, 'foo')];
    $data = ImmMap { 'foo' => (string) TestIntEnum::BAR };
    $value = (new RequestParameters($parts, $data))->getEnum(
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

  public function testEnumParamToUri(): void {
    $part = (new EnumRequestParameter(TestIntEnum::class, 'foo'));
    $this->assertSame(
      (string) TestIntEnum::BAR,
      $part->getUriFragment(TestIntEnum::BAR),
    );
  }

  /**
   * @expectedException UnexpectedValueException
   */
  public function testInvalidEnumParamToUri(): void {
    $part = (new EnumRequestParameter(TestIntEnum::class, 'foo'));
    /* HH_IGNORE_ERROR[4110] intentionally doing the wrong thing */
    $_throws = $part->getUriFragment(TestStringEnum::BAR);
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
    $params = new RequestParameters($parts, $data);
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
