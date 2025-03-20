<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class SlackNotification extends Notification
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     * @throws \JsonException
     */
    public function toSlack(): SlackMessage
    {
        return (new SlackMessage)
            ->content($this->listOrSingleContent());
    }

    public function listOrSingleContent(): string
    {
        if (count($this->data['data']) > 1) {
            return $this->createContentList();
        } else {
            return $this->createContent();
        }
    }


    /**
     * Get the array representation of the notification.
     *
     * @return string
     */
    public function createContent(): string
    {
        $content = "*{$this->data['message']}* \n {$this->data['assignee']}";
        if (isset($this->data['task'])) {
            $content .= "\n\n *Title*: \n {$this->data['task']['title']}\n\n *Deadline*: \n {$this->data['task']['deadline']}";
        }
        return $content;
    }

    public function createContentList(): string
    {
        $content = "*{$this->data['message']}*";
        foreach ($this->data['data'] as $messageData) {
            $content .= " \n{$messageData['assignee']}\n\n *Title*: \n _{$messageData['task']['title']}_\n\n *Deadline*: \n _{$messageData['task']['deadline']}_\n\n\n";
        }
        return $content;
    }


}
