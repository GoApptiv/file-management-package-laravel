<?php

namespace GoApptiv\FileManagement\Models\FileManagement\Dto;

class FileManagementVariantLogData
{
    private $uuid;
    private $variantType;
    private $status;
    private $errors;
    private $variantId;
    private $dataString;
    
    /**
     *
     * @param string $uuid
     * @param string $variantType
     * @param string $status
     * @param string $errors
     * @param string $variantId
     * @param string $dataString
     *
     */
    public function __construct(
        string $uuid = null,
        string $variantType = null,
        string $status = null,
        string $errors = null,
        string $variantId = null,
        string $dataString = null
    ) {
        $this->uuid = $uuid;
        $this->variantType = $variantType;
        $this->status = $status;
        $this->errors = $errors;
        $this->variantId = $variantId;
        $this->dataString = $dataString;
    }

    /**
     *  JsonSerializable complete class
     *
     */
    public function toJSON()
    {
        return get_object_vars($this);
    }

    /**
     * Get the value of uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set the value of uuid
     *
     * @return  self
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get the value of variantType
     */
    public function getVariantType()
    {
        return $this->variantType;
    }

    /**
     * Set the value of variantType
     *
     * @return  self
     */
    public function setVariantType($variantType)
    {
        $this->variantType = $variantType;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set the value of errors
     *
     * @return  self
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Get the value of variantId
     */
    public function getVariantId()
    {
        return $this->variantId;
    }

    /**
     * Set the value of variantId
     *
     * @return  self
     */
    public function setVariantId($variantId)
    {
        $this->variantId = $variantId;

        return $this;
    }

    /**
     * Get the value of dataString
     */
    public function getDataString()
    {
        return $this->dataString;
    }

    /**
     * Set the value of dataString
     *
     * @return  self
     */
    public function setDataString($dataString)
    {
        $this->dataString = $dataString;

        return $this;
    }
}
