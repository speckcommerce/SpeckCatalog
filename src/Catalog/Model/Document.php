<?php
namespace Catalog\Model;
class Document extends ModelAbstract
{
    protected $documentId;
    protected $label;
    protected $filename;
 
     
    public function __toString()
    {
        if($this->getLabel()){
            return $this->getLabel();
        }else{
            return '';
        }
    }

    public function getId()
    {
        return $this->getDocumentId();
    }

    /**
     * Get documentId.
     *
     * @return documentId
     */
    public function getDocumentId()
    {
        return $this->documentId;
    }
 
    /**
     * Set documentId.
     *
     * @param $documentId the value to be set
     */
    public function setDocumentId($documentId)
    {
        $this->documentId = $documentId;
        return $this;
    }
 
    /**
     * Get filename.
     *
     * @return filename
     */
    public function getFilename()
    {
        return $this->filename;
    }
 
    /**
     * Set filename.
     *
     * @param $filename the value to be set
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

 
    /**
     * Get label.
     *
     * @return label
     */
    public function getLabel()
    {
        return $this->label;
    }
 
    /**
     * Set label.
     *
     * @param $label the value to be set
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }
}
