<?php

namespace BlogLit\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
            ->add('author', TextType::class)
            ->add('content', TextareaType::class);
    }
    
    public function getName() {
        return 'comment';
    }
}