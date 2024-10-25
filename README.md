# Candidate Brief

## Background

You are working as a **Software Engineer** for a company that operates an online clothing store. The company manages its **clothing inventory** via an internal repository, which is stored in a ZIP file located here and is referenced in a sample project (details further on):

> **..\Api\compareclub-repository.zip**

The **`CompareClub.Repository.Clothing`** repository provides access to methods that allow you to manipulate the clothing inventory.

## Available Methods in the Repository

1. `getAllClothes`: Retrieve a list of all clothing items in the inventory.
2. `add`: Add a new clothing item to the inventory.
3. `update`: Update details of an existing clothing item.

## Your Task

You will need to write a PHP REST API which will be used by the company website to consume this repository. This should be production ready code that can be supported!

This API needs to be **production quality** code, meaning:

- It should be reliable, maintainable, and easy to extend.
- It should follow best practices for API design.
- It should be capable of future support and potential scalability.

This service should be able to perform the following:

1. Insert new clothing
2. Update existing clothing.
3. Calculate the discount on a list of supplied clothes to purchase according to the rules mentioned below.

### Discount Rules

Your API must be able to calculate discounts on a list of clothing items sent to the service. The following discount rules apply and can be **cumulative** (meaning multiple discounts can apply at the same time):

1. Apply a **10% discount** if the **total cost** exceeds **$100**.
2. Apply a **5% discount** if the **number of items** in the purchase is **more than 2**.
3. Apply a **3% discount** if any item in the order is **size Large**.

Your API should ensure that it applies all qualifying discounts to the final total for any purchase.

## Starter Project

A Laravel/Lumen project has been supplied which uses the standard template but **`CompareClub.Repository.Clothing`** has been referenced so that all you need to do is add your features on top. 

You can complete the solution either using this supplied starter project using Laravel/Lumen or any other framework. Feel free to upgrade/downgrade to a version you have available. You can restructure the solution to your liking and use any 3rd party libraries.

To use:

- Extract the files to a directory
- Run `composer install`
- Run the Api: `php -S localhost:8000 -t public`
- The sample endpoint has been setup as `localhost:8000/api/clothing` but feel free to change this as you prefer

### NOTES

Please DO NOT UPLOAD YOUR CODE to a public site like github, gitlab or bitbucket for instance.

We can't provide any more information, so please make the relevant assumptions. 
If you like, you can include documentation/readme on these assumptions.

### HINTS

1. Follow the brief and the requirements!

2. You should use this opportunity to demonstrate that you have the technical knowledge to be successful as an engineer at the level you are applying for or better.
Remember that a senior engineer or higher will be a person who is not just an "order taker" that does the work, but is someone who can provide input to design decisions, follow best practices, perform peer reviews, and mentoring other developers.

3. If theres common code/scenarios that you have written then you dont need to do this everywhere. Its ok to leave a note for us so that given more time
you would complete it. We just want to see how you've written it and what your approach is. For instance, if you were writing unit tests then if you cover
one get scenario you can describe what you would do in other get scenarios if that was applicable.

## SUBMISSION INSTRUCTIONS

Please upload the completed test through the Google Form https://forms.gle/ZY2j8Geuts9rKXsJ7 (you dont need to include composer dependencies/packages vendor folder) and follow these guidelines:

- Compress your submission in a .zip extension file (no rar or 7z)
- Name your file in this format: Your Full Name - Your city - Seniority level you are applying for. Examples:
  - John Doe - Sydney - Junior.zip
  - Mary Jane - India - Mid.zip
  - Harry Osborn - Philippines - Senior.zip 
  - Peter Parker - Melbourne - Lead.zip