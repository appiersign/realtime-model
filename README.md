# Realtime Model
This package enables you to sync laravel models with Google Cloud Firestore. This packages works with an internally
developed API that uses the gprc PHP extension to seamlessly connect your PHP backend to Firestore.

## Installation
`composer require appiersign/realtime-model`

### Configuration
Add the realtime model service provider 'providers' array in your `config/app.php` file.

[   
   ...   
   `AppierSign\RealtimeModel\Providers\RealtimeModelServiceProvider::class`
   
]

Add `"AppierSign\\RealtimeModel\\": "vendor/appiersign/realtime-model/src"` to the `autoload.psr-4` object in your `composer.json` file


### Usage

To automatically sync data to firestore, just add the `RealtimeModel` trait to the desired model.
This will automatically sync all model attributes to Firestore whenever a new model is created or updated.

To define which fields or attributes to sync, define the `toRealtimeData()` public method 
on the model like this:

```
public function toRealtimeData(): array
{
    return [
        'externalId' => $this->external_id,
        'fullName' => $this->full_name,
        'phone' => $this->phone,
        'username' => $this->username
    ];
}
```
#### Setting Key
To set the id or primary/unique key for the model, override the `getSyncKey()` public method
on the model like this:

```
public function getSyncKey(): string
{
    return 'externalId';
}
```

The package uses the plural form of the model name as the suffix of the collection
name to change this, override the `collection()` public method
on the model like this:

```
public function collection(): string
{
    return 'premium_users';
}
```
