# BackpackUI1

Style CRUD of Backpack Generator UI

## Prerequisite

Need to install Backpack to your Laravel project first following [this instruction](https://backpackforlaravel.com/docs/3.5/installation)

## Installation

Via Composer

``` bash
$ composer require laraviet/backpackui1
```

## Usage

In generated CRUD Controller, add below line into end of setup() method

```
$this->crud->setListView('backpackui1::theme.list');
```