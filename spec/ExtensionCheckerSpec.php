<?php

namespace spec\Tgallice\FBMessenger;

use PhpSpec\ObjectBehavior;

class ExtensionCheckerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\ExtensionChecker');
    }

    function it_check_extension()
    {
        $this::check('file.png', array('png', 'jpg'))->shouldReturn(true);
        $this::check('http://file.com/file.png', array('png', 'jpg'))->shouldReturn(true);
        $this::check('http://file.com/file.ext', array('png', 'jpg'))->shouldReturn(false);
    }
}
