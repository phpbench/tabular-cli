Tabular CLI
===========

![travis](https://travis-ci.org/phpbench/tabular-cli.svg?branch=master)

This is a simple, demonstration, CLI for the PHPBench
[Tabular](https://github.com/phpbench/tabular) library.

Tabular is a library for generating tabular reports from XML files.

## Example usage

Check the examples in the `examples` folder of this repository, usage as
follows:

````bash
$ php bin/tabular report examples/books/books.xml examples/books/report.json
````

![tabular-cli-phpbench](https://cloud.githubusercontent.com/assets/530801/9567802/fee58ac8-4f37-11e5-837e-11fe57454066.png)

## Definition file

The following is the [Tabular](https://github.com/phpbench/tabular) definition
for the report:

````javascript
{
    "classes": {
        "euro": [
            [ "printf", {"format": "<info>€</info>%2d"} ]
        ]
    },
    "rows": [
        {
            "group": "body",
            "cells": [
                {
                    "name": "Title",
                    "expr": "string(./title)"
                },
                {
                    "name": "Stock",
                    "expr": "string(./stock)"
                },
                {
                    "name": "Price",
                    "class": "euro",
                    "expr": "number(./price)"
                },
                {
                    "name": "Author",
                    "expr": "string(./author)"
                },
                {
                    "name": "Stock Value",
                    "class": "euro",
                    "expr": "number(./price) * number(./stock)"
                }
            ],
            "with_query": ".//book"
        },
        {
            "cells": []
        },
        {
            "group": "footer",
            "cells": [
                {
                    "name": "Stock",
                    "literal": "Sum >>"
                },
                {
                    "name": "{{ cell.item }}",
                    "class": "euro",
                    "expr": "sum(//group[@name='body']//cell[@name='{{ cell.item }}'])",
                    "pass": 2,
                    "with_items": [ "Price", "Stock Value" ]
                }
            ]
        }
    ]
}
````
