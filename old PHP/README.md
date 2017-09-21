Common Ledger - Developer Task - Intuit Integration
===================================================

Scenario
----------

One of our less experienced developers has been tasked with creating a "Quick Books Online Data Explorer". Essentially we want to be able to explore the data for each of our QuickBooks Online clients from one place using the API access tokens we already have for them stored in our system.

The application that our developer has put together is very bare-bones and a bit of a mess.

The intention of the application is to be similar to the QBO API Explorer (https://developer.intuit.com/v2/apiexplorer?apiname=V3QBO)

Ideally we would be able to read and query all of the QBO API endpoints, we don't need to be able to create and update but that would be a bonus.

You are tasked with taking over the project and making it a well structured, full featured application.

We are looking for you to implement a best practices solution.

You can choose whether you use a framework on the front and backend... or don't... you have full creative control. Feel free to choose a different language if you’re not comfortable in PHP.


Setup
-------

Go to this url: 'https://developer.intuit.com/' and register a new account.

When prompted select the 'QuickBooks Online' platform.

Once registered create a new app by clicking on the 'Select APIs' button in the 'Just Start Coding' pane and select the Accounting API.

When your app is created, you'll be taken to the 'My Apps' dashboard where you can select your new app.

Under the 'Keys' tab on your app dashboard you'll see your development client keys as well as redirect URIs.

Click on the 'Add URI' link and add 'http://localhost:8080?action=oauth_callback' to your Redirect URIs, this will allow your local app to authenticate.

That's it, you should be set to use this app with your test now.

Information
-------------

The application is currently setup to be run with the built in PHP server by running the command 'php -S localhost:8080 index.php' from this directory.
