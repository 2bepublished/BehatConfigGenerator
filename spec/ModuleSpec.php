<?php

namespace spec\Pub\BehatConfigGenerator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ModuleSpec extends ObjectBehavior
{
    function it_can_be_created_with_a_name_paths_and_contexts()
    {
        $this->beConstructedWith('name', ['my-paths'], ['MyContext']);
        $this->shouldHaveType('Pub\BehatConfigGenerator\Module');

        $this->getName()->shouldBe('name');
        $this->getPaths()->shouldBe(['my-paths']);
        $this->getContexts()->shouldBe(['MyContext']);
    }
}
