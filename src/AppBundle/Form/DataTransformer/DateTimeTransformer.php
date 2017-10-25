<?php
namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class DateTimeTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $datetime
     * @return mixed
     */
    public function transform($datetime)
    {
        if (!$datetime){
            return '';
        }
        return $datetime->format('Y-m-d');
    }

    /**
     * @param mixed $date
     * @return bool|\DateTime
     */
    public function reverseTransform($date)
    {
        if (!$date){
            return null;
        }
        return \DateTime::createFromFormat('Y-m-d', $date);
    }


}