<?php

namespace spec\Tgallice\FBMessenger\Model\ThreadSetting;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\ThreadSetting;

class DomainWhitelistingSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['https://google.com']);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\ThreadSetting\DomainWhitelisting');
    }
    
    function it_has_a_domains()
    {
        $this->getDomains()->shouldReturn(['https://google.com']);
    }
    
    function it_has_a_add_action()
    {
        $this->getAction()->shouldReturn('add');
    }
    
    function it_has_a_remove_action()
    {
        $this->beConstructedWith(['https://google.com'], 'remove');
        
        $this->getAction()->shouldReturn('remove');
    }
    
    function it_throws_exception_when_is_not_add_or_remove_action()
    {
        $this->beConstructedWith(['https://google.com'], 'update');
    
        $this
            ->shouldThrow(new \InvalidArgumentException('The action must be type: "add" or "remove".'))
            ->duringInstantiation();
    }
    
    function it_throws_exception_when_domains_is_not_a_array()
    {
        $this->beConstructedWith('not array');
    
        $this
            ->shouldThrow(new \InvalidArgumentException('Domains must be a array.'))
            ->duringInstantiation();
    }
    
    function it_throws_exception_when_one_domains_has_not_a_https_protocol()
    {
        $this->beConstructedWith([
            'https://petersfancyapparel.com',
            'http://google.com',
            'https://www.google.com'
        ], 'add');
    
        $this
            ->shouldThrow(new \InvalidArgumentException('Each domain must be a "https" protocol.'))
            ->duringInstantiation();
    }
    
    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);
    
        $expected = [
            'whitelisted_domains' => ['https://google.com'],
            'domain_action_type' => 'add'
        ];
    
        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
