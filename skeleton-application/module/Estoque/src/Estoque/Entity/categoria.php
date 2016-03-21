<?php
/**
 * Created by PhpStorm.
 * User: Wesley
 * Date: 19-Mar-16
 * Time: 10:28
 */

namespace Estoque\Entity;

use Doctrine\ORM\Mapping as ORM;

/** ORM\Entity */
class Categoria {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\Column(type="string") */
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity=”\Estoque\Entity\Produtos” , mappedBy = “categoria”)
     */
    private $produtos;

    public function __construct($id,$nome) {

        $this->id = $id;
        $this->nome = $nome;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

}

?>



