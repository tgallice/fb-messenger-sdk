<?php

namespace Tgallice\FBMessenger\Model;

use Tgallice\FBMessenger\Model\ThreadSetting\DomainWhitelisting;

class WhitelistedDomains
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    /**
     * @return array|null
     */
    public function getDomains()
    {
        return isset($this->data['data'][0][DomainWhitelisting::WHITELISTED_DOMAINS]) ?
        	$this->data['data'][0][DomainWhitelisting::WHITELISTED_DOMAINS] :
        	null;
    }
    
    /**
     * @param array $data
     *
     * @return WhitelistedDomains
     */
    public static function create(array $data)
    {
        return new self($data);
    }
}