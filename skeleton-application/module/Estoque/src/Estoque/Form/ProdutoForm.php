<?php

namespace Estoque\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\ElementInterface;
use Zend\Form\Form;
use Zend\Form\Element;

class ProdutoForm extends Form{

	public function __construct(ObjectManager $entityManager){

		parent:: __construct('FormProduto');

		$this->add([
			'type' => 'Text',
			'name' => 'nome',
			'attributes' => [
				'class' => 'form-control'
			]
		]);

		$this->add([
			'type' => 'number',
			'name' => 'preco',
			'attributes' => [
				'class' => 'form-control'
			]
		]);

		$this->add([
			'type' => 'Textarea',
			'name' => 'descricao',
			'attributes' => [
				'class' => 'form-control'
			]
		]);

		$this->add(new Element\Csrf('csrf'));

		$this->add(array(
			'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
			'name'    => 'categoria',
			'attributes' => ['class' => 'form­control'],
			'options' => array(
				'object_manager' => $this->entityManager,
				'target_class'   => 'Estoque\Entity\Categoria',
				'property'       => 'nome',
				'empty_option'   => 'selecione uma categoria'
			),

		));

	}

	/**
	 * Set a single option for an element
	 *
	 * @param  string $key
	 * @param  mixed $value
	 * @return self
	 */
	public function setOption($key, $value)
	{
		// TODO: Implement setOption() method.
	}
}

?>