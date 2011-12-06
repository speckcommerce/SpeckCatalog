<?php
namespace SwmBaseTest\Entity;
use PHPUnit_Framework_TestCase,
    SwmBase\Entity\Option,
    SwmBase\Entity\Choice,
    InvalidArgumentException,
    RuntimeException;

class OptionTest extends PHPUnit_Framework_TestCase     
{
    
    public function testNoListTypeAtConstructThrowsException()
    {
        $this->setExpectedException('RuntimeException');
        $option = new Option;
    }

    public function testAllValidListTypesAtConstruct()
    {
        $option = new Option('radio');
        $this->assertSame('radio',$option->getListType());
        $option = new Option('dropdown');
        $this->assertSame('dropdown',$option->getListType());
        $option = new Option('checkbox');
        $this->assertSame('checkbox',$option->getListType());
    }                            
    
    public function testSetRequiredWhenTypeNotRadioThrowsException()
    {
        $this->setExpectedException('RuntimeException');
        $option = new Option('checkbox');
        $option->setRequired(true);
    }

    public function testSetSelectedChoiceWhenTypeNotRadioThrowsException()
    {
        $this->setExpectedException('RuntimeException');
        $option = new Option('checkbox');
        $option->setSelectedChoice(new Choice);
    }
    
    public function testInvalidListTypeThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $option = new Option('asdf');
    }

    public function testSetRequiredWithNonBooleanThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $option = new Option('radio');
        $option->setRequired('sometimes');
    }

    public function testScalarSettersAndGetters()
    {
        $option = new Option('radio');
        $option->setOptionId(10)
               ->setName('somename');

        $this->assertSame(10, $option->getOptionId());
        $this->assertSame('somename', $option->getName());
        $this->assertSame('radio', $option->getListType());
    }
    
    public function testObjectSettersAndGetters()
    {
        $option = new Option('radio');
        $choice = new Choice;
        $option->setChoices(array($choice))
               ->addChoice($choice)
               ->setInstruction('do this!')
               ->setRequired(true)
               ->setSelectedChoice($choice);

        $returnedChoices = $option->getChoices();
        $this->assertSame(2,count($returnedChoices));
        $this->assertSame($choice,$returnedChoices[0]); 
        $this->assertSame($choice,$option->getSelectedChoice()); 
        $this->assertSame(true,$option->getRequired()); 
        $this->assertSame('do this!',$option->getInstruction()); 
    }
    
}
