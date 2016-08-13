<?php

namespace spec\Tgallice\FBMessenger\Exception;

use PhpSpec\ObjectBehavior;

class ApiExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('error', 100, [
            'data' => 'value',
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Exception\ApiException');
    }

    function it_is_a_runtime_exception()
    {
        $this->shouldImplement(\RuntimeException::class);
    }

    function it_should_return_the_message()
    {
        $this->getMessage()->shouldReturn('error');
    }

    function it_should_return_the_error_data()
    {
        $this->getApiError()->shouldReturn([
            'data' => 'value',
        ]);
    }

    function it_should_return_the_error_code()
    {
        $this->getCode()->shouldReturn(100);
    }
}
