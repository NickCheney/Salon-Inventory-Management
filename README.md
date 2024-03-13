# Salon-Inventory-Management
Source code for a user-friendly LAMP-based web application to manage hair product inventory, purchases and sales at Fringe Hair Salon, Chatham, ON. 

## Background
This project was inspired by the final deliverable of an [Into to Database Management class](https://www.cs.queensu.ca/undergraduate/courses/CISC-332) I took at Queen's, creating a locally-hosted full-stack web app for a hypothetical Animal Rescue Organization with [Apache XAMPP](https://www.apachefriends.org/). With bare-minimum styling and functionality, it definitely had room for improvement, so when family friends expressed desire for a solution for their business with similar user requirements, I leapt at the opportunity.

## Design
User requirements specified the app would need CRUD operations for hair products, orders and sales of said products. Translating an initial entity-relationship diagram to a relational schema, I was left with this:
<img src="resources/db/inventory-schema.png">

As a student with limited experience with cloud serving solutions and a pre-owned Raspberry Pi board without enough RAM for Mincecraft server hosting, I followed [this handy guide](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-ubuntu-18-04) to set up Apache HTTP server, MariaDB (MySQL Fork) and PHP. With some port-forwarding and a cheap DNS, the Fringe Hair Salon Inventory Management System went live!

## Appearance 
After logging in, the app lands users on the products tab.
<img src="resources/screenshots/fringe-products.png">
Clicking on a product allows the user to view and/or edit item fields...
<img src="resources/screenshots/fringe-edit-product.png">
and likewise a tabular layout to edit order/sale details.
<img src="resources/screenshots/fringe-edit-order.png">
I tried to keep the interface clean and user-friendly with large iconography and text, on-hover highlighted buttons and specific errors for mandatory form fields.

## Security
Though the web app doesn't contain any highly sensitive data, I added mimimal set of defense by adding
- A login system using PHP's Session and one-way password hashing
- Prepared data objects and prepared statements to mitigate SQL injection attacks

## Lessons learned
- Though appearing to be the path of least resistance, iteratively building a web app using native PHP can get messy and to a less readable codebase without refactoring. In the future I'd want to try a framework such as Laravel to increase code reusability and easily manage security.
- Also in efforts to streamline development, I used minimal JavaScript, leading to more complicated POST logic and extra confirmation pages. Adding a few snippets would have made the site more dynamic adding to the user experience.
## Next Steps
- Though deploying on a Raspberry Pi hasn't caused any issues so far, I'm looking to revamp the app with a containerized instance on a Cloud provider to ensure more reliability and resiliancy in case of a hardware issue.
- By redesigning the front end with a Javascript framework such as React, the webpage could include more sophisticated UI interactions, especially when handling data field edits and displaying item, order and sale lists.
- At the same time, redoing the backend as an isolated service would allow for experimentation with a Serverless framework and a clearer understanding of client-server architecture.
