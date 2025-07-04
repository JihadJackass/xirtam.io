// javascript-astar
// http://github.com/bgrins/javascript-astar
// Freely distributable under the MIT License.
// Implements the astar search algorithm in javascript using a binary heap.

/*
	@example:

		AstarSearch([
					[1,1,1,1],
					[0,1,1,0],
					[0,0,1,1]
				], [0,0], [2,3]);
*/

var AStarSearch = function(grid, start, end) {
	if (start.length !== 2 || end.length !== 2)
		return;
	
	var GraphNodeType = { 
		OPEN: 0, 
		WALL: 1
	};
	
	// Creates a Graph class used in the astar search algorithm.
	function Graph(grid) {
		var nodes = [];
	
		for (var x = 0; x < grid.length; x++) {
			nodes[x] = [];
			
			for (var y = 0, row = grid[x]; y < row.length; y++) {
				nodes[x][y] = new GraphNode(x, y, row[y]);
			}
		}
	
		this.input = grid;
		this.nodes = nodes;
	}
	
	Graph.prototype.toString = function() {
		var graphString = "\n";
		var nodes = this.nodes;
		var rowDebug, row, y, l;
		for (var x = 0, len = nodes.length; x < len; x++) {
			rowDebug = "";
			row = nodes[x];
			for (y = 0, l = row.length; y < l; y++) {
				rowDebug += row[y].type + " ";
			}
			graphString = graphString + rowDebug + "\n";
		}
		return graphString;
	};
	
	function GraphNode(x,y,type) {
		this.data = { };
		this.x = x;
		this.y = y;
		this.pos = {
			x: x, 
			y: y
		};
		this.type = type;
	}
	
	GraphNode.prototype.toString = function() {
		return "[" + this.x + " " + this.y + "]";
	};
	
	GraphNode.prototype.isWall = function() {
		return this.type == GraphNodeType.WALL;
	};
	
	var astar = {
		init: function(grid) {
			for(var x = 0, xl = grid.length; x < xl; x++) {
				for(var y = 0, yl = grid[x].length; y < yl; y++) {
					var node = grid[x][y];
					node.f = 0;
					node.g = 0;
					node.h = 0;
					node.cost = node.type;
					node.visited = false;
					node.closed = false;
					node.parent = null;
				}
			}
		},
		heap: function() {
			return new BinaryHeap(function(node) { 
				return node.f; 
			});
		},
		search: function(grid, start, end, diagonal, heuristic) {
			astar.init(grid);
			heuristic = heuristic || astar.manhattan;
			diagonal = !!diagonal;
	
			var openHeap = astar.heap();
	
			openHeap.push(start);
	
			while(openHeap.size() > 0) {
	
				// Grab the lowest f(x) to process next.  Heap keeps this sorted for us.
				var currentNode = openHeap.pop();
	
				// End case -- result has been found, return the traced path.
				if(currentNode === end) {
					var curr = currentNode;
					var ret = [];
					while(curr.parent) {
						ret.push(curr);
						curr = curr.parent;
					}
					return ret.reverse();
				}
	
				// Normal case -- move currentNode from open to closed, process each of its neighbors.
				currentNode.closed = true;
	
				// Find all neighbors for the current node. Optionally find diagonal neighbors as well (false by default).
				var neighbors = astar.neighbors(grid, currentNode, diagonal);
	
				for(var i=0, il = neighbors.length; i < il; i++) {
					var neighbor = neighbors[i];
	
					if(neighbor.closed || neighbor.isWall()) {
						// Not a valid node to process, skip to next neighbor.
						continue;
					}
	
					// The g score is the shortest distance from start to current node.
					// We need to check if the path we have arrived at this neighbor is the shortest one we have seen yet.
					var gScore = currentNode.g + neighbor.cost;
					var beenVisited = neighbor.visited;
	
					if(!beenVisited || gScore < neighbor.g) {
	
						// Found an optimal (so far) path to this node.  Take score for node to see how good it is.
						neighbor.visited = true;
						neighbor.parent = currentNode;
						neighbor.h = neighbor.h || heuristic(neighbor.pos, end.pos);
						neighbor.g = gScore;
						neighbor.f = neighbor.g + neighbor.h;
	
						if (!beenVisited) {
							// Pushing to heap will put it in proper place based on the 'f' value.
							openHeap.push(neighbor);
						}
						else {
							// Already seen the node, but since it has been rescored we need to reorder it in the heap
							openHeap.rescoreElement(neighbor);
						}
					}
				}
			}
	
			// No result was found - empty array signifies failure to find path.
			return [];
		},
		manhattan: function(pos0, pos1) {
			// See list of heuristics: http://theory.stanford.edu/~amitp/GameProgramming/Heuristics.html
	/*
			var d1 = Math.abs (pos1.x - pos0.x);
			var d2 = Math.abs (pos1.y - pos0.y);
			return d1 + d2;
			*/
			var D = 1;
			var D2 = 1.4*D;
			var h_diagonal = Math.min(Math.abs(pos1.x-pos0.x), Math.abs(pos1.y-pos0.y));
			var h_straight = (Math.abs(pos1.x-pos0.x) + Math.abs(pos1.y-pos0.y));
			return D2 * h_diagonal + D * (h_straight - 2 * h_diagonal);
			
		},
		neighbors: function(grid, node, diagonals) {
			var ret = [];
			var x = node.x;
			var y = node.y;
	
			// West
			if(grid[x-1] && grid[x-1][y]) {
				ret.push(grid[x-1][y]);
			}
	
			// East
			if(grid[x+1] && grid[x+1][y]) {
				ret.push(grid[x+1][y]);
			}
	
			// South
			if(grid[x] && grid[x][y-1]) {
				ret.push(grid[x][y-1]);
			}
	
			// North
			if(grid[x] && grid[x][y+1]) {
				ret.push(grid[x][y+1]);
			}
	
			if (diagonals) {
	
				// Southwest
				if(grid[x-1] && grid[x-1][y-1]) {
					ret.push(grid[x-1][y-1]);
				}
	
				// Southeast
				if(grid[x+1] && grid[x+1][y-1]) {
					ret.push(grid[x+1][y-1]);
				}
	
				// Northwest
				if(grid[x-1] && grid[x-1][y+1]) {
					ret.push(grid[x-1][y+1]);
				}
	
				// Northeast
				if(grid[x+1] && grid[x+1][y+1]) {
					ret.push(grid[x+1][y+1]);
				}
	
			}
	
			return ret;
		}
	};
	
	var graph = new Graph(grid);
	var path = astar.search(graph.nodes, graph.nodes[start[0]][start[1]], graph.nodes[end[0]][end[1]], true);
	var retpath = [];
	for (var i=0; i<path.length; i++) {
		retpath.push([path[i].x, path[i].y]);
	}
	return retpath;
};