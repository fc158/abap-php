# abap-php
ABAP scripting - 
SAP and PHP: An easy way for SD sales order entry

This repository collects the code described in the SAP community network blog
http://scn.sap.com/people/flavio.ciotola3/blog/2006/09/19/sap-and-php-an-easy-way-for-sd-sales-order-entry

This work is based on the SAPRFC extension module for php.
The file eoe.php is the main page to be opened in the web browser. File config.php is dealing with mySQL connection, while the file bapi_salesorder_createfromdat2.php manages the SAP system connection and the calls to the BAPI's.
