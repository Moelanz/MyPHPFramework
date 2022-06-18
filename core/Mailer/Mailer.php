<?php namespace Moelanz\Mailer;

use Moelanz\Templates\Twig\Twig;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Mailer\EventListener\MessageListener;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;

/**
 * Class Mailer
 * @package Moelanz\Mailer
 *
 * @author Moelanz
 */
class Mailer
{
    /**
     * Twig
     *
     * @var Twig|null
     */
    private ? Twig $twig = null;

    /**
     * MessageListener
     *
     * @var MessageListener|null
     */
    private ? MessageListener $messageListener = null;

    /**
     * EventDispatcher
     *
     * @var EventDispatcher|null
     */
    private ? EventDispatcher $eventDispatcher = null;

    /**
     * TransportInterface
     *
     * @var TransportInterface|null
     */
    private ? TransportInterface $transport = null;

    /**
     * Mailer
     *
     * @var \Symfony\Component\Mailer\Mailer|null
     */
    private ? \Symfony\Component\Mailer\Mailer $mailer = null;

    /**
     * Send Email
     *
     * @param Email $email
     * @return bool
     * @throws TransportExceptionInterface
     */
    public function send(Email $email): bool
    {
        $this->getMailer()->send($email);
        return true;
    }

    /**
     * Get Twig
     *
     * @return Twig
     */
    private function getTwig(): Twig
    {
        if (is_null($this->twig)) {
            $this->twig = new Twig();
        }

        return $this->twig;
    }

    /**
     * Get Message Listener
     *
     * @return MessageListener
     */
    private function getMessageListener(): MessageListener
    {
        if (is_null($this->messageListener)) {
            $this->messageListener = new MessageListener(
                null,
                new BodyRenderer($this->getTwig()->getEnvironment())
            );
        }

        return $this->messageListener;
    }

    /**
     * Get Event Dispatcher
     *
     * @return EventDispatcher
     */
    private function getEventDispatcher(): EventDispatcher
    {
        if (is_null($this->eventDispatcher)) {
            $this->eventDispatcher = new EventDispatcher();
            $this->eventDispatcher->addSubscriber($this->getMessageListener());
        }

        return $this->eventDispatcher;
    }

    /**
     * Get Transport
     *
     * @return TransportInterface
     */
    private function getTransport(): TransportInterface
    {
        if (is_null($this->transport)) {
            $this->transport = Transport::fromDsn($this->getDsn(), $this->getEventDispatcher());
        }

        return $this->transport;
    }

    /**
     * @return string
     */
    private function getDsn(): string
    {
        return defined('MAILER_DSN') ? MAILER_DSN : 'smtp://localhost';
    }

    /**
     * Get Mailer
     *
     * @return \Symfony\Component\Mailer\Mailer
     */
    private function getMailer(): \Symfony\Component\Mailer\Mailer
    {
        if (is_null($this->mailer)) {
            $this->mailer = new \Symfony\Component\Mailer\Mailer(
                $this->getTransport(),
                null,
                $this->getEventDispatcher());
        }

        return $this->mailer;
    }
}