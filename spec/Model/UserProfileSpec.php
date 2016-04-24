<?php

namespace spec\Tgallice\FBMessenger\Model;

use PhpSpec\ObjectBehavior;

class UserProfileSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('first_name', 'last_name', 'profile_pic');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\UserProfile');
    }

    function it_should_return_the_first_name()
    {
        $this->getFirstName()->shouldReturn('first_name');
    }

    function it_should_return_the_last_name()
    {
        $this->getLastName()->shouldReturn('last_name');
    }

    function it_should_return_the_profile_pic()
    {
        $this->getProfilePic()->shouldReturn('profile_pic');
    }
}
