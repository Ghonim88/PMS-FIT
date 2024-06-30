<?php
namespace Models;

class Blog 
{
  private $contentId;
  private $header;
  private $subHeader;
  private $text;
  private $imageName;

 
    public function __construct($contentId, $header, $subHeader, $text, $imageName)
    {
        $this->contentId = $contentId;
        $this->header = $header;
        $this->subHeader = $subHeader;
        $this->text = $text;
        $this->imageName = $imageName;
    }
    public function getContentId()
    {
        return $this->contentId;
    }   
    public function getHeader()
    {
        return $this->header;
    }
    public function getSubHeader()
    {
        return $this->subHeader;
    }
    public function getText()
    {
        return $this->text;
    }
    public function getImageName()
    {
        return $this->imageName;
    }
    public function setContentId($contentId)
    {
        $this->contentId = $contentId;
    }
    public function setHeader($header)
    {
        $this->header = $header;
    }
    public function setSubHeader($subHeader)
    {
        $this->subHeader = $subHeader;
    }
    public function setText($text)
    {
        $this->text = $text;
    }
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    public function toArray()
    {
      return [
        'contentId' => $this->contentId,
        'header' => $this->header,
        'subHeader' => $this->subHeader,
        'text' => $this->text,
        'imageName' => $this->imageName,
      ];
    }
  
}
///Users/abdelrahmanghonim/Documents/year2/Term3/Webdevelopment2/Final Assignment/PMS-Vue js/PMS-Fit
///Users/abdelrahmanghonim/Documents/year2/Term3/Webdevelopment2/Final Assignment/PMS-backend/app