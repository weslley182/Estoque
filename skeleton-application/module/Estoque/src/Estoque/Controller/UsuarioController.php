<?php 

namespace Estoque\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UsuarioController extends AbstractActionController{

	public function indexAction() {	

		if($this->request->isPost()) {

			$dados = $this->request->getPost();
			$authService = 
				$this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

			$adapter = $authService->getAdapter();			
			$adapter->setIdentityValue($dados['email']);
			$adapter->setCredentialValue($dados['senha']);
			$authResult = $authService->authenticate();
			if($authResult->isValid()) {
				return $this->redirect()->toUrl('Index/Cadastro');
			}

			$this->flashMessenger()->addErrorMessage("Login ou senha inválido");
			return $this->redirect()->toUrl('/Usuario/Index');
		}

		return new ViewModel();
	}

	public function logoutAction() {

		$authService = 
			$this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		$authService->clearIdentity();
		$this->redirect()->toUrl('/Usuario');

	}

}

?>