<?php


trait addANDdisplay
{
    public function display($class_name, $evidence)
    {
        foreach ($evidence as $object)
        {
            if($object instanceof ($class_name))
            {
                echo "<pre>";
                print_r($object);
                echo "</pre>";
            }
        }
    }

}

?>