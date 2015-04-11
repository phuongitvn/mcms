<?php
/**
 * Created by PhpStorm.
 * User: phuongnv
 * Date: 3/23/2015
 * Time: 12:02 AM
 */
class AutoPostCommand extends CConsoleCommand
{
    public function actionFacebook()
    {
        $config = array();
        $config['appId'] = '417326001770427';  // configure appropriately
        $config['secret'] = 'e14f655b8e8fa5cc1362f619ea3b4766'; // configure appropriately
        $config['fileUpload'] = false; // optional
        $fb = new Facebook($config);
        $params = array(
            "access_token" => "YOUR_ACCESS_TOKEN", // configure appropriately
            "message" => $share_topic['facebook_post'],
            "link" => $share_topic['topic_url'],
            "name" => $share_topic['topic_title'],
            "caption" => "YOUR_SITE_URL", // configure appropriately
            "description" => $share_topic['topic_description']
        );
        $ret = $fb->api('/1571931466409541/feed', 'POST', $params);
    }
}