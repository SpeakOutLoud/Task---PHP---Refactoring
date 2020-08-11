<?php

class FileUtilityManager
{
    private $_filename = '';

    public function __construct($filename)
    {
        $this->_filename = $filename;
    }

    function read_transaction_file()
    {
        if($this->_filename != null && file_exists($this->_filename))
        {
            return file_get_contents($this->_filename);
        }
        return "";
    }
}