<?php

namespace Mail;

/**
 * Interface of Mail class
 *
 * @package Mail
 * @author `Vinicius Pugliesi`
 */
interface InterfaceMail
{
    public static function from($emailFrom, $nameFrom = false);

    public static function subject($subject);

    public static function address($address, $name = false);

    public static function cc($address);

    public static function bcc($address);

    public static function replyTo($address, $information = false);

    public static function body($body);

    public static function altBody($altBody);

    public static function isHTML($isHtml = false);

    public static function attachment($addAttachment, $name);

    public static function send();

    public static function configuration();
}