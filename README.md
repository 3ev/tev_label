#Tev Label TYPO3 Extension

[![Latest Stable Version](https://poser.pugx.org/3ev/tev_label/version)](https://packagist.org/packages/3ev/tev_label) [![License](https://poser.pugx.org/3ev/tev_label/license)](https://packagist.org/packages/3ev/tev_label)

> Allows management of functional labels through the database and list views.

##Installation

```
$ composer require "3ev/tev_label"
```

##Usage

Install the TYPO3 extension through the Extension Manager. You'll then be able
to add Labels from the List View. Each label has a key and a value. We recommend
using the `this.is.my.label` structure for keys, to mirror TYPO3's built in
translation APIs. You can add Labels to any storage folder or page - they will
be found globally.

###View Helpers

Tev Label is intended for use in Fluid templates. It provides a single view
helper, with which you can fetch a label and include it in your template:

```xml
{namespace tvl=Tev\TevLabel\ViewHelpers}

<!-- "First Label" -->
<tvl:label key="my.label.one" />

<!-- Second label, with markers replaced -->
<tvl:label key="my.label.one" markers="{_marker: 'marker replaced'}" />
```

The `markers` array is a simple replacement for sections in your label. We
recommend the convention of prefixing any markers in your labels with a single
underscore.

###Label Manager

If needed, you can an inject an instance of `Tev\TevLabel\LabelManager` into your
Extbase classes. Instances of this class provide a `->get($key, $makers)` method,
which is identical in functionality to the view helper.

###Import labels from .ini files

If you've got a set of labels you want to quickly import into TYPO3, you can do
so from the CLI using a `.ini` file of the structure:

```ini
my.label.one = "First label"
my.label.two = "Second label with _marker"
```

You can then run:

```
$ cli_dispatch.phpsh extbase label:import </path/to/labels.ini> <storage_folder_uid>
```

This command will import all of the labels in the given file to the given Storage
Folder. However, **existing labels will not be overriden** - only new labels will
be imported.

##License

MIT © 3ev
