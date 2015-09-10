<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\View;

/**
 * Mailer
 */
class Mailer extends \XLite\View\AView
{
    const CRLF = "\r\n";

    /**
     * Mail separator symbol
     */
    const MAIL_SEPARATOR = ',';

    /**
     * Compose run
     * todo: rename to 'composing'
     *
     * @var boolean
     */
    protected static $composeRunned = false;

    /**
     * Subject template file name
     *
     * @var string
     */
    protected $subjectTemplate = 'common/subject.tpl';

    /**
     * Body template file name
     *
     * @var string
     */
    protected $bodyTemplate = 'body.tpl';

    /**
     * Layout template file name
     *
     * @var string
     */
    protected $layoutTemplate = 'common/layout.tpl';

    /**
     * Language locale (for PHPMailer)
     *
     * @var string
     */
    protected $langLocale = 'en';

    /**
     * Languages directory path (for PHPMailer)
     *
     * @var string
     */
    protected $langPath = 'lib/PHPMailer/language/';

    /**
     * PHPMailer object
     *
     * @var \PHPMailer
     */
    protected $mail = null;

    /**
     * Message charset
     *
     * @var string
     */
    protected $charset = 'UTF-8';

    /**
     * Saved templates skin
     *
     * @var string
     */
    protected $templatesSkin = null;

    /**
     * Current template
     *
     * @var string
     */
    protected $template = null;

    /**
     * Embedded images list
     *
     * @var array
     */
    protected $images = array();

    /**
     * Image parser
     *
     * @var null|\XLite\Model\MailImageParser
     */
    protected $imageParser = null;

    /**
     * Error log message
     *
     * @var string
     */
    protected $errorMessage = null;

    /**
     * Error message set by PHPMailer class
     *
     * @var string
     */
    protected $errorInfo = null;


    /**
     * Check - is compose procedure run or not
     * todo: rename to 'isComposing'
     *
     * @return boolean
     */
    public static function isComposeRunned()
    {
        return static::$composeRunned;
    }

    /**
     * Setter
     *
     * @param string $name  Property name
     * @param mixed  $value Property value
     *
     * @return void
     */
    public function set($name, $value)
    {
        if (in_array($name, array('to', 'from'))) {
            /**
             * Prevent the attack works by placing a newline character
             * (represented by \n in the following example) in the field
             * that asks for the user's e-mail address.
             * For instance, they might put:
             * joe@example.com\nCC: victim1@example.com,victim2@example.com
             */
            $value = str_replace('\t', "\t", $value);
            $value = str_replace("\t", '', $value);
            $value = str_replace('\r', "\r", $value);
            $value = str_replace("\r", '', $value);
            $value = str_replace('\n', "\n", $value);
            $value = explode("\n", $value);
            $value = $value[0];
        }

        parent::set($name, $value);
    }

    /**
     * Set subject template
     *
     * @param string $template Template path
     *
     * @return void
     */
    public function setSubjectTemplate($template)
    {
        $this->set('subjectTemplate', $template);
    }

    /**
     * Set layout template
     *
     * @param string $template Template path
     *
     * @return void
     */
    public function setLayoutTemplate($template)
    {
        $this->set('layoutTemplate', $template);
    }

    /**
     * Composes mail message.
     *
     * @param string $from          The sender email address
     * @param string $to            The email address to send mail to
     * @param string $dir           The directiry there mail parts template located
     * @param array  $customHeaders The headers you want to add/replace to. OPTIONAL
     * @param string $interface     Interface to use for mail OPTIONAL
     * @param string $languageCode  Language code OPTIONAL
     *
     * @return void
     */
    public function compose($from, $to, $dir, $customHeaders = array(), $interface = \XLite::CUSTOMER_INTERFACE, $languageCode = '')
    {
        static::$composeRunned = true;

        if (
            '' == $languageCode
            && \XLite::ADMIN_INTERFACE == $interface
            && !\XLite::isAdminZone()
        ) {
            $languageCode = \XLite\Core\Config::getInstance()->General->default_admin_language;
        }

        \XLite\Core\Translation::setTmpMailTranslationCode($languageCode);

        // initialize internal properties
        $this->set('from', $from);
        $this->set('to', $to);

        $this->set('customHeaders', $customHeaders);

        $this->set('dir', $dir);

        $subject = $this->compile($this->get('subjectTemplate'), $interface);
        $subject = \XLite\Core\Mailer::getInstance()->populateVariables($subject);

        $this->set('subject', $subject);
        $this->set('body', $this->compile($this->get('layoutTemplate'), $interface));
        $body = $this->get('body');

        $body = \XLite\Core\Mailer::getInstance()->populateVariables($body);

        // find all images and fetch them; replace with cid:...
        $fname = tempnam(LC_DIR_COMPILE, 'mail');

        file_put_contents($fname, $body);

        $this->imageParser = new \XLite\Model\MailImageParser();
        $this->imageParser->webdir = \XLite::getInstance()->getShopURL('', false);
        $this->imageParser->parse($fname);

        $this->set('body', $this->imageParser->result);
        $this->set('images', $this->imageParser->images);

        ob_start();
        // Initialize PHPMailer from configuration variables (it should be done once in a script execution)
        $this->initMailFromConfig();

        // Initialize Mail from inner set of variables.
        $this->initMailFromSet();

        $output = ob_get_contents();
        ob_end_clean();

        if ('' !== $output) {
            \XLite\Logger::getInstance()->log('Mailer echoed: "' . $output . '". Error: ' . $this->mail->ErrorInfo);
        }

        // Check if there is any error during mail composition. Log it.
        if ($this->mail->IsError()) {
            \XLite\Logger::getInstance()->log('Compose mail error: ' . $this->mail->ErrorInfo);
        }

        if (file_exists($fname)) {
            unlink($fname);
        }

        \XLite\Core\Translation::setTmpMailTranslationCode('');

        static::$composeRunned = false;
    }

    /**
     * Send message
     *
     * @return boolean
     */
    public function send()
    {
        $result = false;
        $errorMessage = null;

        if ('' === $this->get('to')) {
            $errorMessage = 'Send mail FAILED: sender address is empty';

        } elseif (!isset($this->mail)) {
            $errorMessage = 'Send mail FAILED: not initialized inner mailer';

        } else {
            $this->errorInfo = null;

            ob_start();
            $this->mail->Send();
            $error = ob_get_contents();
            ob_end_clean();

            // Check if there are any error during mail sending
            if ($this->mail->isError()) {
                $errorMessage = 'Send mail FAILED: ' . $this->prepareErrorMessage($this->mail->ErrorInfo) . PHP_EOL
                    . $this->prepareErrorMessage($error);

                $this->errorInfo = $this->mail->ErrorInfo;

            } else {
                $result = true;
            }
        }

        if ($errorMessage) {
            $this->errorMessage = $errorMessage;
            \XLite\Logger::getInstance()->log($errorMessage, \LOG_ERR);
        }

        // Restore layout
        if (isset($this->templatesSkin)) {
            \XLite\Core\Layout::getInstance()->setSkin($this->templatesSkin);
            $this->templatesSkin = null;
        }

        $this->imageParser->unlinkImages();

        return $result;
    }

    /**
     * Return description of the last occurred error (log)
     *
     * @return string
     */
    public function getLastErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Return description of the last occurred error
     *
     * @return string|void
     */
    public function getLastError()
    {
        return $this->errorInfo;
    }

    /**
     * Get language code
     * Note: for admin's emails always use default_admin_language from the store settings
     *
     * @param string $interface Recipient type OPTIONAL
     * @param string $code      Language code OPTIONAL
     *
     * @return string
     */
    public function getLanguageCode($interface = \XLite::CUSTOMER_INTERFACE, $code = '')
    {
        if (!$code) {
            $code = \XLite::CUSTOMER_INTERFACE == $interface
                ? \XLite\Core\Config::getInstance()->General->default_language
                : \XLite\Core\Config::getInstance()->General->default_admin_language;
        }

        return $code;
    }


    /**
     * Get default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return $this->template;
    }

    /**
     * Create alternative message body (text/plain)
     *
     * @param string $html Message body
     *
     * @return string
     */
    protected function createAltBody($html)
    {
        $transTbl = array_flip(get_html_translation_table(HTML_ENTITIES));
        $transTbl['&nbsp;'] = ' '; // Default: ['&nbsp;'] = 0xa0 (in ISO-8859-1)

        // remove style tag with all content
        $html = preg_replace('/<style.*<\/style>/sSU', '', $html);

        // remove html tags & convert html entities to chars
        $txt = strtr(strip_tags($html), $transTbl);

        return preg_replace('/^\s*$/m', '', $txt);
    }

    /**
     * Inner mailer initialization from set variables
     *
     * @return void
     */
    protected function initMailFromSet()
    {
        $this->mail->SetLanguage(
            $this->get('langLocale'),
            $this->get('langPath')
        );

        $this->mail->CharSet = $this->get('charset');
        $this->mail->From     = $this->get('from');
        $this->mail->FromName = $this->get('from');
        $this->mail->Sender   = $this->get('from');

        $this->mail->ClearAllRecipients();
        $this->mail->ClearAttachments();
        $this->mail->ClearCustomHeaders();

        $emails = explode(static::MAIL_SEPARATOR, $this->get('to'));

        foreach ($emails as $email) {
            $this->mail->AddAddress($email);
        }

        $this->mail->Subject  = $this->get('subject');
        $this->mail->AltBody  = $this->createAltBody($this->get('body'));
        $this->mail->Body     = $this->get('body');

        // add custom headers
        foreach ($this->get('customHeaders') as $header) {
            $this->mail->AddCustomHeader($header);
        }

        if (is_array($this->get('images'))) {
            foreach ($this->get('images') as $image) {
                // Append to $attachment array
                $this->mail->AddEmbeddedImage(
                    $image['path'],
                    $image['name'] . '@mail.lc',
                    $image['name'],
                    'base64',
                    $image['mime']
                );
            }
        }
    }

    /**
     * Inner mailer initialization from DB configuration
     *
     * @return void
     */
    protected function initMailFromConfig()
    {
        if (!isset($this->mail)) {

            // Initialize PHPMailer
            include_once LC_DIR_LIB . 'PHPMailer' . LC_DS . 'class.phpmailer.php';

            $this->mail = new \PHPMailer();
            // SMTP settings
            if (\XLite\Core\Config::getInstance()->Email->use_smtp) {
                $this->mail->Mailer = 'smtp';
                $this->mail->Host = \XLite\Core\Config::getInstance()->Email->smtp_server_url;
                $this->mail->Port = \XLite\Core\Config::getInstance()->Email->smtp_server_port;

                if (\XLite\Core\Config::getInstance()->Email->use_smtp_auth) {
                    $this->mail->SMTPAuth = true;
                    $this->mail->Username = \XLite\Core\Config::getInstance()->Email->smtp_username;
                    $this->mail->Password = \XLite\Core\Config::getInstance()->Email->smtp_password;
                }
                if (in_array(\XLite\Core\Config::getInstance()->Email->smtp_security, array('ssl', 'tls'))) {
                    $this->mail->SMTPSecure = \XLite\Core\Config::getInstance()->Email->smtp_security;
                }
            }

            $this->mail->SMTPDebug = true;
            $this->mail->IsHTML(true);
            $this->mail->Encoding = 'base64';
        }
    }

    /**
     * Compile template
     *
     * @param string $template  Template path
     * @param string $interface Interface OPTIONAL
     *
     * @return string
     */
    protected function compile($template, $interface = \XLite::CUSTOMER_INTERFACE)
    {
        // replace layout with mailer skinned
        /** @var \XLite\Core\Layout $layout */
        $layout = \XLite\Core\Layout::getInstance();
        $commonSkin = $layout->getSkin();
        $commonInterface = $layout->getInterface();
        $layout->setMailSkin($interface);

        $this->widgetParams[static::PARAM_TEMPLATE]->setValue($template);
        $this->template = $template;
        $this->init();
        $text = $this->getContent();

        // restore old skin
        switch ($commonInterface) {
            default:
            case \XLite::ADMIN_INTERFACE:
                $layout->setAdminSkin();
                break;

            case \XLite::CUSTOMER_INTERFACE:
                $layout->setCustomerSkin();
                break;

            case \XLite::CONSOLE_INTERFACE:
                $layout->setConsoleSkin();
                break;

            case \XLite::MAIL_INTERFACE:
                $layout->setMailSkin();
                break;
        }

        $layout->setSkin($commonSkin);

        return $text;
    }

    /**
     * Get headers as string
     *
     * @return string
     */
    protected function getHeaders()
    {
        $headers = '';
        foreach ($this->headers as $name => $value) {
            $headers .= $name . ': ' . $value . self::CRLF;
        }

        return $headers;
    }

    /**
     * Prepare error message
     *
     * @param string $message Message
     *
     * @return string
     */
    protected function prepareErrorMessage($message)
    {
        return trim(strip_tags($message));
    }

    /**
     * Returns notification by current dir
     *
     * @return \XLite\Model\Notification
     */
    protected function getNotification()
    {
        return \XLite\Core\Database::getRepo('\XLite\Model\Notification')
            ->findOneByTemplatesDirectory($this->get('dir'));
    }

    /**
     * Returns subject for current notification
     *
     * @return string
     */
    protected function getNotificationSubject()
    {
        $result = '';
        $notification = $this->getNotification();

        if ($notification) {
            switch (\XLite\Core\Layout::getInstance()->getMailInterface()) {
                case \XLite::CUSTOMER_INTERFACE:
                    $result = $notification->getCustomerSubject();
                    break;

                case \XLite::ADMIN_INTERFACE:
                    $result = $notification->getAdminSubject();
                    break;

                default:
                    break;
            }
        }

        return $result;
    }

    /**
     * Returns text for current notification
     *
     * @return string
     */
    protected function getNotificationText()
    {
        $result = '';
        $notification = $this->getNotification();

        if ($notification) {
            switch (\XLite\Core\Layout::getInstance()->getMailInterface()) {
                case \XLite::CUSTOMER_INTERFACE:
                    $result = $notification->getCustomerText();
                    break;

                case \XLite::ADMIN_INTERFACE:
                    $result = $notification->getAdminText();
                    break;

                default:
                    break;
            }
        }

        return $result;
    }

    /**
     * Returns header for current notification
     *
     * @return string
     */
    protected function getNotificationHeader()
    {
        $result = '';

        switch (\XLite\Core\Layout::getInstance()->getMailInterface()) {
            case \XLite::CUSTOMER_INTERFACE:
                $result = static::t('emailNotificationCustomerHeader');
                break;

            case \XLite::ADMIN_INTERFACE:
                $result = static::t('emailNotificationAdminHeader');
                break;

            default:
                break;
        }

        return $result;
    }

    /**
     * Returns header for current notification
     *
     * @return string
     */
    protected function getNotificationSignature()
    {
        $result = '';

        switch (\XLite\Core\Layout::getInstance()->getMailInterface()) {
            case \XLite::CUSTOMER_INTERFACE:
                $result = static::t('emailNotificationCustomerSignature');
                break;

            case \XLite::ADMIN_INTERFACE:
                $result = static::t('emailNotificationAdminSignature');
                break;

            default:
                break;
        }

        return $result;
    }
}
