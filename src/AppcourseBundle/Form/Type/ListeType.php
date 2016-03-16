<?php
namespace AppcourseBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;


use Doctrine\ORM\EntityRepository;

class ListeType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('commentaire', TextareaType::class)
            ->add('produits', EntityType::class, array(
            	'class' => 'AppcourseBundle:Produit',
            	'choice_label' => 'nom',
            	'expanded' => true,
            	'multiple' => true,
            	'required' => true,
            	'query_builder' => function (EntityRepository $er)
            	{
            		return $er
                        ->createQueryBuilder('p')
                        ->leftJoin('p.rayon', 'r')
                        ->addSelect('r')
                        ->addOrderBy('r.nom', 'ASC')
                        ->addOrderBy('p.nom', 'ASC');
            	}
            	))
            ->add('save', SubmitType::class, array('label' => 'Valider la liste'))
        ;
    }





	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
		'data_class' => 'AppcourseBundle\Entity\Liste'
		));
	}

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppcourseBundle\Entity\Liste'
        ));
    }
}

