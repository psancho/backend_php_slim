# Template for API backend

## Quick start

```bash
# fork it into new project
# clone the new project repo
git clone https://git.takoma.fr/my/new/project/api.git api

# change directory to your app
cd api

# install the PHP dependencies with composer or npm
composer install
```

## License

[MIT](./LICENCE)

## Unit tests

To lauch unit tests, assuming the docker container can find the project at `/home/docker/dev/takoma/templates/phpSlim`,
launch the following command:

* Linux:

```bash
docker exec -ti php72_apache \
    /home/docker/dev/takoma/templates/phpSlim/vendor/bin/phpunit \
    /home/docker/dev/takoma/templates/phpSlim/tests/unit --testdox
```

* Windows:

```bash
docker exec -ti php72_apache `
    /home/docker/dev/takoma/templates/phpSlim/vendor/bin/phpunit `
    /home/docker/dev/takoma/templates/phpSlim/tests/unit --testdox
```
