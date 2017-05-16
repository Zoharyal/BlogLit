<?php

namespace BlogLit\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
            ->add('author', TextType::class, array( 
                'attr' => array('class' => 'Authorhidden'),
                'label_attr' => array('class' => 'Authorlabel'),
            'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 1)))))
            ->add('content', TextareaType::class, array(  'label' => 'Contenu',
            'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 10)))));
    }
    
    public function getName() {
        return 'comment';
    }
}

//Regarder le français