<?php 
namespace Estoque\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ProdutoRepository extends EntityRepository {

    public function getProdutosPaginados($offset = 0, $limit = 10) {

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('p')
            ->from('Estoque\Entity\Produtos', 'p')            
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('p.id');

        $query = $qb->getQuery();

        $paginator = new Paginator( $query );

        return $paginator;
    }

    

 }

 ?>