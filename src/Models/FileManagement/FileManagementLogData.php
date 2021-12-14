<?php

namespace GoApptiv\FileManagement\Models\FileManagement;

class FileManagementLogData
{
    private $referenceNumber;
    private $templateCode;
    private $fileType;
    private $fileName;
    private $fileSizeInBytes;
    private $uuid;
    private $status;
    private $errors;

    /**
     *
     * @param string $referenceNumber
     * @param string $templateCode
     * @param string $fileType
     * @param string $fileName
     * @param int $fileSizeInBytes
     * @param string $uuid
     * @param string $status
     * @param string $errors
     *
     */
    public function __construct(
        string $referenceNumber = null,
        string $templateCode = null,
        string $fileType = null,
        string $fileName = null,
        int $fileSizeInBytes = null,
        string $uuid = null,
        string $status = null,
        string $errors = null
    ) {
        $this->referenceNumber = $referenceNumber;
        $this->templateCode = $templateCode;
        $this->fileType = $fileType;
        $this->fileName = $fileName;
        $this->fileSizeInBytes = $fileSizeInBytes;
        $this->uuid = $uuid;
        $this->status = $status;
        $this->errors = $errors;
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
     * Get the value of referenceNumber
     */
    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * Set the value of referenceNumber
     *
     * @return  self
     */
    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;

        return $this;
    }

    /**
     * Get the value of templateCode
     */
    public function getTemplateCode()
    {
        return $this->templateCode;
    }

    /**
     * Set the value of templateCode
     *
     * @return  self
     */
    public function setTemplateCode($templateCode)
    {
        $this->templateCode = $templateCode;

        return $this;
    }

    /**
     * Get the value of fileType
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * Set the value of fileType
     *
     * @return  self
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * Get the value of fileName
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set the value of fileName
     *
     * @return  self
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get the value of fileSizeInBytes
     */
    public function getFileSizeInBytes()
    {
        return $this->fileSizeInBytes;
    }

    /**
     * Set the value of getFileSizeInBytes
     *
     * @return  self
     */
    public function setFileSizeInBytes($fileSizeInBytes)
    {
        $this->fileSizeInBytes = $fileSizeInBytes;

        return $this;
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
}
