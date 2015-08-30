Tabular CLI
===========

This is a simple CLI for the PHPBench
[Tabular](https://github.com/phpbench/tabular) library.

Tabular is a library for generating tabular reports from XML files.

## Example usage

````bash
$ php bin/tabular report examples/phpbench/phpbench.xml examples/phpbench/report.json
````

![results](https://cloud.githubusercontent.com/assets/530801/9567716/a1773168-4f35-11e5-964a-460b45e60be7.png)

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
