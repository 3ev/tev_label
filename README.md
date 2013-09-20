# 3ev Label TYPO3 Extension

**Version:** 1.0.0

Allows management of functional labels through the database and list views.

## Installation

Install into TYPO3 with Composer. Add the following config to your `composer.json`:

```json
{
    "require": {
        "3ev/tev_label": "master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/3ev/tev_label"
        }
    ]
}
```

If your `composer.json` sits outside of your TYPO3 directory, you'll need to add:

```json
{
    "extra": {
        "installer-paths": {
            "path/to/typo3/typo3conf/ext/{$name}/": ["type:typo3-cms-extension"]
        }
    }
}
```

## Usage

`tev_label` provides an import script and view helper to use labels.

### Import labels from `.ini` files

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

### Commands

#### label:import

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

#### label:list

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

### View helpers

There is a single view helper available, which will render a label from the database:

```xml
{namespace tvl=Tev\TevLabel\ViewHelpers}

<!-- "First Label" -->
<tvl:label key="my.label.one" />

<!-- Second label with marker replaced -->
<tvl:label key="my.label.one" markers="{':marker': 'marker replaced'}" />
```

## Dependencies

- [TYPO3 Fluid Extensions](https://github.com/FluidTYPO3)
- [tev](https://github.com/3ev/tev_label)
