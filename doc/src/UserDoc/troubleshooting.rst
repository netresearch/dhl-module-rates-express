DHL Express not available in checkout
-------------------------------------

If the DHL Express shipping method is not visible in the checkout, or the
"unavailability message" is shown, please check the following:

* **Is the DHL Express module enabled?**
  
  See the setup guide, section "*Checkout Presentation*".

* **Is the shipping destination in an excluded country?**

  See the setup guide, section "*Checkout Presentation -> Applicable Countries /
  Allow for Specific Countries*".

* **Are the API settings correct?**

  See the setup guide, section "*API Settings*".

* **Are DHL Express products enabled in the module configuration?**

  See the setup guide, section "*Rates Request Settings -> Allowed International /
  Domestic Products*". Note that not all products may be available for a given destination.

* **Is the shipping origin configured correctly in Magento®?**

  See the setup guide, section "*Shipping settings*".

* **Are there any errors in the log?**

  See the setup guide, section "*API Settings -> Enable Logging*". The log file may
  give an explanation why the DHL Express shipping method doesn't work.
