<?php

beforeEach(fn() => $this->translator = app('translator'));

describe('get()', function () {
    it(
        'returns the correct translation for the given key when it is defined',
        fn (string $key, string $expected) => expect($this->translator->get($key))->toBe($expected),
    )->with([
        // Sanity check. These should pass.
        "Regular: Non-falsy value" => ['mre.one', '1'],
        "Regular: Empty value" => ['mre.empty', ''],
        "Regular: The string '0'" => ['mre.zero', '0'],
        "JSON: Non-falsy value" => ['one', '1'],

        /**
         * Unexpected behavior. These will fail, because:
         * @see https://github.com/laravel/framework/blob/10.x/src/Illuminate/Translation/Translator.php#L179
         *
         * See the `bool:if(x)` column below:
         * @see https://www.php.net/manual/en/types.comparisons.php
         */
        "JSON: Empty value" => ['empty', ''],
        "JSON: The string '0'" => ['zero', '0'],
    ]);
});
