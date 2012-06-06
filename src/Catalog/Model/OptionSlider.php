<?php
namespace Catalog\Model;
class OptionSlider
{
    protected $start;
    protected $end;
    protected $incriment;
 
    /**
     * Get start.
     *
     * @return start
     */
    public function getStart()
    {
        return $this->start;
    }
 
    /**
     * Set start.
     *
     * lowest value on the slider
     *
     * @param $start the value to be set
     */
    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }
 
    /**
     * Get end.
     *
     * @return end
     */
    public function getEnd()
    {
        return $this->end;
    }
 
    /**
     * Set end.
     *
     * largest value on the slider
     *
     * @param $end the value to be set
     */
    public function setEnd($end)
    {
        $this->end = $end;
        return $this;
    }
 
    /**
     * Get incriment.
     *
     * @return incriment
     */
    public function getIncriment()
    {
        return $this->incriment;
    }
 
    /**
     * Set incriment.
     *
     * incriment value betweent start and end
     *
     * @param $incriment the value to be set
     */
    public function setIncriment($incriment)
    {
        $this->incriment = $incriment;
        return $this;
    }

    public function __toArray()
    {
        $return = array();
        for($position = $this->getStart(); $position <= $this->getEnd(); $position = $position+$this->getIncriment()){
            $return[] = $position;
        }
        return $return;
    }

}
