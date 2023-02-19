<?php

namespace Aozen\Astar;

use Aozen\Astar\Graph;

class PathFinder {
    public function createGraph($dots_count = 10, $max_weight = 5) {
        $graph = new Graph();
        $graph->generatePath($dots_count);
        return $graph;
    }
    public function findPath(Graph $graph, $start_point, $end_point) {
        $aStar = new AStar($graph);
        return $aStar->search($start_point, $end_point);
    }

    public function drawPath(Graph $graph, $path) {
        $graph->generateImage(time() . ".png", $path);
    }
}