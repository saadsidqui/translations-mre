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

describe('has()', function () {
    it(
        'returns true if the given translation key exists',
        fn (string $key, bool $expected) => expect($this->translator->has($key))->toBe($expected),
    )->with([
        // Sanity check. These should pass.
        "JSON: Key different than value" => ['one', true],
        "Regular: Key different than value" => ['mre.one', true],
        "JSON: Key same as value" => ['same', true],

        /**
         * Unexpected behavior. These will fail, because:
         * @see https://github.com/laravel/framework/blob/8154eb6e4b9673f332e2c26daf7730e409d443cc/src/Illuminate/Translation/Translator.php#L129
         */
        "Regular: Key same as value" => ['mre.same', true],
    ]);
});
