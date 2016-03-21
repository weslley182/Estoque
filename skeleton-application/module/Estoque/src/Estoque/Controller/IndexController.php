<?php 

namespace Estoque\Controller;

use Estoque\Form\ProdutoForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Estoque\Entity\Produtos;

use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class IndexController extends AbstractActionController {
	
	public function IndexAction(){
		$pagina = $this->params()->fromRoute('page', 1);
		$qtdPagina = 5;
		$offset = ($pagina - 1) * $qtdPagina;
		
		$entityManager = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
		
		$repositorio = $entityManager->getRepository("Estoque\Entity\Produtos");

		$lista = $repositorio->getProdutosPaginados($offset,$qtdPagina);

		# $oProdutos = $repositorio->findAll();

		$view_params = array(
			'poProdutos' => $lista,
			'page' => $pagina,
			'qtdPorPagina' => $qtdPagina);
		return new ViewModel($view_params);
	}

	public function cadastrarAction(){
		#if(!$user = $this->identity()) {
		#	$this->redirect()->toUrl('/Usuario');
		#}

		$form = new ProdutoForm();

		if($this->request->isPost()) {

	        $nome = $this->request->getPost('nome');
	        $preco = $this->request->getPost('preco');
	        $descricao = $this->request->getPost('descricao');

	        $produto = new Produtos($nome, $preco, $descricao);
			$form->setInputFilter($produto->getInputFilter());
			$form->setData($this->request->getPost());

			if($form->isValid()){
				$em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
				$em->persist($produto);
				$em->flush();

				$this->flashMessenger()->addSuccessMessage("Produto cadastrado com sucesso.");
				return $this->redirect()->toUrl('/Index/Index');
			}
		}

		return new ViewModel(['form' => $form]);
	}

	public function deletarAction(){

		$id = $this->params()->fromRoute('id');

        if(is_null($id)) {
            $id = $this->params()->fromPost('id');
        }

        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $repositorio = $em->getRepository("Estoque\Entity\Produtos");
        $produto = $repositorio->find($id);

        if($this->request->isPost()) {

            $em->remove($produto);
            $em->flush();

			$this->flashMessenger()->addSuccessMessage("Produto removido com sucesso.");

            return $this->redirect()->toUrl('/Index/Index');

        }

		$view_params = ['produto' => $produto];
        return new ViewModel($view_params);
	}

	public function editarAction(){
		$id = $this->params()->fromRoute('id');

        if(is_null($id)) {
            $id = $this->params()->fromPost('id');
        }

        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $repositorio = $em->getRepository("Estoque\Entity\Produtos");
        $produto = $repositorio->find($id);

        if($this->request->isPost()) {
        	var_dump($produto);
        	$produto->setNome($this->request->getPost('nome'));
        	$produto->setPreco($this->request->getPost('preco'));
        	$produto->setDescricao($this->request->getPost('descricao'));

            $em->persist($produto);
            $em->flush();

            $this->flashMessenger()->addSuccessMessage("Produto alterado com sucesso.");
            return $this->redirect()->toUrl('/Index/Index');

        }

		$view_params = ['produto' => $produto];
        return new ViewModel($view_params);		

	}

	public function contatoAction(){
		if($this->request->isPost()) {

		    $nome = $this->request->getPost('nome');
		    $email = $this->request->getPost('email');
		    $mensagem = $this->request->getPost('msg');

		    $sMsg = "<b>Nome:</b> {$nome},<br>
				<b>Email:</b> {$email},<br>
				<b>Mensagem:</b> {$mensagem}";

		    $html = new MimePart($sMsg);

			$html->type = 'text/html';

			$body = new MimeMessage();
			$body->addPart($html);			

		    $message = new Message();
			$message->addTo('weslley182@gmail.com');
			$message->addFrom('weslley182@gmail.com');
			$message->setSubject('Envio de email com zf2');

			$message->setBody($body);

			$config = array(
				'host'  => 'smtp.gmail.com',
            	'connection_class'  => 'login',
            	'connection_config' => array(
                	'ssl'      => 'tls',
                	'username' => 'weslley182@gmail.com',
                	'password' => 'soniablade1234'
                ),
            	'port' => 587,
            );


			$transport = new SmtpTransport();
			$options = new SmtpOptions($config);
			$transport->setOptions($options);

            $transport->send($message);

            $this->flashMessenger()->addMessage("Email enviado com sucesso.");
            return  $this->redirect()->toUrl('/index');

		}

		return new ViewModel();
	}


}