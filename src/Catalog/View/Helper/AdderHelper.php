<?php
namespace Catalog\View\Helper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;
use Catalog\Service\FormServiceAwareInterface;

class AdderHelper extends AbstractHelper
{
    public function __invoke($type, $className, $parent, $childName=null)
    {
        $data = array(
            'searchClassName' => $className,
            'className'       => $className,
            'newClassName'    => $className,
            'parentClassName' => lcfirst($parent->get('class_name')),
            'parentId'        => $parent->getRecordId(),
            'partialName'     => $className,
            'childId'         => null,
            'childClassName'  => $childName?:null
        );

        return $this->$type($data);
    }

    public function addButton($data)
    {
        extract($data);
        echo '
        <div class="span1 add-element">
            <form action="" class="add-partial">
                <input type="hidden" name="class_name"        value="' . $className . '" />
                <input type="hidden" name="new_class_name"    value="' . $newClassName . '" />
                <input type="hidden" name="parent_class_name" value="' . $parentClassName . '" />
                <input type="hidden" name="parent_id"         value="' . $parentId . '" />
                <input type="hidden" name="partial_name"      value="' . $partialName . '" />
                <input type="submit" class="btn" value="+"/>
            </form>
        </div>
        ';
    }
    public function importSearch($data)
    {
        extract($data);
        echo '
        <div class="span2 add-element">
            <form action="" class="import-search">
                <input type="hidden" name="class_name"        value="' . $className . '" />
                <input type="hidden" name="search_class_name" value="' . $searchClassName . '" />
                <input type="hidden" name="child_class_name"  value="' . $childClassName . '" />
                <input type="hidden" name="child_id"          value="' . $childId . '" />
                <input type="hidden" name="new_class_name"    value="' . $newClassName . '" />
                <input type="hidden" name="parent_class_name" value="' . $parentClassName . '" />
                <input type="hidden" name="parent_id"         value="' . $parentId . '" />
                <input type="hidden" name="partial_name"      value="' . $partialName . '" />
                <input type="text" name="value" class="span2" placeholder="import ' . $searchClassName . '" />
            </form>
        </div>
        ';
    }
    public function importFile($data)
    {
        extract($data);
        echo '
        <div class="span2 add-element">
            <form action="">
                <input class="input-file" type="file" placeholder="upload"/>
            </form>
        </div>
        ';
    }
}
