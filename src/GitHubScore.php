<?php

namespace src;

use GuzzleHttp\Client;

require './../vendor/autoload.php';

class GitHubScore
{
    public function getUserGitHubScrore($username = "yourusername")
    {
        return self::fetchEvents($username)->pluck('type')->map(function ($eventType) {
            return self::lookupScore($eventType);
        })->sum();
    }

    private static function fetchEvents($username)
    {
        $url = "https://api.github.com/users/{$username}/events";

        $client = new Client();

        return collect((json_decode($client->request('GET', $url)->getBody())));
    }

    private static function lookupScore($eventType)
    {
        return collect([
            'PushEvent' => 5,
            'CreateEvent' => 4,
            'IssuesEvent' => 3,
            'CommitCommentEvent' => 2,
        ])->get($eventType, 1);
    }
}

$score = new GitHubScore();

echo($score->getUserGitHubScrore());
