<?php
abstract class TokenizerTests extends \unittest\TestCase {

  /**
   * Returns tokens in a given source code
   *
   * @param  string $source
   * @return var[]
   */
  protected abstract function tokensIn($source);

  /**
   * Creates a string representation of the given list of tokens
   *
   * @param  var[] $tokens
   * @return string
   */
  protected function tokenString($tokens) {
    $s= '';
    foreach ($tokens as $token) {
      $s.= ', '.(is_array($token) ? '['.implode(', ', $token).']' : $token);
    }
    return '['.substr($s, 2).']';
  }

  /**
   * Assertion helper
   *
   * @param  var[] $expected
   * @param  var[] $actual The list from the tokensIn() method
   * @throws unittest.AssertionFailedError
   */
  protected function assertTokens($expected, $actual) {
    array_unshift($expected, [T_OPEN_TAG, '<?php ', 1]);
    $expected[]= [T_CLOSE_TAG, '?>', 1];
    $this->assertEquals($this->tokenString($expected), $this->tokenString($actual));
  }

  #[@test]
  public function opening_and_closing() {
    $this->assertTokens(
      [],
      $this->tokensIn('<?php ?>')
    );
  }

  #[@test]
  public function variable() {
    $this->assertTokens(
      [[T_VARIABLE, '$a', 1], [T_WHITESPACE, ' ', 1]],
      $this->tokensIn('<?php $a ?>')
    );
  }

  #[@test]
  public function int_literal() {
    $this->assertTokens(
      [[T_LNUMBER, '1', 1], [T_WHITESPACE, ' ', 1]],
      $this->tokensIn('<?php 1 ?>')
    );
  }

  #[@test]
  public function float_literal() {
    $this->assertTokens(
      [[T_DNUMBER, '1.1', 1], [T_WHITESPACE, ' ', 1]],
      $this->tokensIn('<?php 1.1 ?>')
    );
  }

  #[@test]
  public function bool_literal() {
    $this->assertTokens(
      [[T_STRING, 'true', 1], [T_WHITESPACE, ' ', 1]],
      $this->tokensIn('<?php true ?>')
    );
  }

  #[@test]
  public function dq_string_literal() {
    $this->assertTokens(
      [[T_CONSTANT_ENCAPSED_STRING, '"Hello"', 1], [T_WHITESPACE, ' ', 1]],
      $this->tokensIn('<?php "Hello" ?>')
    );
  }

  #[@test]
  public function sq_string_literal() {
    $this->assertTokens(
      [[T_CONSTANT_ENCAPSED_STRING, "'Hello'", 1], [T_WHITESPACE, ' ', 1]],
      $this->tokensIn("<?php 'Hello' ?>")
    );
  }

  #[@test]
  public function exec_literal() {
    $this->assertTokens(
      ['`', [T_ENCAPSED_AND_WHITESPACE, 'Hello', 1], '`', [T_WHITESPACE, ' ', 1]],
      $this->tokensIn('<?php `Hello` ?>')
    );
  }

  #[@test]
  public function empty_array_literal() {
    $this->assertTokens(
      [[T_ARRAY, 'array', 1], '(', ')', [T_WHITESPACE, ' ', 1]],
      $this->tokensIn('<?php array() ?>')
    );
  }

  #[@test]
  public function empty_array_bracket_literal() {
    $this->assertTokens(
      ['[', ']', [T_WHITESPACE, ' ', 1]],
      $this->tokensIn('<?php [] ?>')
    );
  }
}