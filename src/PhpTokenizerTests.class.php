<?php
class PhpTokenizerTests extends TokenizerTests {

  /**
   * Returns tokens in a given source code
   *
   * @param  string $source
   * @return var[]
   */
  protected function tokensIn($source) {
    return token_get_all($source);
  }
}