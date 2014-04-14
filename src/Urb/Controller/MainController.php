<?php

namespace Urb\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Gecky\Controller\Controller;

class MainController extends Controller
{		
	public function indexAction(Request $request)
	{
		$facebook = $this->container->get('facebook');
		$signedRequest = $facebook->getSignedRequest();
		$loginUrl = $facebook->getConfiguredLoginUrl();
		
		$mobileDetect = $this->container->get('mobile_detect');		
		$isMobile = $mobileDetect->isMobile();
		
		if (!$isMobile && $signedRequest == null)
		{
			//return new RedirectResponse($facebook->getTabUrl());
		}
				
		if($signedRequest && !$signedRequest['page']['liked'])
		{
			return new RedirectResponse('index.php/like');
		}
		
		return $this->render('Main/index.php', array(				
			'facebook' => $facebook,
			'isMobile' => $isMobile,
			'loginUrl' => $loginUrl
		));
	}
	
	public function likeAction(Request $request)
	{
		return $this->render('Main/like.php');
	} 
	
	public function registerAction(Request $request)
	{
		/** REGISTER INTO DB **/
		$register = $request->get('register');
		if($register)
		{
			$name = $register['name'];
			$cedula = $register['cedula'];
			$email = $register['email'];
			$phone = $register['phone'];
			$birthdate = $register['birthdate'];
			$product = $register['product'];
			$factura = $register['factura'];
			$monto = $register['monto'];
			$tienda = $register['tienda'];
			$newsletter = (isset($register['newsletter']) && $register['newsletter']!='')?1:0;
			$terms = $register['terms'];		
	
			$birthdate = $birthdate['year'].'-'.$birthdate['month'].'-'.$birthdate['day'];
			
			//Guardado en base de datos
			$conn = $this->container->get('database')->getConnection();
			$response['register_saved'] = $conn->insert('user', array(
					'name' => $name, 'cedula' => $cedula, 'email' => $email, 'phone' => $phone,
					'birthdate' => $birthdate, 'product' => $product, 'factura' => $factura, 'monto' => $monto,
					'tienda' => $tienda, 'newsletter' => $newsletter
			));
			
			/** FACEBOOK **/
			$facebook = $this->container->get('facebook');
			if($facebook->getUser())
			{
				try {
					$ret_obj = $facebook->api('/me/feed', 'POST',
							array(
									'link' => $facebook->getAppHost(),
									'name' => 'LG Premia con 10,000',
									'message' => 'Estoy participando en la Promo LG premia con 10,000.',
									'caption' => 'Estoy participando en la Promo LG premia con 10,000',
									'picture' => $facebook->getAppHost().'/images/logo.png'
							)
					);
					$response['fb_post'] = true;
				} catch(FacebookApiException $e)
				{
					$response['fb_post'] = false;
					$response['fb_post_error'] = array(
							'type' => $e->getType(),
							'message' => $e->getMessage()
					);
				}
			}
		}
		
		return $this->render('Main/register.php', array(
		));
	}
	
	public function thanksAction(Request $request)
	{
		return $this->render('Main/thanks.php');
	}
	
	public function facebookLoginAction(Request $request)
	{
		$facebook = $this->container->get('facebook');
		if(!$facebook->getUser())
		{
			$loginUrl = $facebook->getConfiguredLoginUrl();
			return new RedirectResponse($loginUrl);
		}
		
		return new RedirectResponse($this->container->get('routing.generator')->generate('homepage'));
	}
	
	public function registerListAction(Request $request)
	{
		//Get all data
		$conn = $this->container->get('database')->getConnection();
		$registers = $conn->fetchAll('SELECT * FROM user AS u ORDER BY u.is_winner DESC');
		
		return $this->render('Main/registerList.php', array(
			'registers' => $registers 
		), 'admin_layout');
	}
	
	public function deleteRegisterAction(Request $request)
	{
		//Get all data
		$conn = $this->container->get('database')->getConnection();
		$conn->delete('user', array('id' => $request->get('id')));
		
		return new RedirectResponse($this->container->get('routing.generator')->generate('register_list'));
	}
	
	public function generateWinnersAction(Request $request)
	{
		$conn = $this->container->get('database')->getConnection();
		
		//Unset old winners
		$conn->update('user', array('is_winner' => false), array(1 => 1));
		
		//Generate winners
		$possibleWinners = array();
		$registers = $conn->fetchAll('SELECT * FROM user AS u');
		foreach ($registers as $register)
		{
			$posibilities = ceil($register['monto'] / 200);
			for ($i=1; $i <= $posibilities; $i++)
			{
				$possibleWinners[] = $register['id'];
			}
		}
		
		shuffle($possibleWinners);
		$winners = array();
		foreach ($possibleWinners as $possibleWinner)
		{
			if(count($winners) >= 1)
				break;
			
			if(!in_array($possibleWinner, $winners))
			{
				$winners[] = $possibleWinner;
			}
		}
		
		foreach ($winners as $winner)
		{
			$conn->update('user', array('is_winner' => true), array('id' => $winner));
		}
		
		return new RedirectResponse($this->container->get('routing.generator')->generate('register_list'));
	}
	
	public function downloadExcelAction(Request $request)
	{
		//Guardado en base de datos
		$conn = $this->container->get('database')->getConnection();
		$registers = $conn->fetchAll('SELECT * FROM user');
	
		$view = $this->templating->render('Main/downloadExcel.php', array(
			'registers' => $registers
		));
	
		$response = new Response($view); 
		$response->headers->set('Content-Type', 'application/octet-stream');
		$response->headers->set('Content-Disposition', 'attachment; filename=registros.xls');
		$response->headers->set('Pragma', 'no-cache');
		$response->headers->set('Expires', '0');
		
		return $response;
	}
	
	protected function getViewsDir()
	{
		return __DIR__.'/../Resources/views/%name%';
	}
}