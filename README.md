[![](https://poggit.pmmp.io/shield.state/ChestFinder)](https://poggit.pmmp.io/p/ChestFinder)
[![](https://poggit.pmmp.io/shield.dl.total/ChestFinder)](https://poggit.pmmp.io/p/ChestFinder)

# ChestFinder
### Description:
Detects the number of chests around you and tells you the number of blocks between you and the nearest one.

### Configuration:
#### Base config
| Property | Description | Default |
|---|---|---|
| id | The id and meta of the item | 455:0 | 
| radius | The radius of detection | 70 |
| repeat | The time between each search in seconds (the lower it is, the more risk there is of lag) | 2 |

#### Messages
Tags:
- {chestCount} to indicate the number of vaults around the player.
- {chestDistance} to indicate the distance between player and the chest.
- {lineBreak} to make a line break.
 
| Property | Content |
|---|---|
| no-chest | No chest around you |
| chest-detected | There are {chestCount} chest(s) near you...{lineBreak}The closest chest near you is at {chestDistance} block(s) ! |
