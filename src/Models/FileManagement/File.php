<?php

namespace GoApptiv\FileManagement\Models\FileManagement;

class File
{
    private $type;
    private $name;
    private $sizeInBytes;

    /**
     *
     * @param string $type
     * @param string $name
     * @param int $sizeInBytes
     *
     */
    public function __construct(
        string $type,
        string $name,
        int $sizeInBytes
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->sizeInBytes = $sizeInBytes;
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
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of sizeInBytes
     */
    public function getSizeInBytes()
    {
        return $this->sizeInBytes;
    }

    /**
     * Set the value of sizeInBytes
     *
     * @return  self
     */
    public function setSizeInBytes($sizeInBytes)
    {
        $this->sizeInBytes = $sizeInBytes;

        return $this;
    }
}
