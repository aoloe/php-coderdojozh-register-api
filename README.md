# CoderDojo Zurich, Registration API

PHP API for the [CoderDojo Zurich, Registration Webapp](https://github.com/aoloe/js-coderdojozh-registration-webapp): it queries the [Meetup API](https://www.meetup.com/meetup_api/) and provides the storage for the participants choices.

## Install

- Checkout this repository
- Run `composer install`
- Create your private settings:  
  `cp src/settings-private-sample.php src/settings-private.php`  
  Fill:
  - `apiKey': you can find your key on the [Meetup API page](https://www.meetup.com/meetup_api/), in the [API Key section](https://secure.meetup.com/meetup_api/key/).
  - `groupName`: the name of your Meetup group, as it appears in the Url, when you browse to your Meetup events:  
    `https://www.meetup.com/<your-group-name>/events/<the-event-id>/`
  - `topic`: at least one item.
  (Since it contains your Meetup API key, you should keep your `src/settings-private` _secret_  and avoid adding it to a public repository.)
  - create the `data` directory.
  - create the `logs` directory.

## Services

- `GET: /event/{id}/rvsps`: list of all participant having registred through Meetup.
- `GET: event/{id}`: information about the event.
- `POST: /event/{eventId}/participant/{userId}`: number of kids for each offer.
