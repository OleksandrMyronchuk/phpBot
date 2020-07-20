<?php

namespace ZxcvbnPhp;
require_once 'Matchers/DictionaryMatch.php';
require_once 'Matchers/ReverseDictionaryMatch.php';
require_once 'Matchers/L33tMatch.php';
require_once 'Matchers/RepeatMatch.php';
require_once 'Matchers/SequenceMatch.php';
require_once 'Matchers/SpatialMatch.php';
require_once 'Matchers/YearMatch.php';
require_once 'Matchers/Bruteforce.php';
use ZxcvbnPhp\Matchers\Match;
use ZxcvbnPhp\Matchers\MatchInterface;

class Matcher
{
    private const DEFAULT_MATCHERS = [
        Matchers\DateMatch::class,
        Matchers\DictionaryMatch::class,
        Matchers\ReverseDictionaryMatch::class,
        Matchers\L33tMatch::class,
        Matchers\RepeatMatch::class,
        Matchers\SequenceMatch::class,
        Matchers\SpatialMatch::class,
        Matchers\YearMatch::class,
    ];

    private $additionalMatchers = [];

    /**
     * Get matches for a password.
     *
     * @see zxcvbn/src/matching.coffee::omnimatch
     *
     * @param string $password   Password string to match
     * @param array  $userInputs Array of values related to the user (optional)
     * @code array('Alice Smith')
     * @endcode
     *
     * @return Match[] Array of Match objects.
     */
    public function getMatches($password, array $userInputs = [])
    {
        $matches = [];
        foreach ($this->getMatchers() as $matcher) {
            $matched = $matcher::match($password, $userInputs);
            if (is_array($matched) && !empty($matched)) {
                $matches[] = $matched;
            }
        }

        $matches = array_merge([], ...$matches);
        self::usortStable($matches, [$this, 'compareMatches']);

        return $matches;
    }

    public function addMatcher(string $className)
    {
        if (!is_a($className, MatchInterface::class, true)) {
            throw new \InvalidArgumentException(sprintf('Matcher class must implement %s', MatchInterface::class));
        }

        $this->additionalMatchers[$className] = $className;

        return $this;
    }

    /**
     * A stable implementation of usort().
     *
     * Whether or not the sort() function in JavaScript is stable or not is implementation-defined.
     * This means it's impossible for us to match all browsers exactly, but since most browsers implement sort() using
     * a stable sorting algorithm, we'll get the highest rate of accuracy by using a stable sort in our code as well.
     *
     * This function taken from https://github.com/vanderlee/PHP-stable-sort-functions
     * Copyright © 2015-2018 Martijn van der Lee (http://martijn.vanderlee.com). MIT License applies.
     *
     * @param array $array
     * @param callable $value_compare_func
     * @return bool
     */
    public static function usortStable(array &$array, callable $value_compare_func)
    {
        $index = 0;
        foreach ($array as &$item) {
            $item = array($index++, $item);
        }
        $result = usort($array, function ($a, $b) use ($value_compare_func) {
            $result = $value_compare_func($a[1], $b[1]);
            return $result == 0 ? $a[0] - $b[0] : $result;
        });
        foreach ($array as &$item) {
            $item = $item[1];
        }
        return $result;
    }

    public static function compareMatches(Match $a, Match $b)
    {
        $beginDiff = $a->begin - $b->begin;
        if ($beginDiff) {
            return $beginDiff;
        }
        return $a->end - $b->end;
    }

    /**
     * Load available Match objects to match against a password.
     *
     * @return array Array of classes implementing MatchInterface
     */
    protected function getMatchers()
    {
        return array_merge(
            self::DEFAULT_MATCHERS,
            array_values($this->additionalMatchers)
        );
    }
}
