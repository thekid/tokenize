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
}