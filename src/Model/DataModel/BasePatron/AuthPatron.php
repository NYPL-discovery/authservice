<?php
namespace NYPL\Services\Model\DataModel\BasePatron;

use NYPL\Services\Model\DataModel\BasePatron;
use NYPL\Starter\Model\ModelInterface\ReadInterface;
use NYPL\Starter\Model\ModelTrait\SierraTrait\SierraReadTrait;

/**
 * @SWG\Definition(title="AuthPatron", type="object", required={"id"})
 */
class AuthPatron extends BasePatron implements ReadInterface
{
    const FIELDS = "id,names,barcodes,emails";

    use SierraReadTrait;

    /**
     * @return int
     */
    public function getTimeoutSeconds()
    {
        return 3;
    }

    /**
     * @param string|null $id
     *
     * @return string
     */
    public function getSierraPath($id = null)
    {
        return "patrons/{$this->getSierraId($id)}?" . http_build_query(["fields" => self::FIELDS]);
    }

    public function getIdFields()
    {
        return ["id"];
    }
}
