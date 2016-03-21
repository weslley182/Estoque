<?php

namespace Estoque\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;


/** @ORM\Entity(repositoryClass="\Estoque\Entity\Repository\ProdutoRepository") */
class Produtos  implements  InputFilterAwareInterface{

 /**
    *@ORM\Id
    *@ORM\GeneratedValue(strategy="AUTO")
    *@ORM\Column(type="integer")
    */
    private $id;

/** @ORM\Column(type="string") */
    private $nome;

    /** @ORM\Column(type="decimal",scale=2) */
    private $preco;

    /**
     * @ORM\ManyToOne(targetEntity="Estoque\Entity\Categoria", inversedBy = “produtos”)
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id" , nullable = false)
     */
    private $categoria;

    /** @ORM\Column(type="string") */
    private $descricao;

    public function __construct($psNome, $pnPreco, $psDescricao){
    	$this->nome = $psNome;
    	$this->preco = $pnPreco;
    	$this->descricao = $psDescricao;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setNome($psNome) {
        $this->nome = $psNome;
    }

    public function setPreco($pnPreco) {
        $this->preco = $pnPreco;
    }

    public function setDescricao($psDesc) {
        $this->descricao = $psDesc;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function setCategoria(Categoria $categoria) {
        $this->categoria = $categoria;
    }

    public function setInputFilter(InputFilterInterface $inputFilter){
        throw new Exception('Voçê não deve invocar este metodo.');
    }

    public function getInputFilter(){
        $inputFilter = new InputFilter();
        $inputFilter->add([
            'name' => 'nome',
            'required' => true,
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 100
                    ]
                ]
            ]
        ]);
        return $inputFilter;

    }
}

?>