<?php

namespace src;

require './../vendor/autoload.php';

class RankingCompetition
{
    /**
     * Rank each time accodring to the scrore
     */
    public function rankCompetition()
    {
        $scores = collect([
            ['score' => 76, 'team' => 'A'],
            ['score' => 62, 'team' => 'B'],
            ['score' => 82, 'team' => 'C'],
            ['score' => 86, 'team' => 'D'],
            ['score' => 91, 'team' => 'E'],
            ['score' => 67, 'team' => 'F'],
            ['score' => 67, 'team' => 'G'],
            ['score' => 82, 'team' => 'H'],
        ]);

        return $scores->sortByDesc('score')->zip(range(1, $scores->count()))->map(function($scoreAndRank){
            list($score, $rank) = $scoreAndRank;
            return array_merge($score, [
                'rank' => $rank
            ]);
        });
    }
}


$rank = new RankingCompetition();

var_dump($rank->rankCompetition());