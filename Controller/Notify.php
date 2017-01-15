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
				
				
				if($notificationInfo['event_name'] == "task.update"){
					
					$notify_description = $notificationInfo['event_data']['task']['title'];
					
					$notify_title = "[".$notificationInfo['event_data']['task']['project_name']."] ".$notificationInfo['title'];
					
				
				}else{
					
					
					if(is_array($notificationInfo['event_data']['tasks']) AND count($notificationInfo['event_data']['tasks']) > 0){
						
						$tasks_name = array();
						foreach($notificationInfo['event_data']['tasks'] AS $sub_tasks){
							$tasks_name[] = $sub_tasks['title'];
						}
						
						$notify_description = implode(', ', $tasks_name);
						
					}else{
						
						$notify_description = $notificationInfo['event_data']['tasks']['title'];
						
					}
					
					$notify_title = "[".$notificationInfo['event_data']['project_name']."] ".$notificationInfo['title'];
					
				}
				

				//Get notification URL
				$url_tarefa = $this->helper->url->to("WebNotificationController", "redirect", array("notification_id" => $notificationInfo['id'], 'user_id' => $user['id']), false, false, true);
				
				//Insert logo from "Asset/img" folder
				$notify_image = $this->configModel->get('application_url')."plugins/Notify/Asset/img/logo.png";
				
				//Set a unique ID for this notification
				$id_notificacao = "kanboard-".$notificationInfo['date_creation']."-".$notificationInfo['id'];
				
			//Check notification in SESSION
			if(!@$this->container['sessionStorage']->$id_notificacao){
					
					//Avoid show this notification again
					
					if($contador_notificacoes <= 3){
						
						
					$arrayNotificacoes['notificacoes'][] = array(
					"titulo" => $notify_title,
					"descricao" => $notify_description,
					"url" => $url_tarefa,
					"data" => $notificationInfo['date_creation'],
					"imagem" => $notify_image,
					"tag" => $id_notificacao,
					);
						
					$contador_notificacoes++;
						
						
						$this->container['sessionStorage']->$id_notificacao = '1';
					}
				
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
