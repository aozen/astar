<?php

namespace Aozen\Astar;

class PriorityQueue {
    private $nodes = [];

    public function addNode($node, $priority) {
        $this->nodes[] = [$node, $priority];
        usort($this->nodes, function ($a, $b) {
            return $a[1] - $b[1];
        });
    }

    public function getNextNode() {
        return array_shift($this->nodes)[0];
    }

    public function isEmpty() {
        return empty($this->nodes);
    }

    public function hasNode($node) {
        foreach ($this->nodes as $n) {
            if ($n[0] == $node) {
                return true;
            }
        }
        return false;
    }
}