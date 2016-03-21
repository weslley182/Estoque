<?php 

namespace Estoque\View\Helper;

use Zend\View\Helper\AbstractHelper;

class PaginationHelper extends AbstractHelper {

	private $pagina;
	private $url;
	private $qtdPorPagina;
	private $totalRegistros;

	public function __invoke($registros,$pagina,$url,$qtdPorPagina) {

		$this->pagina = $pagina;
		$this->url = $url;
		$this->qtdPorPagina = $qtdPorPagina;
		$this->totalRegistros = $registros->count();
		return $this->gerarPaginacao();

	}

	private function gerarPaginacao() {

		$html = "<ul class=\"nav nav­pills\">";
		$totalPaginas = ceil($this->totalRegistros / $this->qtdPorPagina);

		if($totalPaginas == 1) {
			return;
		}

		$count = 1;

		while($count <= $totalPaginas) {

			$html .= "<li><a href=\"{$this->url}/{$count}\">{$count}</a></li>";
			$count++;

		}

		$html .= "</ul>";
		return $html;
	}

}

?>