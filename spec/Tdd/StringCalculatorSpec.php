<?php

namespace spec\Tdd;

use Tdd\StringCalculator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StringCalculatorSpec extends ObjectBehavior
{
    const NEGATIVE_NOT_ALLOWED_MESSAGE = "Negatives not allowed";
    function it_is_initializable()
    {
        $this->shouldHaveType(StringCalculator::class);
    }

    function it_returns_0_for_empty()
    {
        $this->add("")->shouldReturn(0);
    }


    function it_returns_1_for_1()
    {
        $this->add("1")->shouldReturn(1);
    }

    function it_returns_3_for_1_and_2()
    {
        $this->add("1,2")->shouldReturn(3);
    }

    function it_returns_14_for_2_3_4_5()
    {
        $this->add("2,3,4,5")->shouldReturn(14);
    }

    function it_returns_6_with_new_line_for_1_2_3()
    {
        $this->add("1\n2,3")->shouldReturn(6);
    }

    function it_returns_3_with_separator_for_1_2()
    {
        $this->add("//;\n1;2")->shouldReturn(3);
    }

    function it_returns_exception_if_any_number_is_negative()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during("add", [-3]);
    }

    function it_returns_exception_with_set_string_and_numbers_if_any_number_is_negative()
    {
        $this->shouldThrow(new \InvalidArgumentException(self::NEGATIVE_NOT_ALLOWED_MESSAGE . ": -3"))->during("add", [-3]);
    }

    function it_returns_exception_with_set_string_and_numbers_if_any_number_is_negative_for_multiple_numbers()
    {
        $this->shouldThrow(new \InvalidArgumentException(self::NEGATIVE_NOT_ALLOWED_MESSAGE . ": -3,-5"))->during("add", ["-3,1,7,10,-5"]);
    }

    function it_returns_exception_with_set_string_and_numbers_if_any_number_is_negative_for_multiple_numbers_another_method()
    {
        $this->shouldThrow(new \InvalidArgumentException(self::NEGATIVE_NOT_ALLOWED_MESSAGE . ": -3,-5"))->duringAdd("-3,1,7,10,-5");
    }

    function it_returns_2_for_1000_and_2()
    {
        $this->add("1000,2")->shouldReturn(2);
    }

    function it_returns_6_with_long_separator_for_1_2_3()
    {
        $this->add("//***\n1***2***3")->shouldReturn(6);
    }

    function it_returns_6_with_multiple_separators_for_1_2_3()
    {
        $this->add("//[*][%]\n1*2%3")->shouldReturn(6);
    }

    function it_returns_6_with_multiple_long_separators_for_1_2_3()
    {
        $this->add("//[**][%]\n1**2%3")->shouldReturn(6);
    }
}
