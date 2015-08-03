#Tev Label TYPO3 Extension

[![Latest Stable Version](https://poser.pugx.org/3ev/tev_label/version)](https://packagist.org/packages/3ev/tev_label) [![License](https://poser.pugx.org/3ev/tev_label/license)](https://packagist.org/packages/3ev/tev_label)

> Allows management of functional labels through the database and list views.

##Installation

```
$ composer require "3ev/tev_label"
```

##Usage

`tev_label` provides an import script and view helper to use labels.

###Import labels from .ini files

Labels should site in a folder called `/data/translate/site_name`, which should
be a directory above your TYPO3 installation. Inside the folder, you should create
one `.ini` for each locale. For example:

```
- data
    - translate
        - site_name
            - en.ini
            - fr.ini
- htdocs
    - typo3
```

Each `.ini` file should contain labels like:

```ini
my.label.one = "First label"
my.label.two = "Second label with :marker"
```

###Commands

####label:import

```sh
Import labels to the database.

COMMAND:
  tev_label:label:import

USAGE:
  ./cli_dispatch.phpsh extbase label:import <site> <locale> <storage>

ARGUMENTS:
  --site               Name of folder containing labels in data/translate
  --locale             Local of labels to import e.g en/de. Maps to ini file
                       name (en.ini/de.ini)
  --storage            Storage folder ID to import to
```

####label:list

```sh
List labels and keys.

COMMAND:
  tev_label:label:list

USAGE:
  ./cli_dispatch.phpsh extbase label:list <site> <locale>

ARGUMENTS:
  --site               Name of folder containing labels in data/translate
  --locale             Local of labels to import e.g en/de. Maps to ini file
                       name (en.ini/de.ini)
```

###View helpers

There is a single view helper available, which will render a label from the database:

```xml
{namespace tvl=Tev\TevLabel\ViewHelpers}

<!-- "First Label" -->
<tvl:label key="my.label.one" />

<!-- Second label with marker replaced -->
<tvl:label key="my.label.one" markers="{_marker: 'marker replaced'}" />
```

###Normal helpers

Functions same as the view helper but can be used in controllers and other php files.

Inject the helper class

```php
/**
 * @var \Tev\TevLabel\Utility\Label
 * @inject
*/
protected $label;
```
Use the get() method
```php
$this->label->get($key, $markers);
```

##License

MIT © 3ev
