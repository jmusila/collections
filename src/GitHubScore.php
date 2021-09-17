<?php

namespace src;

use GuzzleHttp\Client;

require './../vendor/autoload.php';

class GitHubScore
{
    public function getUserGitHubScrore()
    {
        $url = "https://api.github.com/users/jmusila/events";

        $client = new Client();

        $res = collect((json_decode($client->request('GET', $url)->getBody())));

        $events = $res->pluck('type');

        $scrores = $events->map(function ($eventType) {
            $eventScores = collect([
                'PushEvent' => 5,
                'CreateEvent' => 4,
                'IssuesEvent' => 3,
                'CommitCommentEvent' => 2,
            ]);

            return $eventScores->get($eventType, 1);
        })->sum();

        return $scrores;
    }
}

$score = new GitHubScore();

var_dump($score->getUserGitHubScrore());
