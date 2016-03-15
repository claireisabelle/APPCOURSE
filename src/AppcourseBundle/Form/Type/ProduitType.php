<?php
namespace AppcourseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;


use Doctrine\ORM\EntityRepository;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('rayon', EntityType::class, array(
            	'class' => 'AppcourseBundle:Rayon',
            	'choice_label' => 'nom',
            	'expanded' => true,
            	'multiple' => false,
            	'query_builder' => function (EntityRepository $er)
            	{
            		return $er->createQueryBuilder('r')->orderBy('r.nom', 'ASC');
            	}
            	))
            ->add('save', SubmitType::class, array('label' => 'Valider le produit'))
        ;
    }

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
		'data_class' => 'AppcourseBundle\Entity\Produit'
		));
	}
}

