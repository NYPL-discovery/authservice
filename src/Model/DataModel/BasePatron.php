<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Services\Model\DataModel;
use NYPL\Starter\Model\ModelTrait\TranslateTrait;

abstract class BasePatron extends DataModel
{
    use TranslateTrait;

    /**
     * @SWG\Property(example="5852922")
     * @var string
     */
    public $id;


    /**
     * @SWG\Property()
     * @var string[]
     */
    public $names;

    /**
     * @SWG\Property()
     * @var string[]
     */
    public $barCodes = [];

    /**
     * @SWG\Property()
     * @var string[]
     */
    public $emails;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = (string) $id;
    }

    /**
     * @return \string[]
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * @param \string[] $names
     */
    public function setNames($names)
    {
        if (is_string($names)) {
            $names = json_decode($names, true);
        }

        $this->names = $names;
    }

    /**
     * @return \string[]
     */
    public function getBarCodes()
    {
        return $this->barCodes;
    }

    /**
     * @param \string[] $barCodes
     */
    public function setBarCodes($barCodes)
    {
        if (is_string($barCodes)) {
            $barCodes = json_decode($barCodes, true);
        }

        $this->barCodes = $barCodes;
    }

    /**
     * @return \string[]
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param \string[] $emails
     */
    public function setEmails($emails)
    {
        if (is_string($emails)) {
            $emails = json_decode($emails, true);
        }

        $this->emails = $emails;
    }
}
