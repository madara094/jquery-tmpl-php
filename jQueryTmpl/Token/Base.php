<?php

abstract class jQueryTmpl_Token_Base implements jQueryTmpl_Token
{
    protected $_oTag = '{{';
    protected $_oTagLen = 2;
    protected $_cTag = '}}';
    protected $_cTagLen = 2;

    /**
     *  Validates that the string in question contains only one closing
     *  tag and opens with the required tag.
     */
    protected function _validateIsSingleTag($string, $startTag)
    {
        if (substr($string, 0, $this->_getStartTagLen($startTag)) !== $this->_oTag.$startTag)
        {
            throw new jQueryTmpl_Token_Exception("Tag must start with '$this->_oTag$startTag'.");
        }

        if (substr($string, -$this->_cTagLen) !== $this->_cTag)
        {
            throw new jQueryTmpl_Token_Exception("Tag must end with '$this->_cTag'.");
        }

        if (strpos($this->_getTagContent($string, $startTag), $this->_cTag) !== false)
        {
            throw new jQueryTmpl_Token_Exception("Tag can not contain multiple end tags '$this->_cTag'.");
        }
    }

    protected function _getTagContent($string, $startTag)
    {
        return trim
        (
            substr
            (
                $string,
                $this->_getStartTagLen($startTag),
                -$this->_cTagLen
            )
        );
    }

    private function _getStartTagLen($startTag)
    {
        return $this->_oTagLen + strlen($startTag);
    }
}

