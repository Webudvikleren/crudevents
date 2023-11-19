

## Requirements
The package views uses Bootstrap 5. 

The package assumes you have a layout-file `layout.app` that can be extended. In your layout-file you also have the following sections: 

* content
  * The main content of the webpage.
* css
  * Section in the header to inject CSS scripts. 
* meta_description
  * The description of your webpage.
* meta_title
  * The title of your webpage. 
* scripts
  * Section in the bottom of the webpage for Javascript and other stuff.

## Installation

> composer require webudvikleren/crudevents

Add the following in your `config/app.php` under providers. 

```
Webudvikleren\CrudEvents\Providers\CrudEventsProvider::class
```

> php artisan vendor:publish --tag=crudevents-assets

## Usage

Add something like this to your `routes/web.php`:
```
<?php
use Webudvikleren\CrudEvents\Controllers\AdminCrudEventController;

Route::controller(AdminCrudEventController::class)->middleware('can:event crud')->name('admin.crudevents.')->prefix('admin/events')->group(function () {
	Route::get('', 'index')->name('index');
	Route::get('create', 'create')->name('create');
	Route::post('create', 'store');
	Route::get('{id}/redit', 'edit')->name('edit');
	Route::post('{id}/edit', 'update');
	Route::get('{id}/delete', 'delete')->name('delete');
});
```

`AdminCrudEventController` can be extended with custom controllers. 