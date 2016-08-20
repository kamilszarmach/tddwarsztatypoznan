<?php

namespace Tdd;

class StringCalculator
{
    const STANDARD_SEPARATOR = ",";
    const NEGATIVE_NOT_ALLOWED_MESSAGE = "Negatives not allowed";
    const TOO_BIG_NUMBER = 1000;
    const MULTIPLE_SEPARATOR_REGEXP = "/\\[(.+)\\]/U";

    public function add($input)
    {
        $numbers = $this->getNumbersFromString($input);
        $negativeNumbers = $this->getNegativeNumbersArray($numbers);
        if (count($negativeNumbers) > 0) {
            throw new \InvalidArgumentException(self::NEGATIVE_NOT_ALLOWED_MESSAGE . ": " . implode(",", $negativeNumbers));
        }
        return array_sum($numbers);
    }

    private function getNegativeNumbersArray($numbers)
    {
        $negativeNumbers = [];
        foreach ($numbers as $number) {
            if ($number < 0) {
                $negativeNumbers[] = $number;
            }
        }
        return $negativeNumbers;
    }

    private function getNumbersFromString($string)
    {
        $separators = array("\n", ",");
        $numbersString = $string;
        if (!empty($string) && strstr($string, "//")) {
            list($separators, $numbersString) = explode("\n", substr($string, 2));
            $separators = $this->getMultipleSeparators($separators);
        }
        return $this->splitNumbers($numbersString, $separators);

    }

    private function getMultipleSeparators($separatorString)
    {
        if (preg_match_all(self::MULTIPLE_SEPARATOR_REGEXP, $separatorString, $matches)) {
            return $matches[1];
        }
        return $separatorString;
    }

    private function splitNumbers($numbersString, $separators)
    {
        $input = str_replace($separators, self::STANDARD_SEPARATOR, $numbersString);
        $numbers = explode(self::STANDARD_SEPARATOR, $input);
        return $this->getPassNumbers($numbers);
    }

    private function getPassNumbers($numbers)
    {
        $passNumbers = [];
        foreach ($numbers as $number) {
            if ($number < self::TOO_BIG_NUMBER) {
                $passNumbers[] = $number;
            }
        }
        return $passNumbers;
    }
}
