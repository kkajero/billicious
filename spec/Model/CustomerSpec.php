<?php

namespace spec\Model;

use Model\Customer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CustomerSpec extends ObjectBehavior
{
    function let()
    {
        $id = 1;
        $name = 'Foo';
        $this->beConstructedWith($id, $name);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Customer::class);
    }

    function it_has_an_id()
    {
        $this->id()->shouldBeInteger();

    }

    function it_has_a_name()
    {
        $this->name()->shouldBeString();
    }
}
