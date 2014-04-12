<?php
namespace Bravo3\CloudCtrl\Reports\Traits;

/**
 * Object has an ETag
 */
trait EtagTrait
{
    /**
     * @var string
     */
    protected $etag;

    /**
     * Set Etag
     *
     * @param string $etag
     * @return $this
     */
    public function setEtag($etag)
    {
        $this->etag = $etag;
        return $this;
    }

    /**
     * Get Etag
     *
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }


} 