
# Test chat
- Docker
- Laravel 10
- PHP 8.3
- MySQL 8
- Pusher with local server
- Supervisor
- Horizon
- Vue 3 with Inertiajs
## Example user with message history
- example@gmail.com
- password
## Run/down docker containers
- make up
- make down
## Build project(composer install, migrations, seeders...)
- make clean
- go to http://localhost
## Run tests
- make test
## Full make commands
- make build - build docker containers
- make up - run docker containers
- make down - down docker containers
- make clean refresh project
- male composer - update && install packages
- make key - generate encryption key
- make optimize - clear cache, config, views
- make fresh - refresh migrations
- nake npm-i - install node_modules
- npm-dev - npn run dev
- npm-build - npm run build
- make test - run tests
