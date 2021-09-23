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

        return $scores->sortByDesc('score')->zip(range(1, $scores->count()))->map(function ($scoreAndRank) {
            list($score, $rank) = $scoreAndRank;
            return array_merge($score, [
                'rank' => $rank
            ]);
        })->groupBy(function ($rankedScore) {
            return $rankedScore['score'];
        })->map(function ($tiedScores) {
            return $this->applyMinRank($tiedScores);
        })->collapse()->sortBy('rank');
    }

    /**
     * Apply min rank
     *
     */
    public function applyMinRank($tiedScores)
    {
        $lowestRank = $tiedScores->pluck('rank')->min();

        return $tiedScores->map(function ($rankedScore) use ($lowestRank) {
            return array_merge($rankedScore, [
                'rank' => $lowestRank
            ]);
        });
    }
}


$rank = new RankingCompetition();

echo $rank->rankCompetition();
