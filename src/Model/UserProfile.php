<?php

namespace Tgallice\FBMessenger\Model;

class UserProfile
{
    const FIRST_NAME = 'first_name';

    const LAST_NAME = 'last_name';

    const PROFILE_PIC = 'profile_pic';

    /**
     * @var null|string
     */
    private $firstName;
    /**
     * @var null|string
     */
    private $lastName;
    /**
     * @var null|string
     */
    private $profilePic;

    /**
     * @param null|string $firstName
     * @param null|string $lastName
     * @param null|string $profilePic
     */
    public function __construct($firstName = null, $lastName = null, $profilePic = null)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->profilePic = $profilePic;
    }

    /**
     * @return null|string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return null|string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return null|string
     */
    public function getProfilePic()
    {
        return $this->profilePic;
    }

    public static function create($data)
    {
        $data = array_merge([
            UserProfile::FIRST_NAME => null,
            UserProfile::LAST_NAME => null,
            UserProfile::PROFILE_PIC => null,
        ], $data);

        return new self(
            $data[UserProfile::FIRST_NAME],
            $data[UserProfile::LAST_NAME],
            $data[UserProfile::PROFILE_PIC]
        );
    }
}
