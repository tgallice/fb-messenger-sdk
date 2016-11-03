<?php

namespace spec\Tgallice\FBMessenger\Model;

use PhpSpec\ObjectBehavior;

class UserProfileSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([
            'first_name' => 'name',
            'last_name' => 'last name',
            'profile_pic' => 'pic',
            'gender' => 'male',
            'locale' => 'us_US',
            'timezone' => 1,
            'is_payment_enabled' => true
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\UserProfile');
    }

    function it_should_return_the_first_name()
    {
        $this->getFirstName()->shouldReturn('name');
    }

    function it_should_return_the_last_name()
    {
        $this->getLastName()->shouldReturn('last name');
    }

    function it_should_return_the_profile_pic()
    {
        $this->getProfilePic()->shouldReturn('pic');
    }

    function it_should_return_the_gender()
    {
        $this->getGender()->shouldReturn('male');
    }

    function it_should_return_the_locale()
    {
        $this->getLocale()->shouldReturn('us_US');
    }

    function it_should_return_the_timezone()
    {
        $this->getTimezone()->shouldReturn(1);
    }

    function it_should_return_is_payment_enabled()
    {
        $this->isPaymentEnabled()->shouldReturn(true);
    }
}
