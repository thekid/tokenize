<?php namespace PHP\Ext;

class Tokenizer {
  public static $tokens= array(
    261 => 'T_REQUIRE_ONCE',
    260 => 'T_REQUIRE',
    259 => 'T_EVAL',
    258 => 'T_INCLUDE_ONCE',
    257 => 'T_INCLUDE',
    262 => 'T_LOGICAL_OR',
    263 => 'T_LOGICAL_XOR',
    264 => 'T_LOGICAL_AND',
    265 => 'T_PRINT',
    276 => 'T_SR_EQUAL',
    275 => 'T_SL_EQUAL',
    274 => 'T_XOR_EQUAL',
    273 => 'T_OR_EQUAL',
    272 => 'T_AND_EQUAL',
    271 => 'T_MOD_EQUAL',
    270 => 'T_CONCAT_EQUAL',
    269 => 'T_DIV_EQUAL',
    268 => 'T_MUL_EQUAL',
    267 => 'T_MINUS_EQUAL',
    266 => 'T_PLUS_EQUAL',
    277 => 'T_BOOLEAN_OR',
    278 => 'T_BOOLEAN_AND',
    282 => 'T_IS_NOT_IDENTICAL',
    281 => 'T_IS_IDENTICAL',
    280 => 'T_IS_NOT_EQUAL',
    279 => 'T_IS_EQUAL',
    284 => 'T_IS_GREATER_OR_EQUAL',
    283 => 'T_IS_SMALLER_OR_EQUAL',
    286 => 'T_SR',
    285 => 'T_SL',
    287 => 'T_INSTANCEOF',
    296 => 'T_UNSET_CAST',
    295 => 'T_BOOL_CAST',
    294 => 'T_OBJECT_CAST',
    293 => 'T_ARRAY_CAST',
    292 => 'T_STRING_CAST',
    291 => 'T_DOUBLE_CAST',
    290 => 'T_INT_CAST',
    289 => 'T_DEC',
    288 => 'T_INC',
    298 => 'T_CLONE',
    297 => 'T_NEW',
    299 => 'T_EXIT',
    300 => 'T_IF',
    301 => 'T_ELSEIF',
    302 => 'T_ELSE',
    303 => 'T_ENDIF',
    304 => 'T_LNUMBER',
    305 => 'T_DNUMBER',
    306 => 'T_STRING',
    307 => 'T_STRING_VARNAME',
    308 => 'T_VARIABLE',
    309 => 'T_NUM_STRING',
    310 => 'T_INLINE_HTML',
    311 => 'T_CHARACTER',
    312 => 'T_BAD_CHARACTER',
    313 => 'T_ENCAPSED_AND_WHITESPACE',
    314 => 'T_CONSTANT_ENCAPSED_STRING',
    315 => 'T_ECHO',
    316 => 'T_DO',
    317 => 'T_WHILE',
    318 => 'T_ENDWHILE',
    319 => 'T_FOR',
    320 => 'T_ENDFOR',
    321 => 'T_FOREACH',
    322 => 'T_ENDFOREACH',
    323 => 'T_DECLARE',
    324 => 'T_ENDDECLARE',
    325 => 'T_AS',
    326 => 'T_SWITCH',
    327 => 'T_ENDSWITCH',
    328 => 'T_CASE',
    329 => 'T_DEFAULT',
    330 => 'T_BREAK',
    331 => 'T_CONTINUE',
    332 => 'T_GOTO',
    333 => 'T_FUNCTION',
    334 => 'T_CONST',
    335 => 'T_RETURN',
    336 => 'T_TRY',
    337 => 'T_CATCH',
    338 => 'T_THROW',
    339 => 'T_USE',
    340 => 'T_GLOBAL',
    346 => 'T_PUBLIC',
    345 => 'T_PROTECTED',
    344 => 'T_PRIVATE',
    343 => 'T_FINAL',
    342 => 'T_ABSTRACT',
    341 => 'T_STATIC',
    347 => 'T_VAR',
    348 => 'T_UNSET',
    349 => 'T_ISSET',
    350 => 'T_EMPTY',
    351 => 'T_HALT_COMPILER',
    352 => 'T_CLASS',
    353 => 'T_INTERFACE',
    354 => 'T_EXTENDS',
    355 => 'T_IMPLEMENTS',
    356 => 'T_OBJECT_OPERATOR',
    357 => 'T_DOUBLE_ARROW',
    358 => 'T_LIST',
    359 => 'T_ARRAY',
    360 => 'T_CLASS_C',
    361 => 'T_METHOD_C',
    362 => 'T_FUNC_C',
    363 => 'T_LINE',
    364 => 'T_FILE',
    365 => 'T_COMMENT',
    366 => 'T_DOC_COMMENT',
    367 => 'T_OPEN_TAG',
    368 => 'T_OPEN_TAG_WITH_ECHO',
    369 => 'T_CLOSE_TAG',
    370 => 'T_WHITESPACE',
    371 => 'T_START_HEREDOC',
    372 => 'T_END_HEREDOC',
    373 => 'T_DOLLAR_OPEN_CURLY_BRACES',
    374 => 'T_CURLY_OPEN',
    375 => 'T_PAAMAYIM_NEKUDOTAYIM',
    376 => 'T_NAMESPACE',
    377 => 'T_NS_C',
    378 => 'T_DIR',
    379 => 'T_NS_SEPARATOR'
  );


  /**
   * Returns the name of a given token
   *
   * @param  int $token The token number
   * @return string The name
   */
  public static function nameOf($token) {
    return self::$tokens[$token];
  }

  /**
   * Tokenizes the sourcecode
   *
   * @param  string $source The source code to tokenize
   * @return array The tokens
   */
  public static function tokensIn($source) {
    static $delimiters= " ^|&?!.:;,@%~=<>(){}[]#+-*/\"'\r\n\t\$`\\";
    static $tokens= array(
      '<' => array('<?php ' => T_OPEN_TAG, "<?php\n" => T_OPEN_TAG, '<?=' => T_OPEN_TAG_WITH_ECHO, '<<=' => T_SL_EQUAL, '<<' => T_SL, '<=' => T_IS_SMALLER_OR_EQUAL, '<>' => T_IS_NOT_EQUAL),
      '>' => array('>>=' => T_SR_EQUAL, '>>' => T_SR, '>=' => T_IS_GREATER_OR_EQUAL),
      '?' => array('?>' => T_CLOSE_TAG),
      '+' => array('+=' => T_PLUS_EQUAL, '++' => T_INC),
      '-' => array('-=' => T_MINUS_EQUAL, '--' => T_DEC, '->' => T_OBJECT_OPERATOR),
      '*' => array('*=' => T_MUL_EQUAL),
      '/' => array('/=' => T_DIV_EQUAL),
      '=' => array('===' => T_IS_IDENTICAL, '==' => T_IS_EQUAL, '=>' => T_DOUBLE_ARROW),
      '!' => array('!==' => T_IS_NOT_IDENTICAL, '==' => T_IS_NOT_EQUAL),
      '|' => array('|=' => T_OR_EQUAL, '||' => T_BOOLEAN_OR),
      '^' => array('^=' => T_XOR_EQUAL),
      '%' => array('%=' => T_MOD_EQUAL),
      '&' => array('&=' => T_AND_EQUAL, '&&' => T_BOOLEAN_AND),
      ':' => array('::' => T_PAAMAYIM_NEKUDOTAYIM),
      '.' => array('.=' => T_CONCAT_EQUAL),
      '\\' => array('\\' => T_NS_SEPARATOR),
      '(' => array(
        '(int)'     => T_INT_CAST,
        '(string)'  => T_STRING_CAST,
        '(array)'   => T_ARRAY_CAST,
        '(object)'  => T_OBJECT_CAST,
        '(bool)'    => T_BOOL_CAST,
        '(double)'  => T_DOUBLE_CAST,
        '(unset)'   => T_UNSET_CAST
      )
    );
    static $keywords= array(
      'abstract' => T_ABSTRACT,
      'array' => T_ARRAY,
      'as' => T_AS,
      'break' => T_BREAK,
      'case' => T_CASE,
      'catch' => T_CATCH,
      'class' => T_CLASS,
      '__CLASS__' => T_CLASS_C,
      'clone' => T_CLONE,
      'const' => T_CONST,
      'continue' => T_CONTINUE,
      'declare' => T_DECLARE,
      'default' => T_DEFAULT,
      '__DIR__' => T_DIR,
      'die' => T_EXIT,
      'do' => T_DO,
      'echo' => T_ECHO,
      'else' => T_ELSE,
      'elseif' => T_ELSEIF,
      'empty' => T_EMPTY,
      'enddeclare' => T_ENDDECLARE,
      'endfor' => T_ENDFOR,
      'endforeach' => T_ENDFOREACH,
      'endif' => T_ENDIF,
      'endswitch' => T_ENDSWITCH,
      'endwhile' => T_ENDWHILE,
      'eval' => T_EVAL,
      'exit' => T_EXIT,
      'extends' => T_EXTENDS,
      '__FILE__' => T_FILE,
      'final' => T_FINAL,
      'for' => T_FOR,
      'foreach' => T_FOREACH,
      'function' => T_FUNCTION,
      '__FUNCTION__' => T_FUNC_C,
      'global' => T_GLOBAL,
      'goto' => T_GOTO,
      '__halt_compiler' => T_HALT_COMPILER,
      'if' => T_IF,
      'implements' => T_IMPLEMENTS,
      'include' => T_INCLUDE,
      'include_once' => T_INCLUDE_ONCE,
      'instanceof' => T_INSTANCEOF,
      'interface' => T_INTERFACE,
      'isset' => T_ISSET,
      '__LINE__' => T_LINE,
      'list' => T_LIST,
      'and' => T_LOGICAL_AND,
      'or' => T_LOGICAL_OR,
      'xor' => T_LOGICAL_XOR,
      '__METHOD__' => T_METHOD_C,
      'namespace' => T_NAMESPACE,
      '__NAMESPACE__' => T_NS_C,
      'new' => T_NEW,
      'print' => T_PRINT,
      'private' => T_PRIVATE,
      'public' => T_PUBLIC,
      'protected' => T_PROTECTED,
      'require' => T_REQUIRE,
      'require_once' => T_REQUIRE_ONCE,
      'return' => T_RETURN,
      'static' => T_STATIC,
      'switch' => T_SWITCH,
      'throw' => T_THROW,
      'try' => T_TRY,
      'unset' => T_UNSET,
      'use' => T_USE,
      'var' => T_VAR,
      'while' => T_WHILE
    );

    $result= array();
    $o= 0; $l= strlen($source);
    $n= 1;
    do {
      $t= strcspn($source, $delimiters, $o);
      if (0 === $t) {
        $word= NULL;
        $token= $source{$o};
      } else {
        $word= substr($source, $o, $t);
        $token= $source{$o + $t};
      }
      //echo "o = $o, t = $t, word = $word, token = "; var_dump($token);

      if (NULL !== $word) {
        if (isset($keywords[$word])) {
          $result[]= array($keywords[$word], $word, $n);
        } else if (is_numeric($word)) {
          if ('.' === $token) {
            $o+= $t + 1;
            $t= strcspn($source, $delimiters, $o);
            $word.= $token.substr($source, $o, $t);
            $token= $source{$o + $t};
            $result[]= array(T_DNUMBER, $word, $n);
          } else {
            $result[]= array(T_LNUMBER, $word, $n);
          }
        } else {
          $result[]= array(T_STRING, $word, $n);
        }
      }

      // Whitespace
      if (FALSE !== strpos(" \n\r\t", $token)) {
        $o+= $t + 1;
        $result[]= array(T_WHITESPACE, $token, $n);
        $n+= substr_count($token, "\n");
        continue;
      }

      // Strings
      if ('"' === $token || "'" === $token) {
        $s= $o + $t;
        $e= strcspn($source, $token, $s + 1);
        $result[]= array(T_CONSTANT_ENCAPSED_STRING, substr($source, $s, $e + 2), $n);
        $o+= $e + 2;
        continue;
      }

      // Comments
      if ('/' === $token) {
        $s= $o + $t;
        if ('/' === $source{$s + 1}) {
          $e= strcspn($source, "\n", $s + 1);
          $result[]= array(T_COMMENT, substr($source, $s, $e + 2), $n);
          $n++;
          $o+= $e + 2;
          continue;
        }
      }

      // Exec
      if ('`' === $token) {
        $s= $o + $t;
        $e= strcspn($source, $token, $s + 1);
        $result[]= $token;
        $result[]= array(T_ENCAPSED_AND_WHITESPACE, substr($source, $s + 1, $e), $n);
        $result[]= $token;
        $o+= $e + 2;
        continue;
      }

      // Variables
      if ('$' === $token) {
        $s= $o + $t;
        $e= strcspn($source, $delimiters, $s + 1);
        $result[]= array(T_VARIABLE, substr($source, $s, $e + 1), $n);
        $o+= $e + 1;
        continue;
      }

      if (isset($tokens[$token])) {
        $s= $o + $t;
        $found= NULL;
        foreach ($tokens[$token] as $variant => $id) {
          $v= strlen($variant);
          if (0 === substr_compare($source, $variant, $s, $v)) {
            $found= $id;
            break;
          }
        }
        if ($found) {
          $token= substr($source, $s, $v);
          $result[]= array($found, $token, $n);
          $n+= substr_count($token, "\n");
          $t+= $v - 1;
        } else {
          $result[]= $token;
        }
      } else {
        $result[]= $token;
      }
      $o+= $t + 1;
    } while ($o < $l);
    return $result;
  }
}

// Check whether we should act as a snap-in replacement
if (!function_exists('token_get_all')) {
  define('T_REQUIRE_ONCE', 261);
  define('T_REQUIRE', 260);
  define('T_EVAL', 259);
  define('T_INCLUDE_ONCE', 258);
  define('T_INCLUDE', 257);
  define('T_LOGICAL_OR', 262);
  define('T_LOGICAL_XOR', 263);
  define('T_LOGICAL_AND', 264);
  define('T_PRINT', 265);
  define('T_SR_EQUAL', 276);
  define('T_SL_EQUAL', 275);
  define('T_XOR_EQUAL', 274);
  define('T_OR_EQUAL', 273);
  define('T_AND_EQUAL', 272);
  define('T_MOD_EQUAL', 271);
  define('T_CONCAT_EQUAL', 270);
  define('T_DIV_EQUAL', 269);
  define('T_MUL_EQUAL', 268);
  define('T_MINUS_EQUAL', 267);
  define('T_PLUS_EQUAL', 266);
  define('T_BOOLEAN_OR', 277);
  define('T_BOOLEAN_AND', 278);
  define('T_IS_NOT_IDENTICAL', 282);
  define('T_IS_IDENTICAL', 281);
  define('T_IS_NOT_EQUAL', 280);
  define('T_IS_EQUAL', 279);
  define('T_IS_GREATER_OR_EQUAL', 284);
  define('T_IS_SMALLER_OR_EQUAL', 283);
  define('T_SR', 286);
  define('T_SL', 285);
  define('T_INSTANCEOF', 287);
  define('T_UNSET_CAST', 296);
  define('T_BOOL_CAST', 295);
  define('T_OBJECT_CAST', 294);
  define('T_ARRAY_CAST', 293);
  define('T_STRING_CAST', 292);
  define('T_DOUBLE_CAST', 291);
  define('T_INT_CAST', 290);
  define('T_DEC', 289);
  define('T_INC', 288);
  define('T_CLONE', 298);
  define('T_NEW', 297);
  define('T_EXIT', 299);
  define('T_IF', 300);
  define('T_ELSEIF', 301);
  define('T_ELSE', 302);
  define('T_ENDIF', 303);
  define('T_LNUMBER', 304);
  define('T_DNUMBER', 305);
  define('T_STRING', 306);
  define('T_STRING_VARNAME', 307);
  define('T_VARIABLE', 308);
  define('T_NUM_STRING', 309);
  define('T_INLINE_HTML', 310);
  define('T_CHARACTER', 311);
  define('T_BAD_CHARACTER', 312);
  define('T_ENCAPSED_AND_WHITESPACE', 313);
  define('T_CONSTANT_ENCAPSED_STRING', 314);
  define('T_ECHO', 315);
  define('T_DO', 316);
  define('T_WHILE', 317);
  define('T_ENDWHILE', 318);
  define('T_FOR', 319);
  define('T_ENDFOR', 320);
  define('T_FOREACH', 321);
  define('T_ENDFOREACH', 322);
  define('T_DECLARE', 323);
  define('T_ENDDECLARE', 324);
  define('T_AS', 325);
  define('T_SWITCH', 326);
  define('T_ENDSWITCH', 327);
  define('T_CASE', 328);
  define('T_DEFAULT', 329);
  define('T_BREAK', 330);
  define('T_CONTINUE', 331);
  define('T_GOTO', 332);
  define('T_FUNCTION', 333);
  define('T_CONST', 334);
  define('T_RETURN', 335);
  define('T_TRY', 336);
  define('T_CATCH', 337);
  define('T_THROW', 338);
  define('T_USE', 339);
  define('T_GLOBAL', 340);
  define('T_PUBLIC', 346);
  define('T_PROTECTED', 345);
  define('T_PRIVATE', 344);
  define('T_FINAL', 343);
  define('T_ABSTRACT', 342);
  define('T_STATIC', 341);
  define('T_VAR', 347);
  define('T_UNSET', 348);
  define('T_ISSET', 349);
  define('T_EMPTY', 350);
  define('T_HALT_COMPILER', 351);
  define('T_CLASS', 352);
  define('T_INTERFACE', 353);
  define('T_EXTENDS', 354);
  define('T_IMPLEMENTS', 355);
  define('T_OBJECT_OPERATOR', 356);
  define('T_DOUBLE_ARROW', 357);
  define('T_LIST', 358);
  define('T_ARRAY', 359);
  define('T_CLASS_C', 360);
  define('T_METHOD_C', 361);
  define('T_FUNC_C', 362);
  define('T_LINE', 363);
  define('T_FILE', 364);
  define('T_COMMENT', 365);
  define('T_DOC_COMMENT', 366);
  define('T_OPEN_TAG', 367);
  define('T_OPEN_TAG_WITH_ECHO', 368);
  define('T_CLOSE_TAG', 369);
  define('T_WHITESPACE', 370);
  define('T_START_HEREDOC', 371);
  define('T_END_HEREDOC', 372);
  define('T_DOLLAR_OPEN_CURLY_BRACES', 373);
  define('T_CURLY_OPEN', 374);
  define('T_PAAMAYIM_NEKUDOTAYIM', 375);
  define('T_NAMESPACE', 376);
  define('T_NS_C', 377);
  define('T_DIR', 378);
  define('T_NS_SEPARATOR', 379);

  function token_get_all($source) { return Tokenizer::tokensIn($source); }
  function token_name($token) { return Tokenizer::nameOf($token); }
}
