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
    return new Bytes('['.substr($s, 2).']');
  }

  /**
   * Assertion helper
   *
   * @param  var[] $expected
   * @param  var[] $actual The list from the tokensIn() method
   * @throws unittest.AssertionFailedError
   */
  protected function assertTokens($expected, $actual, $l= 2) {
    array_unshift($expected, [T_OPEN_TAG, "<?php\n", 1]);
    $expected[]= [T_WHITESPACE, "\n", $l];
    $expected[]= [T_CLOSE_TAG, '?>', ++$l];
    $this->assertEquals($this->tokenString($expected), $this->tokenString($actual));
  }

  #[@test]
  public function opening_and_closing() {
    $this->assertTokens(
      [],
      $this->tokensIn('')
    );
  }

  #[@test]
  public function variable() {
    $this->assertTokens(
      [[T_VARIABLE, '$a', 2]],
      $this->tokensIn('$a')
    );
  }

  #[@test]
  public function int_literal() {
    $this->assertTokens(
      [[T_LNUMBER, '1', 2]],
      $this->tokensIn('1')
    );
  }

  #[@test]
  public function float_literal() {
    $this->assertTokens(
      [[T_DNUMBER, '1.1', 2]],
      $this->tokensIn('1.1')
    );
  }

  #[@test]
  public function bool_literal() {
    $this->assertTokens(
      [[T_STRING, 'true', 2]],
      $this->tokensIn('true')
    );
  }

  #[@test]
  public function dq_string_literal() {
    $this->assertTokens(
      [[T_CONSTANT_ENCAPSED_STRING, '"Hello"', 2]],
      $this->tokensIn('"Hello"')
    );
  }

  #[@test]
  public function sq_string_literal() {
    $this->assertTokens(
      [[T_CONSTANT_ENCAPSED_STRING, "'Hello'", 2]],
      $this->tokensIn("'Hello'")
    );
  }

  #[@test]
  public function exec_literal() {
    $this->assertTokens(
      ['`', [T_ENCAPSED_AND_WHITESPACE, 'Hello', 2], '`'],
      $this->tokensIn('`Hello`')
    );
  }

  #[@test]
  public function empty_array_literal() {
    $this->assertTokens(
      [[T_ARRAY, 'array', 2], '(', ')'],
      $this->tokensIn('array()')
    );
  }

  #[@test]
  public function empty_array_bracket_literal() {
    $this->assertTokens(
      ['[', ']'],
      $this->tokensIn('[]')
    );
  }

  #[@test]
  public function new_and_class_name() {
    $this->assertTokens(
      [[T_NEW, 'new', 2], [T_WHITESPACE, ' ', 2], [T_STRING, 'Object', 2], '(', ')'],
      $this->tokensIn('new Object()')
    );
  }

  #[@test]
  public function single_line_comment() {
    $this->assertTokens(
      [[T_COMMENT, "// Comment\n", 2]],
      $this->tokensIn("// Comment\n"),
      3
    );
  }

  #[@test]
  public function empty_single_line_comment() {
    $this->assertTokens(
      [[T_COMMENT, "//\n", 2]],
      $this->tokensIn("//\n"),
      3
    );
  }

  #[@test]
  public function multi_line_comment() {
    $this->assertTokens(
      [[T_COMMENT, '/* Comment */', 2]],
      $this->tokensIn('/* Comment */')
    );
  }

  #[@test]
  public function empty_multi_line_comment() {
    $this->assertTokens(
      [[T_COMMENT, '/**/', 2]],
      $this->tokensIn('/**/')
    );
  }

  #[@test]
  public function multi_line_comment_with_one_space() {
    $this->assertTokens(
      [[T_COMMENT, '/* */', 2]],
      $this->tokensIn('/* */')
    );
  }

  #[@test]
  public function multi_line_comment_with_one_star() {
    $this->assertTokens(
      [[T_COMMENT, '/* * */', 2]],
      $this->tokensIn('/* * */')
    );
  }

  #[@test]
  public function multi_line_comment_spanning_multiple_lines() {
    $this->assertTokens(
      [[T_COMMENT, "/* Comment\nContinued */", 2]],
      $this->tokensIn("/* Comment\nContinued */"),
      3
    );
  }

  #[@test]
  public function doc_comment() {
    $this->assertTokens(
      [[T_DOC_COMMENT, '/** @return */', 2]],
      $this->tokensIn('/** @return */')
    );
  }
}