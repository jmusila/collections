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

        $rankedScore = $this->assignInitialRankings($scores);;

        $adjustedScores = $this->adjustRankingsForTies($rankedScore);

        return $adjustedScores->sortBy('rank');
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

    public function assignInitialRankings($scores)
    {
        return $scores->sortByDesc('score')->zip(range(1, $scores->count()))->map(function ($scoreAndRank) {
            list($score, $rank) = $scoreAndRank;
            return array_merge($score, [
                'rank' => $rank
            ]);
        });
    }

    public function adjustRankingsForTies($scores)
    {
        return $scores->groupBy('score')->map(function ($tiedScores) {
            return $this->applyMinRank($tiedScores);
        })->collapse();
    }
}


$rank = new RankingCompetition();

echo $rank->rankCompetition();
