<?php

namespace Aozen\Astar;

class Graph {
    private $edges;

    public function __construct() {
        $this->edges = [];
    }

    public function addEdge($startNode, $endNode, $weight) {
        if (!isset($this->edges[$startNode])) {
            $this->edges[$startNode] = [];
        }
        $this->edges[$startNode][$endNode] = $weight;
        if (!isset($this->edges[$endNode])) {
            $this->edges[$endNode] = [];
        }
        $this->edges[$endNode][$startNode] = $weight;
    }

    public function getCost($nodeA, $nodeB) {
        return $this->edges[$nodeA][$nodeB];
    }

    public function heuristic($nodeA, $nodeB) {
        // This method calculates the heuristic distance between two nodes.
        // In this example, we just return 0 since we don't have any additional information
        // about the distances between nodes.
        return 0;
    }

    public function getNeighbors($node) {
        return array_keys($this->edges[$node]);
    }

    public function generatePath($dots, $weight) {
        for ($i = 1; $i <= $dots; $i++) {
            $this->addEdge($i, $i, 0);
            for ($j = $i + 1; $j <= $dots; $j++) {
                $probability = 50;
                if ($dots >= 6 && $dots <= 10) {
                    $probability = 35;
                } elseif ($dots > 10 && $dots <= 20) {
                    $probability = 20;
                } elseif ($dots > 20) {
                    $probability = 5;
                }
                if (rand(0, 99) < $probability) {
                    $this->addEdge($i, $j, $weight);
                    $this->addEdge($j, $i, $weight);
                }
            }
        }
    }

    public function generateImage($filename, $path)
    {
        // Initialize an empty array to hold the vertices
        $vertices = array();
        $count_path = count($path);
        // Loop over each edge to get the vertices
        foreach ($this->edges as $startNode => $edges) {
            foreach ($edges as $endNode => $weight) {
                $vertices[$startNode] = array(rand(0, $count_path * 150), rand(0, $count_path * 150));
                $vertices[$endNode] = array(rand(0, $count_path * 150), rand(0, $count_path * 150));
            }
        }

        // Calculate the maximum coordinates for scaling the image
        $maxX = max(array_column($vertices, 0));
        $maxY = max(array_column($vertices, 1));

        // Scale up the coordinates to increase the area
        $scaleFactor = 2;
        foreach ($vertices as &$vertex) {
            $vertex[0] *= $scaleFactor;
            $vertex[1] *= $scaleFactor;
        }

        // Create a new image
        $image = imagecreate($maxX * $scaleFactor + 50, $maxY * $scaleFactor + 50);

        // Define some colors
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        $green = imagecolorallocate($image, 0, 255, 0);
        $red = imagecolorallocate($image, 255, 0, 0);
        $blue = imagecolorallocate($image, 0, 0, 255);


        // Fill the background with white
        imagefilledrectangle($image, 0, 0, $maxX * $scaleFactor + 50, $maxY * $scaleFactor + 50, $white);

        // Draw the edges
        foreach ($this->edges as $startNode => $edges) {
            foreach ($edges as $endNode => $weight) {
                if (in_array([$startNode, $endNode], $path) || in_array([$endNode, $startNode], $path)) {
                    // Draw path edges in red
                    imageline($image, $vertices[$startNode][0], $vertices[$startNode][1], $vertices[$endNode][0], $vertices[$endNode][1], imagecolorallocate($image, 255, 0, 0));
                } else {
                    // Draw non-path edges in black
                    imageline($image, $vertices[$startNode][0], $vertices[$startNode][1], $vertices[$endNode][0], $vertices[$endNode][1], $black);
                }

                // Draw weight in blue in the middle of the line
                $x = ($vertices[$startNode][0] + $vertices[$endNode][0]) / 2;
                $y = ($vertices[$startNode][1] + $vertices[$endNode][1]) / 2;
                if($weight > 0) {
                    imagestring($image, 3, $x, $y, strval($weight), $blue);
                }
            }
        }

        // Draw the path
        for ($i = 0; $i < count($path) - 1; $i++) {
            $startNode = $path[$i];
            $endNode = $path[$i + 1];
            imageline($image, $vertices[$startNode][0], $vertices[$startNode][1], $vertices[$endNode][0], $vertices[$endNode][1], $red);
        }

        // Draw the vertices with their names in green
        unset($vertex);
        foreach ($vertices as $name => $vertex) {
            $nameX = $vertex[0] + 10;
            $nameY = $vertex[1] - 30;
            imagefilledellipse($image, $vertex[0], $vertex[1], 40, 40, $black);
            imagestring($image, 5, $nameX, $nameY, $name, $green);
        }

        // Save the image to file
        imagepng($image, $filename);

        // Free up memory
        imagedestroy($image);
    }
}