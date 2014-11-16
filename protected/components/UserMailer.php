<?php

/*
 * Relations: extensions/swiftMailer
 */

class UserMailer extends CApplicationComponent
{
    public $host;
    public $port;
    public $login;
    public $password;
    public $isSsl;

    protected $swiftMailer;
    protected $mailer;

    protected $templateAlias = 'application.views.emails.';

    public function init()
    {
        $this->initMailer();
        $this->swiftMailer = Yii::app()->swiftMailer;
        $this->mailer = $this->swiftMailer->mailer(Swift_SmtpTransport::newInstance($this->host,
            $this->port, $this->isSsl ? 'ssl' : '')->setUsername($this->login)->setPassword($this->password));
    }

    /**
     * Send email with registration info
     * Usage: controllers/Registration/actionJen
     *
     * @param User|Users $user
     * @return bool
     */
    public function accountConfirm(User $user)
    {
        $content = $this->renderContent(__FUNCTION__, ['model' => $user]);
        $contentPlain = $this->renderContent(__FUNCTION__, ['model' => $user], true);

        $from = $this->getFrom();
        $to = $this->getTo($user);

        return $this->sendMessage($from, $to, $content, $contentPlain, 'Confirm your account');
    }

    protected function renderContent($template, $params, $plain = false)
    {
        // camelCase to camel_case
        $template = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $template)), '_');
        return Yii::app()->controller->renderPartial($this->templateAlias . strtolower($template) . ($plain ? '-plain' : ''),
            $params, true);
    }

    protected function initMailer()
    {
        if (!Yii::app()->hasComponent('swiftMailer')) {
            Yii::app()->setComponent('swiftMailer', ['class' => 'ext.swiftMailer.SwiftMailer']);
        }
    }

    /**
     * @param array $from Format: [mail@example.com => alias)
     * @param array $to Format: [john.dear@example.com => John Dear)
     * @param string $content
     * @param string $contentPlain
     * @param string $subject
     * @return bool
     */
    protected function sendMessage(array $from, array $to, $content, $contentPlain = '', $subject = '')
    {
        $message = $this->swiftMailer->newMessage($subject)->setFrom($from)->setTo($to)->addPart($content,
            'text/html')->setBody($contentPlain);

        return (bool)$this->mailer->send($message);
    }

    protected function getFrom()
    {
        return [Yii::app()->params['noreplyEmail'] => Yii::app()->name];
    }

    protected function getTo(User $user)
    {
        return [$user->email => $user->name];
    }
}
