# Effairs

Effairs by MBIT is a TYPO3 11 extension that allows you to create and automatically send newsletters to subscribers. This extension contains two frontend plugins, allowing users to subscribe and unsubscribe to your Service. We are operating the corresponding backend on our own servers. There you can manage your newsletters, as well as your subscribers. If you want to get started with your own account, please contact us at <a href="https://www.mbit.at/kontakt/ihre-anfrage">Mbit Solutions</a>. For more Information, go check out our <a href="https://www.effairs.at/">Effairs Website</a>.

## Installation and Configuration

This extension can be installd via composer: 

```
composer require "mbit/mbit-effairs"
```

The configuration of this extenion can be done by overwriting its constants in your sitepackages constants.typoscript like this:

```
###################
### MBITEFFAIRS ###
###################

plugin.tx_mbiteffairs.settings {
  Captcha = 0
  CaptchaSitekey = sitekey

  OptinPageId = 1
  UnsubscribePageId = 2

  ApiURLOptin = http://api.effairs.at/api/'TenantId'/Contact/OptinEmail
  ApiURLOptout = http://api.effairs.at/api/'TenantId'/Contact/OptoutEmail
  TenantId = 1
  AppKey = xxxxx
  AppSecret = xxxxx
}
```

At the bottom you will find TenantId, AppKey & AppSecret. These identify your Site to the backend, insert the ones we provided. OptinPageId and UnsubscribePageId are the pages your users will be forwarded to when signing up or signing out.   

Setting Captcha to 1 allows you to lock the subscription behind a capcha. It uses Google recaptcha, so beware of european privacy laws. You can get yourself a sitekey through your Google account. 
