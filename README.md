## JB-HiFi Warranty Application

#### About:
This is a php web application to submit warrantys to JB-HiFi.
I reverse engineered the source from their own [online portal](https://portal.nn.net.au/warranty/warrantyreq.php) to create an easier to use interface.

#### Features:

* Active directory integration (LDAP) for user login
* Lite database stored in plaintext within the main directory - no sql required

#### Prerequisites:
* PHP 4
* php_ldap.dll (uncomment from php.ini)

#### Configuration:
Edit config.php to update your organisation details (you can use the [existing portal](https://portal.nn.net.au/warranty/warrantyreq.php) to confirm these details).
Your organisation id is a unique identifier within the JB-HiFi system, you can inquire by phone/email for this ID but i recommend simply view-sourcing the [existing portal](https://portal.nn.net.au/warranty/warrantyreq.php) after it auto-populates.
Make sure you enter your domain infomation so you can login, if requested i could make this authentication method toggleable. The different organisational units differentiate between a regular user who can submit and job and an admin that can add/delete the models.
The jobid is an existing job from the JB-HiFi system used to authenticate against the server so we can retreive a listing of all jobs.

#### How to use:
Login to the system using an network admin account (setup in config.php).
Add a warrantable model to the list by pressing "Add new model".
Select an image from your computer for the model, or leave blank for a default image.
Add the computer model name, such as "L430".
Add the computer model ID (this is different from the model name, you will find this near the serial of a device or by asking your vendor).
If the computer model is from the Notebook for Teachers program, tick the box or otherwise leave it blank.
You can now delete the example model.

To submit a job, from the main index click on the model you wish to log a job for.
Input the device serial, select the main component that is likely to be replaced and then a brief description of the warranntable issue.
Press submit and the job will be sent to JB-HiFi. The next page you see will have the job ID for tracking.


#### Support:
**Please direct all your questions to the GitHub issue tracker:** 
https://github.com/mattkrins/JB-HiFi-Warranty/issues