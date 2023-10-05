<?php

namespace App\Notifications;

use App\Models\User;
use App\Channels\Log;
use App\Channels\Nepras;
use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewProposalNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Proposal $proposal, protected User $freelancer)
    {
        $this->proposal = $proposal;
        $this->freelancer = $freelancer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // $via = ['database', 'mail', 'broadcast', 'vonage'];
        // $via = [Log::class];
        $via = [Nepras::class];

        if (!$notifiable instanceof AnonymousNotifiable) {
            if ($notifiable->notify_mail) {
                $via [] = 'mail';
            }

            if ($notifiable->notify_sms) {
                $via [] = 'nexmo';
            }
        }

        return $via;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $body = sprintf(
            '<span style="color: green; font-weight: bold">%s</span> applied for a job <span style="color: orange; font-weight: bold">%s</span>',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        $message = new MailMessage;
        $message->subject('New Proposal')
                ->greeting('Hello ' . ($notifiable->name ?? 'Anonymous'))
                ->line($body)
                ->action('View To Proposal', route('projects.show', $this->proposal->project_id))
                ->line('Thank you for using our application!');
                /*->view('mail.proposal', [
                    'proposal' => $this->proposal,
                    'notifiable' => $notifiable,
                    'freelancer' => $this->freelancer,
                ]);*/

        return $message;
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        $body = sprintf(
            '<span style="color: green; font-weight: bold">%s</span> applied for a job <span style="color: orange; font-weight: bold">%s</span>',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        return [
            'title' => 'New Proposal',
            'body' => $body,
            'icon' => 'icon-material-outline-group',
            'url' => route('projects.show', $this->proposal->project_id)
        ];
    }

    /**
     * Get the broadcast representation of the notification.
     */
    public function toBroadcast (object $notifiable) {
        $body = sprintf(
            '<span style="color: green; font-weight: bold">%s</span> applied for a job <span style="color: orange; font-weight: bold">%s</span>',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        return new BroadcastMessage([
            'title' => 'New Proposal',
            'body' => $body,
            'icon' => 'icon-material-outline-group',
            'url' => route('projects.show', $this->proposal->project_id)
        ]);
    }

    /**
     * Get the nexmo representation of the notification.
     */
    public function toVonage (object $notifiable) {
        $body = sprintf(
            '<span style="color: green; font-weight: bold">%s</span> applied for a job <span style="color: orange; font-weight: bold">%s</span>',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        return (new VonageMessage)
            ->content($body);
    }

    public function toLog (object $notifiable) {
        $body = sprintf(
            '<span style="color: green; font-weight: bold">%s</span> applied for a job <span style="color: orange; font-weight: bold">%s</span>',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        return $body;
    }

    public function toNepras (object $notifiable)
    {
        $body = sprintf(
            '<span style="color: green; font-weight: bold">%s</span> applied for a job <span style="color: orange; font-weight: bold">%s</span>',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        return $body;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
