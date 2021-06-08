# cellchess.com

This is the code for a website on which you can play a simple game I made up based on cellular automata (think Conway's Game of Life).

## How to install

Download the repo and place the code in the "html" folder in the root of your web server (I don't have instructions for how to set up a server here but if you're trying to build this I assume you have experience. Just make sure that it's capable of interpreting php and that the "index.php" file will be served to the user when they visit the directory).

Start your favorite distribution of MySQL and make sure it's running. Run the SQL command in "build/cellchess.sql" to create the database structure the site uses to keep track of users and their games.

You should now be able to visit the site at whatever location you supplied your web server with. The index displays a bare-bones HTML form with areas to register, login, and play.

![Screen shot](/screenshots/ss1.png?raw=true)
