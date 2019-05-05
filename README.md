[![](https://poggit.pmmp.io/shield.state/ChestFinder)](https://poggit.pmmp.io/p/ChestFinder)
[![](https://poggit.pmmp.io/shield.dl.total/ChestFinder)](https://poggit.pmmp.io/p/ChestFinder)

# ChestFinder
## Description
Use the defined item to obtain information on the position of the nearest safes: number of blocks between you and the nearest safe, number of safes in the perimeter...), all this easily configurable.

## Installation
You can download the latest version of the plugin in the [releases](https://github.com/Bluzzi/ChestFinder/releases) tab of this repository, or via the [Poggit](https://poggit.pmmp.io/p/ChestFinder/1.3) website.

## Configuration:
### Base config
| Property | Description | Default |
|---|---|---|
| id | The id and meta of the item | 455:0 | 
| message-position | Message position (popup, tip or title) | popup |
| radius | The radius of detection | 70 |
| repeat | The time between each search in seconds (the lower it is, the more risk there is of lag) | 2 |

### Messages
Tags:
- {chestCount} to indicate the number of vaults around the player.
- {chestDistance} to indicate the distance between player and the chest.
- {lineBreak} to make a line break.
 
| Property | Content |
|---|---|
| no-chest | No chest around you |
| chest-detected | There are {chestCount} chest(s) near you...{lineBreak}The closest chest near you is at {chestDistance} block(s) ! |

## Updates
### Releases
You can find all official update in the tab [releases](https://github.com/Bluzzi/ChestFinder/releases), here are the last releases:<br>
- [ChestFinder 1.1](https://github.com/Bluzzi/ChestFinder/releases/tag/1.2)
- [ChestFinder 1.0](https://github.com/Bluzzi/ChestFinder/releases/tag/1.1)
### Future updates
- [ ] Automatic configuration update system.
- [ ] To be able to choose the distance from there it will be indicated the exact distance with the chest (issue #4).
- [ ] Possibility to detect trapped chests, ender chests... and other ?
- [ ] More indication in the console.

## Error or suggestion
You can open a issue in this repositorie.