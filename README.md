Tokenize
========
Userland snapin for PHP's tokenizer extension. This comes in useful when running on a platform without `ext/tokenizer` installed.

Usage
-----
Require `src/PHP/Ext/Tokenizer.php`, e.g. by adding it to `auto_prepend_path`.

Testing
-------
Testing this requires the excellent [XP Framework](https://github.com/xp-framework/xp-framework). Use the command `unittest src` to run the test suite.