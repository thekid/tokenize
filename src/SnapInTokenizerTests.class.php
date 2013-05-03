<?php
class SnapInTokenizerTests extends TokenizerTests {

  /**
   * Returns tokens in a given source code
   *
   * @param  string $source
   * @return var[]
   */
  protected function tokensIn($source) {
    return PHP\Ext\Tokenizer::tokensIn("<?php\n".$source."\n?>");
  }

  /**
   * Creates a list of all tokens for the name() test
   */
  public function tokens() {
    $result= [];
    foreach (PHP\Ext\Tokenizer::$tokens as $token => $name) {
      $result[]= [$name, $token];
    }
    return $result;
  }

  #[@test, @values('tokens')]
  public function name($name, $token) {
    $this->assertEquals($name, PHP\Ext\Tokenizer::nameOf($token));
  }

  /**
   * Creates a list of all tokens for the name() test
   */
  public function keywords() {
    $result= [];
    foreach (PHP\Ext\Tokenizer::$keywords as $string => $token) {
      $result[]= [$string, $token];
    }
    return $result;
  }

  #[@test, @values('keywords')]
  public function keyword($keyword, $token) {
    $this->assertTokens(
      [[$token, $keyword, 2]],
      $this->tokensIn($keyword)
    );
  }
}