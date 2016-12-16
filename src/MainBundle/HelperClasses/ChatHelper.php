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

        echo $message;
        exit();
        return $message;
    }
}