# Messo
A Simple System with Login and Social Logins using OAuth Authentication

# Requirements
```
PHP >= 7.4.29  
MySQL >= 15.1
```

# Tokens

All Tokens and IDs are location on a configuration file: ```services/config.php```

# Dev Accounts

Get your tokens and ids here:

- [LinkedIn Developer Account](https://www.linkedin.com/developers/login)<br>
- [Microsoft Developer Account](https://portal.azure.com/#home)<br>
- [Facebook Developer Account](https://developers.facebook.com/apps/)<br>
- [Google Developer Account](https://console.cloud.google.com/)


# Redirect URIs

Some of the Redirect URIs has a ```GET``` parameters and they are required to be add on your developer portal account and some of them are not required to add.

```
http://localhost/views/
http://localhost/views/sign-up-form.php

http://localhost/views/?using={provider here}
http://localhost/views/sign-up-form.php?using={provider here}
```
NOTE: You must include a provider when using the ```using``` parameter.<br>
Example: ```http://localhost/views/sign-up-form.php?using=google```

