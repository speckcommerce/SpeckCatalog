<?php

namespace SpeckCatalog\View\Helper;

use Zend\View\Helper\HelperInterface;
use Zend\View\Helper\AbstractHelper;

class Functions extends AbstractHelper
{
    public function invoke()
    {
        return $this;
    }

    public function productClipDescription($product)
    {
        if ($product->has('features')) {
            $str = '<ul>';
            $features = $product->getFeatures();
            for ($i=0; $i < 3; $i++) {
                if ($features[$i]) {
                    $str .= '<li><span>&nbsp;' . $features[$i] . '</span></li>';
                }
            }
            return $str . '</ul>';
        } elseif ($product->getDescription()) {
            return '<p>' . $this->truncate($product->getDescription(), 200) . '</p>';
        }
    }

    public function truncate($text, $num, $etc = "...")
    {
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        if (strlen($text) > $num) {
            $text = substr($text, 0, $num);
            $text = substr($text, 0, strrpos($text, " "));

            $punctuation = ".!?:;,-"; //punctuation you want removed

            $text = (
                (strspn(strrev($text), $punctuation) != 0)
                ? substr($text, 0, -strspn(strrev($text), $punctuation))
                : $text . $etc
            );
        }
        return $text;
    }
}
