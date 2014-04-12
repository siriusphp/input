<?php
namespace Sirius\FormsTest\Renderer\Widget;

use Sirius\Forms\Html\File;

class FileTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->input = new File(
            array(
                'name' => 'picture',
                'attrs' => array(
                    'class' => 'upload'
                )
            )
        );
    }

    function testRender()
    {
        $this->assertEquals('<input class="upload" name="picture" type="file">', (string)$this->input);
    }
}
