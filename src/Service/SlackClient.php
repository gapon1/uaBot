<?php


namespace App\Service;


use App\Helper\LoggerTrait;
use Nexy\Slack\Client;

class SlackClient
{

    use LoggerTrait;

    /**
     * @var Client
     */
    private $slack;

    public function __construct(Client $slack)
    {
        $this->slack = $slack;
    }

    public function sendMessage(string $from, string $messge)
    {
        $this->logInfo(
            'Test logger Trait',
            [
                'message' => $messge,
            ]
        );

        $slackMessage = $this->slack->createMessage()
            ->from($from)
            ->withIcon(':ghost:')
            ->setText($messge);
        $this->slack->sendMessage($slackMessage);
    }

}