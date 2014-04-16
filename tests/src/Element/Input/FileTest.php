<?php

namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input;

class FileTest extends \PHPUnit_Framework_TestCase
{

    function testDefaults()
    {
        $input = new File('option');

        $this->assertEquals('file', $input[Input::WIDGET]);
    }


    function testPrepareFormUploadHandling() {

    }

}
