Shipping methods
----------------

After `installing the module`_, log in to your Magento® admin panel and navigate here:

::

    Configuration -> Sales -> Shipping methods -> DHL Express

Set the following configuration:

Checkout Presentation
~~~~~~~~~~~~~~~~~~~~~

* *Enabled*: Set this to "Yes" to use the module and display DHL Express in the checkout.
* *Sort Order*: Enter a number into this field to control the sorting of shipping methods
  in the checkout (optional).
* *Title*: Set the shipping method title which will be displayed in the checkout if
  the DHL logo is not shown (see below).
* *Display DHL Logo*: Select if the DHL logo should be shown in the checkout.
* *Display Estimated Delivery Date*: Select if the estimated delivery date should be shown
  in the checkout. The date is calculated based on the expected shipping date.
* *Applicable Countries*: Activate this checkbox if you want to limit the allowed destination
  countries. The countries can be selected in the box below.
* *Allow for Specific Countries*: Select one or more allowed destination countries. This will
  override the default Magento® setting in "Configuration -> General -> Country Options".
* *Show Method if Not Applicable*: Activate this checkbox if the shipping method should be
  visible even if it cannot be used. A message for the customer can be configured in the box
  below.
* *Unavailability Message*: Enter a message which will be displayed if the shipping method
  cannot be used.

API Settings
~~~~~~~~~~~~

* *Username*: Enter the API username which you received from DHL Express.
* *Password*: Enter the password for the above API username.
* *Account number*: Enter your DHL Express account number.
* *Enable Logging*: Activate this to write messages to the log file in ``var/log``. Select
  the log level via the options below:

  * *Error*: Only serious errors will be logged.
  * *Info*: Errors and warnings will be logged.
  * *Debug*: Log everything, including all API communication. This setting will create very
    large log files over time. **Only recommended for troubleshooting!**

.. admonition:: Log file

   Make sure to clear or archive the log file regularly. The module does not delete the log
   automatically. Personal data must only be stored as long as absolutely necessary. See also
   the section `Data protection`_.

Package Insurance
~~~~~~~~~~~~~~~~~

* *Package Insurance*: Enable this to configure possible insurance charges for shipping rates
  displayed in the checkout.
* *Minimum Cart Value*: If the cart value is equal to this or higher, shipping insurance will
  automatically be applied.

Rates Request Settings
~~~~~~~~~~~~~~~~~~~~~~

* *Allowed International Products*: Limit which international DHL Express products should be
  available in the checkout.
* *Allowed Domestic Products*: Limit which domestic DHL Express products should be available in
  the checkout.
* *Order Cut-off Time*: Orders which are placed before this time are expected to ship on the same
  day; orders placed afterwards are expected to ship on the following day. Holidays and weekends
  (globally between shipment origin and destination) are taken into account.
* *Regular Pickup*: Enable this if you have an agreement with DHL Express about regular pickups
  (e.g. every day at a fixed time).
* *Pickup/Handover Time*: Set the time at which shipments are regularly handed over to or picked
  up by DHL.
* *Terms of Trade*: Select one of these options:

  * *DDP*: Delivered Duty Paid. The seller is responsible for delivering the goods to the
    destination, and pays all costs in bringing the goods to the destination, including import
    duties and taxes.
  * *DDU*: Delivered Duty Unpaid. The seller bears the risks and costs (transportation and customs
    clearance expenses) associated with supplying the goods to the delivery location. The
    buyer is responsible for paying the duty and taxes.

* *Customize Checkout Rates*: Enable this if you want to modify the rates shown in the checkout,
  e.g. by adding handling fees or providing discounts.

  Options for `International Rates Calculation`_ and `Domestic Rates Calculation`_ will be
  displayed below if this is enabled.

.. raw:: pdf

   PageBreak

International Rates Calculation
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Only visible if "Customize Checkout Rates" is enabled in `Rates Request Settings`_.

* *Modify International Rates*: Enable this if you want to add handling fees for international
  shipments to the rates.
* *Calculate Handling Fee*: Select if the handling fee should be added as a fixed amount, or
  calculated as a percentage offset.
* *Handling Fixed Fee*: Enter a fixed amount. Positive value will add a fee, negative value
  creates discount.
* *Handling Percentage Fee*: Enter a percentage. Positive value will add a fee, negative value
  creates discount. Omit the percentage-sign.


Domestic Rates Calculation
~~~~~~~~~~~~~~~~~~~~~~~~~~

Only visible if "Customize Checkout Rates" is enabled in `Rates Request Settings`_.

* *Modify Domestic Rates*: Enable this if you want to add handling fees for domestic
  shipments to the rates.
* *Calculate Handling Fee*: Select if the handling fee should be added as a fixed amount, or
  calculated as a percentage offset.
* *Handling Fixed Fee*: Enter a fixed amount. Positive value will add a fee, negative value
  creates discount.
* *Handling Percentage Fee*: Enter a percentage. Positive value will add a fee, negative value
  creates discount. Omit the percentage-sign.

Round prices
~~~~~~~~~~~~

Only visible if "Customize Checkout Rates" is enabled in `Rates Request Settings`_.

* *Rounding Mode*: Select if and how the shipping rates should be rounded.
* *Rounding Options*: Select one of these options:

  * *Integer*: Round to full integer value, e.g. "12.00".
  * *Decimal value*: Round to the configured decimal value, e.g. "XX.95".

* *Decimal value*: Enter the decimal value for rounding, e.g. "95" . Omit the decimal point.

Free Shipping
~~~~~~~~~~~~~

Only visible if "Customize Checkout Rates" is enabled in `Rates Request Settings`_.

* *Configure Free Shipping*: Enable this if you want to offer free shipping via DHL Express.

  Options for `International Free Shipping`_ and `Domestic Free Shipping`_ will be displayed
  below if this is enabled.
* *Include Virtual Products in Price Calculation*: Enable this if virtual products should be
  considered for free shipping.

.. raw:: pdf

   PageBreak

International Free Shipping
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Only visible if "Configure Free Shipping" is enabled in `Free Shipping`_.

* *Free Shipping Available For*: Select the allowed products for free shipping.
* *Free Shipping Minimum Order Amount*: Enter the minimum value of the shopping cart required for free shipping.
  Leaving this empty will disable international free shipping.

Domestic Free Shipping
~~~~~~~~~~~~~~~~~~~~~~

Only visible if "Configure Free Shipping" is enabled in `Free Shipping`_.

* *Free Shipping Available For*: Select the allowed products for free shipping.
* *Free Shipping Minimum Order Amount*: Enter the minimum value of the shopping cart required for free shipping.
  Leaving this empty will disable domestic free shipping.

Shipping settings
-----------------

Log in to your Magento® admin panel and navigate here:

::

    Configuration -> Sales -> Shipping settings -> Origin

Set the full address of your shop here:

* Country
* Region / state
* ZIP code
* City
* Street address
