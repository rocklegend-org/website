[![GitHub issues](https://img.shields.io/github/issues/rocklegend-org/website.svg)](https://github.com/rocklegend-org/website/issues)
# rocklegend
A free and now also open source (GPLv3) online music game.

__This README is a work in progress.__

__Important:__ The code in this repository is not representative for any best practices of development. It's a side project that grew from a small idea to a project where I could try out new things and at the same time create something entertaining for me and hundreds (now thousands) of other people around the world.

### Installation
rocklegend was not built as a open source project at first. Documentation
is sparse and it's not too easy to set up the project and start to work on it.

These are rough steps which you need to take:

- Create a ```.env``` file based on the ```example.env``` and update the data for database etc.
- Run the following commands:
```
cd rocklegend
composer install
php artisan migrate
php artisan db:seed
cd build-tools
npm i
cd ../public/assets
npm i
cd ../games/note-highway/develop/player
npm i
cd ../editor
npm i
cd ../../../build-tools
grunt hub
```

### Why on earth do I need to ```npm i``` FOUR times ?
Due to the way the project grew and the fact that I learned many things on the go while developing it, I started with a completely splitted structure for assets, the player and the editor - I never had time to clean this mess up. the ```grunt hub``` command was the only thing which I invested some time in because it sucked a lot that I had to ```grunt watch``` each of these parts separately.

### Contributing

Pull Requests are very welcome!

If you find any issues, please report them via [Github Issues](https://github.com/rocklegend-org/website/issues).

### License
(GPLv3)
