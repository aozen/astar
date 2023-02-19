<?php

namespace Aozen\Astar;

class AStar {
    private $graph;
    private $cameFrom;

    public function __construct($graph) {
        $this->graph = $graph;
    }

    public function search($start, $goal) {
        $openSet = new PriorityQueue();
        $this->cameFrom = [];
        $costSoFar = [];

        $openSet->addNode($start, 0);
        $this->cameFrom[$start] = null;
        $costSoFar[$start] = 0;

        while (!$openSet->isEmpty()) {
            $current = $openSet->getNextNode();

            if ($current == $goal) {
                return $this->buildPath($start, $goal);
            }

            foreach ($this->graph->getNeighbors($current) as $next) {
                $newCost = $costSoFar[$current] + $this->graph->getCost($current, $next);

                if (!isset($costSoFar[$next]) || $newCost < $costSoFar[$next]) {
                    $costSoFar[$next] = $newCost;
                    $priority = $newCost + $this->graph->heuristic($next, $goal);
                    $openSet->addNode($next, $priority);
                    $this->cameFrom[$next] = $current;
                }
            }
        }

        return null;
    }

    private function buildPath($start, $goal) {
        $path = [$goal];
        $current = $goal;

        while ($current != $start) {
            $current = $this->cameFrom[$current];
            $path[] = $current;
        }

        return array_reverse($path);
    }
}