# Minimalistic JSON document storage

Store JSON document with a simple API, can be useful to store forms or any unstructured data.

## How to use ?

You must use the `StoreService` as you central way to interact with the store. The internal storage currently use Doctrine only, but 
the Storage implement will be pluggable in a futur release. In the service you can use the public methods:

- `StoreService::add` to create a new Document
- `StoreService::update` to update a new Document
- `StoreService::remove` to remove a new Document
- `StoreService::count` to count all Document by type
- `StoreService::paginate` to paginate over all Document by type

A `Document` must have a `label`, a `type` and a JSON serializable payload.

## Event

During the life cycle of the Documents, the following signal are emitted:

- `StoreService::documentAdded`
- `StoreService::documentUpdated`
- `StoreService::documentRemoved`

## Acknowledgments

Development sponsored by [ttree ltd - neos solution provider](http://ttree.ch).

We try our best to craft this package with a lots of love, we are open to sponsoring, support request, ... just contact us.

## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
