# ChestFinder
[![](https://poggit.pmmp.io/shield.state/ChestFinder)](https://poggit.pmmp.io/p/ChestFinder)
[![](https://poggit.pmmp.io/shield.dl.total/ChestFinder)](https://poggit.pmmp.io/p/ChestFinder)

## Description
Allows you to define a special item that displays the distance between you and the nearest chest, as well as the number of chests within the defined radius.

All this with a simple and complete configuration.

## Installation
- [GitHub releases](https://github.com/Bluzzi/ChestFinder/releases)
- [Poggit](https://poggit.pmmp.io/p/ChestFinder)

## Configuration
### Base
| Property         | Description                                                                              | Default |
| ---------------- | ---------------------------------------------------------------------------------------- | ------- |
| id               | The id and meta of the item                                                              | 455:0   |
| message-position | Message position (popup, tip or title)                                                   | popup   |
| radius           | The radius of detection                                                                  | 70      |
| detection        | The blocks can be detected (chest, trapped_chest, ender_chest, hopper, barrel, shulker)  | chest   |
| repeat           | The time between each search in seconds (the lower it is, the more risk there is of lag) | 2       |

### Messages
Tags:
- ``{chestCount}`` to indicate the number of vaults around the player.
- ``{chestDistance}`` to indicate the distance between player and the chest.
- ``{lineBreak}`` to make a line break.
 
| Property       | Content                                                                                                           |
| -------------- | ----------------------------------------------------------------------------------------------------------------- |
| no-chest       | No chest around you                                                                                               |
| chest-detected | There are {chestCount} chest(s) near you...{lineBreak}The closest chest near you is at {chestDistance} block(s) ! |

## Contribution
You can open a issue or a pull request.