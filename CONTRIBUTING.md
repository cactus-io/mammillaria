# Contributing to Cactus IO

Welcome! As a [Cactus IO](https://cactus-io.viraweb123.ir) project,
you can follow the [Cactus contributor guide](http://cactus-io.viraweb123.ir/wb/blog/content-contributor).

## Setting up a development environment

JupyterHub requires PHP >= 7.4

As a PHP project, a development install of php follows standard practices for the basics (steps 1-2).


1. clone the repo
    ```bash
    git clone https://github.com/cactus-io/mammillaria
    ```
2. do a development install with php composer

    ```bash
    cd mammillaria
    composer install
    ```
3. install the development requirements,
   which include things like docker tools

## Contributing

Cactus has adopted automatic code formatting so you shouldn't
need to worry too much about your code style.
As long as your code is valid,
the pre-commit hook should take care of how it should look.
You can invoke the pre-commit hook by hand at any time with:

```bash
vendor/php/pre-commit run
```

which should run any autoformatting on your code
and tell you about any errors it couldn't fix automatically.
You may also install [black integration](https://github.com/psf/black#editor-integration)
into your text editor to format code automatically.

If you have already committed files before setting up the pre-commit
hook with `pre-commit install`, you can fix everything up using
`pre-commit run --all-files`.  You need to make the fixing commit
yourself after that.

## Testing

It's a good idea to write tests to exercise any new features,
or that trigger any bugs that you have fixed to catch regressions.

You can run the tests with:

```bash
vendor/bin/phpunit 
```

