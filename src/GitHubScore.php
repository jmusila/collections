<?php

namespace src;

use GuzzleHttp\Client;

require './../vendor/autoload.php';

class GitHubScore
{
    private $username;

    private function __construct($username)
    {
        $this->username = $username;
    }

    public static function forUser($username)
    {
        return (new self($username))->getUserGitHubScrore();
    }

    public function getUserGitHubScrore()
    {
        return $this->fetchEvents()->pluck('type')->map(function ($eventType) {
            return $this->lookupScore($eventType);
        })->sum();
    }

    public function fetchEvents()
    {
        $url = "https://api.github.com/users/{$this->username}/events";

        $client = new Client();

        return collect((json_decode($client->request('GET', $url)->getBody())));
    }

    public function lookupScore($eventType)
    {
        return collect([
            'PushEvent' => 5,
            'CreateEvent' => 4,
            'IssuesEvent' => 3,
            'CommitCommentEvent' => 2,
        ])->get($eventType, 1);
    }
}

$score = GitHubScore::forUser('your_username');

echo $score;
