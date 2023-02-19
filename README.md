# PathFinder

Path Finder is a PHP library that helps you find the best path between two points in a randomly generated map. The library uses the A* algorithm to find the shortest path between two points.

## Installation

You can install the package via composer:
`composer require aozen/astar`

## Usage

To use Path Finder, you need to create an instance of the PathFinder class and call its methods to create a random map, find the best path, and generate an image of the map with the best path highlighted.

```php
    use \Aozen\Astar\PathFinder;
```

Example:

```php
$pathFinder = new PathFinder();

// Generate a random graph (map) with 10 dot. Length of roads random between 1 and 5
$graph = $pathFinder->createGraph(10, 5);
// Find the best path from $dot1 to $dot10
$path = $pathFinder->findPath($graph, 1, 10);
// If you want to download visualized result as a .png
$pathFinder->drawPath($graph, $path);
```

The createGraph method takes two arguments: dot count, max line distance between two dot.

The findPath method takes three arguments: the graph, the starting node and the ending node. In the example above, the starting node is 1 and the ending node is 10.

The drawPath method takes two arguments: the graph and the array of nodes that make up the best path.

### Contributors

The following text was written by "ChatGPT" when I prompt "I have a "Contributors" section in my readme.md file.
You wrote lots of code. Add you own message before publish please."

This package was made with the help of ChatGPT, a language model developed by OpenAI. Most of the code in this package was generated automatically using natural language processing, making it easier and faster to develop. ChatGPT can assist in a variety of tasks, such as code generation, content creation, and language translation. To learn more about ChatGPT, please visit the OpenAI website at https://openai.com.
