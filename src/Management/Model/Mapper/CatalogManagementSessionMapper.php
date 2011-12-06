<?php
namespace SwmBase\Model\Mapper;
class CatalogManagementSessionMapper
{
    protected $userId;
    protected $entities;

    public function __construct($userId)
    {
        $this->userId = $userId;
        
        // test entities
        $shell = new \SwmBase\Entity\Shell('product');
        $product = new \SwmBase\Entity\Product;
        $option = new \SwmBase\Entity\Option('radio');
       
        $manufacturer = new \SwmBase\Entity\Company;
        $manufacturer->setCompanyId(69); 
        $product->setProductId(10)
                ->setManufacturer($manufacturer);
        $shell->setProduct($product);
        $choice = new \SwmBase\Entity\Choice;
        $choice->setChoiceId(12);
        $option->setOptionId(7)
               ->addChoice($choice)
               ->setSelectedChoice($choice);
        $shell->addOption($option);
        $this->entities = $this->deflateEntities(array($option, $shell, $product));
    }


    public function readSessionEntities()
    {
        return $this->unserializeEntities($this->entities);
    }

    public function unserializeEntities($rows)
    {
        $return = array();
        foreach ($rows as $row){
            $return[] = unserialize($row['entity']);
        }
        return $return;
    }

    public function deflateEntities($entities)
    {
        $return = array();
        foreach ($entities as $entity){
            $class = get_class($entity);
            $classArr = explode('\\', $class);
            $className = array_pop($classArr);

            //handle each type of class
            switch($className){
                case 'Shell' :
                    $entity = $this->shellDeflate($entity);
                    break;
                case 'Product' :
                    $entity = $this->productDeflate($entity);
                    break;
                case 'Option' :
                    $entity = $this->optionDeflate($entity);
                    break;
                default: 
                    die('didnt find that classname - '.$className);
                    break;
            }

            $return[] = Array(
                'user_id' => $this->userId,
                'entity' => serialize($entity),
                'classname' => $className
            );
        }
        return $return;
    }


    private function shellDeflate($shell)
    {
        if($shell->getType() === 'product'){
            $shell->setProductId($shell->getProduct()->getProductId());
            $shell->setProduct(null);
        }
        if(count($shell->getOptions()) > 0){
            $optionIds = Array();
            foreach($shell->getOptions() as $option){
                $optionIds[] = $option->getOptionId();
            }
            $shell->setOptionIds($optionIds);
            $shell->setOptions(null);
        }
        return $shell;
    }

    private function productDeflate($product)
    {
        $product->setCompanyId($product->getManufacturer()->getCompanyId());
        $product->setManufacturer(null);
        if(count($product->getUoms()) > 0){
            $uomIds = Array();
            foreach($product->getUoms() as $uom){
                $uomIds[] = $product->getUomId();
            }
            $product->setUomIds($uomIds);
            $product->setUoms(null);
        }
        return $product;
    }

    private function optionDeflate($option)
    {
        $option->setSelectedChoiceId($option->getSelectedchoice()->getChoiceId());
        $option->setSelectedChoice(null);
        if(count($option->getChoices()) > 0){
            $choiceIds = Array();
            foreach($option->getChoices() as $choice){
                $choiceIds[] = $choice->getChoiceId();
            }
            $option->setChoiceIds($choiceIds);
            $option->setChoices(null);
        }
        return $option;
    }
}
