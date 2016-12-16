<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16.12.16
 * Time: 09:09
 */

namespace MainBundle\HelperClasses;


class ChatHelper
{
    public function optimizeChatMessage($message)
    {
        $message = str_replace("&nbsp;", " ", $message);
        $message = str_replace("<div>", "<p>", $message);
        $message = str_replace("</div>", "</p>", $message);
        return $message;
    }
}