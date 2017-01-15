<?php
namespace Kanboard\Plugin\Notify\Controller;

use Kanboard\Controller\BaseController;

class Notify extends BaseController
{

    public function show()
    {
		
       $user = $this->getUser();
	   
		$arrayNotificacoes = array();
		$contador_notificacoes = 0;
			
	   //Check if user is active
	   if($user['is_active'] == 1){
	   	
			//Get user notifications
			$obter_notificacoes = $this->userUnreadNotificationModel->getAll($user['id']);

			foreach($obter_notificacoes AS $notificationInfo){
				
				//Get notification URL
				$url_tarefa = $this->helper->url->to("WebNotificationController", "redirect", array("notification_id" => $notificationInfo['id'], 'user_id' => $user['id']), false, false, true);
				
				//Insert project name into Notification Title
				$notify_titulo = "[".$notificationInfo['event_data']['task']['project_name']."] ".$notificationInfo['event_data']['task']['title'];
				
				//Insert logo from "Asset/img" folder
				$notify_image = $this->configModel->get('application_url')."plugins/Notify/Asset/img/logo.png";
				
				//Set a unique ID for this notification
				$id_notificacao = "kanboard-".$notificationInfo['date_creation']."-".$notificationInfo['id'];
				
			//Check notification in SESSION
			if(!@$this->container['sessionStorage']->$id_notificacao){

					$arrayNotificacoes['notificacoes'][] = array(
					"titulo" => $notify_titulo,
					"descricao" => $notificationInfo['title'],
					"url" => $url_tarefa,
					"data" => $notificationInfo['date_creation'],
					"imagem" => $notify_image,
					"tag" => $id_notificacao,
					);
						
					$contador_notificacoes++;
					
					//Avoid show this notification again
					$this->container['sessionStorage']->$id_notificacao = '1';
				
				}
			}
	
	   }

		//Count notifications
		$arrayNotificacoes['count'] = intval($contador_notificacoes);

		//Return JSON
		header("Content-Type: application/json;charset=utf-8");
		echo json_encode($arrayNotificacoes);

    }

}
