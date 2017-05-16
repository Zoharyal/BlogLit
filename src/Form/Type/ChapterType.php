<?php
namespace BlogLit\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class ChapterType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Titre'))
            ->add('content', TextareaType::class, array('required' => false, 'label' => 'Contenu'));
    }
    public function getName()
    {
        return 'chapter';
    }
}