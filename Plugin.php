<?php
namespace Kanboard\Plugin\Notify;
use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {

		$this->route->addRoute('notify', 'Notify', 'show', 'Notify');
		$this->template->hook->attach('template:layout:js', 'plugins/Notify/Asset/js/push.js');
		$this->template->hook->attach('template:layout:js', 'plugins/Notify/Asset/js/notify.js');
		$this->template->hook->attach('template:layout:head', 'Notify:layout/head');
    }
	
    public function getPluginName()
    {
        return 'Notify';
    }

	
    public function getPluginDescription()
    {
        return 'Browser Notification extension for Kanboard.';
    }

    public function getPluginAuthor()
    {
        return 'Marcio Dias';
    }
	
	public function getPluginVersion()
    {
        return '1.0.0';
    }
    public function getPluginHomepage()
    {
        return 'https://github.com/khigashi/kanboard-plugin-notify';
    }

}
