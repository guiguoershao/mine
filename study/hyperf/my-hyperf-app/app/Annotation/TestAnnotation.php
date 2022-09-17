<?php


namespace App\Annotation;


use Hyperf\Di\Annotation\AbstractAnnotation;
use Hyperf\Di\Annotation\AnnotationInterface;

/**
 * Class TestAnnotation
 * @package App\Annotation
 * @Annotation
 * @Target({"METHOD","PROPERTY", "CLASS"})
 */
class TestAnnotation extends AbstractAnnotation implements AnnotationInterface
{

}